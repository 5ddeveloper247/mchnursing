<?php

namespace App\Http\Livewire;

use App\Exports\OrgAttendanceList;
use App\Exports\OrgAttendanceStatistic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Modules\OrgSubscription\Entities\OrgAttendance;
use Modules\OrgSubscription\Entities\OrgCourseSubscription;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ShowOrgAttandanceStatistic extends DataTableComponent
{

    use WithPagination;

    public array $bulkActions = [

    ];
    public $table = 'courses';
    public bool $columnSelect = false;
    public bool $rememberColumnSelection = true;


    public $pos, $showAddBtn = false, $org_chart;
    protected $listeners = ['addBranchFilter', 'addPositionFilter', 'checkOrgChart', 'refreshDatatable' => '$refresh'];
    public $page = 1;
    protected $students = [];
    public $branchCodes = [];
    public $position = null;
    public $serial = 0;
    public $class_ids = [];
    public $student_status = 1;
    public $class_type = 'offline';
    public $attendance_rate = [];
    public $pass_rate = [];

    public function mount()
    {
        $this->pos = null;
        $this->showAddBtn = false;
        $this->org_chart = '';
        $this->attendance_rate['on_time'] = 0;
        $this->attendance_rate['late'] = 0;
        $this->attendance_rate['absence'] = 0;
        $this->pass_rate['pass'] = 0;
        $this->pass_rate['fail'] = 0;
    }

    public function selectPosition()
    {
        $this->emit('addPositionFilter', $this->pos);
        $this->resetPage();
    }

    public function addBranchFilter($branchCode)
    {
        if (($key = array_search($branchCode, $this->branchCodes)) !== false) {
            unset($this->branchCodes[$key]);
            $branch = OrgBranch::where('code', $branchCode)->first();
            $childs = $branch->getAllChildIds($branch);
            foreach ($childs as $child) {
                if (($key2 = array_search($child, $this->branchCodes)) !== false) {
                    unset($this->branchCodes[$key2]);
                }
            }
        } else {
            array_push($this->branchCodes, $branchCode);
        }
        $this->emit('checkOrgChart', $this->branchCodes);

    }

    public function checkOrgChart($codes)
    {
        if (count($codes) == 1) {
            $this->showAddBtn = true;
            $chart = OrgBranch::where('code', $codes[0] ?? '')->first();
            if ($chart) {
                $this->org_chart = $chart->fullPath;
            }
        } else {
            $this->showAddBtn = false;
        }
    }

    public function addPositionFilter($position)
    {
        $this->position = $position;
    }

    public function selectClass($type, $ids)
    {
        $this->class_type = $type;
        $this->class_ids = $ids;
        $this->resetPage();
    }

    public function selectStudentStatus($status)
    {
        $this->student_status = $status;
        $this->resetPage();
    }


    public function columns(): array
    {
        return [
            Column::make(__('org.Class'), 'class'),
            Column::make(__('courses.Course'), 'title')
                ->sortable(),
            Column::make(__('frontend.Enrolled'), 'total_enrolled')
                ->sortable(),
            Column::make(__('org-subscription.Absence'), 'absence'),
            Column::make(__('org-subscription.Late'), 'late'),
            Column::make(__('org-subscription.On Time'), 'on_time'),
            Column::make(__('org-subscription.Fail'), 'fail'),
            Column::make(__('org-subscription.Pass'), 'pass'),
            Column::make(__('org.Attend Rate'), 'attend_rate'),
            Column::make(__('org.Pass Rate'), 'pass_rate'),

        ];
    }

    public function query()
    {
        $this->serial = ($this->page - 1) * 10;

        $query = OrgCourseSubscription::where('type', 1);

        $query->whereHas('assign', function ($q) {
            $q->whereHas('course', function ($q2) {
                if ($this->class_type != 'offline') {
                    $q2->where('type', 3);
                    $q2->whereIn('id', $this->class_ids);
                }
            });
        });

        if ($this->class_type == 'offline') {
            if (count($this->class_ids) != 0) {
                $query->whereIn('id', $this->class_ids);
            }
        }

        if (count($this->branchCodes) != 0) {
            $ids = [];
            foreach ($this->branchCodes as $key => $code) {
                $branch = OrgBranch::where('code', $code)->first();
                if ($branch) {
                    $branchIds = $branch->getAllChildIds($branch, [$code]);
                    $ids = array_merge($ids, $branchIds);
                }
            }
//            $query->whereHas('user', function ($q) use ($ids) {
            $query->whereHas('checkouts.user', function ($q) use ($ids) {
                $q->whereIn('org_chart_code', $ids);
            });
        }


        if (!empty($this->position)) {
            $query->whereHas('checkouts.user', function ($q) {
                $q->where('org_position_code', $this->position);
            });
        }
        $query->whereHas('checkouts.user', function ($q) {
            $q->where('status', $this->student_status);
        });

//        start
        $total_enroll = 0;
        $plans = $query->get();
        $this->attendance_rate['on_time'] = 0;
        $this->attendance_rate['late'] = 0;
        $this->attendance_rate['absence'] = 0;
        $this->pass_rate['pass'] = 0;
        $this->pass_rate['fail'] = 0;


        foreach ($plans as $plan) {
            foreach ($plan->assign as $assign) {
                $total_enroll = $total_enroll + $assign->course->total_enrolled;
                $attendances = $assign->course->orgAttendance;
                $this->attendance_rate['on_time'] = $this->attendance_rate['on_time'] + $attendances->where('attend', 'O')->count();
                $this->attendance_rate['late'] = $this->attendance_rate['late'] + $attendances->where('attend', 'L')->count();
                $this->pass_rate['pass'] = $this->pass_rate['pass'] + $attendances->where('pass', '1')->count();

            }
        }

        $this->attendance_rate['absence'] = $total_enroll - ($this->attendance_rate['on_time'] + $this->attendance_rate['late']);
        $this->pass_rate['fail'] = $total_enroll - $this->pass_rate['pass'];
//end

        return $query;
    }

    public function rowView(): string
    {

        $this->emptyMessage = trans("common.No data available in the table");
        return 'livewire.attandance-statistic.row';
    }

    public function paginationView()
    {
        return 'backend.partials._pagination';
    }

    public function render()
    {
        $categories = Category::where('parent_id', null)->orderBy('name', 'asc')->get();
        $positions = OrgPosition::orderBy('order', 'asc')->get();
        return view('livewire.attandance-statistic.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'categories' => $categories,
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'positions' => $positions,


            ]);
    }

    public function updateChart()
    {
        /*$total_enroll = 0;
        $courses = $this->query()->get();

        $this->attendance_rate['on_time'] = 0;
        $this->attendance_rate['late'] = 0;
        $this->attendance_rate['absence'] = 0;
        $this->pass_rate['pass'] = 0;
        $this->pass_rate['fail'] = 0;


        foreach ($courses as $course) {
            $total_enroll = $total_enroll + $course->total_enrolled;

            $attendances = $course->orgAttendance;
            $this->attendance_rate['on_time'] = $this->attendance_rate['on_time'] + $attendances->where('attend', 'O')->count();
            $this->attendance_rate['late'] = $this->attendance_rate['late'] + $attendances->where('attend', 'L')->count();
            $this->pass_rate['pass'] = $this->pass_rate['pass'] + $attendances->where('pass', '1')->count();

        }

        $this->attendance_rate['absence'] = $total_enroll - ($this->attendance_rate['on_time'] + $this->attendance_rate['late']);
        $this->pass_rate['fail'] = $total_enroll - $this->pass_rate['pass'];*/
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function export()
    {
        $this->dispatchBrowserEvent('contentChanged');
        return Excel::download(new OrgAttendanceStatistic($this->query()), 'attendance_statistic.xlsx');
    }
}
