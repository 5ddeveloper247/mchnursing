<?php

namespace App\Http\Livewire;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ShowStudents extends DataTableComponent
{
    use WithPagination;

    public array $bulkActions = [
        'exportSelected' => 'Export',
    ];
    public $table = 'users';
    public bool $columnSelect = true;
    public bool $rememberColumnSelection = true;


    public $pos, $showAddBtn = false, $org_chart;
    protected $listeners = ['addBranchFilter', 'addPositionFilter', 'checkOrgChart', 'refreshDatatable' => '$refresh'];
    public $page = 1;
    protected $students = [];
    public $branchCodes = [];
    public $position = null;
    public $serial = 0;

    public function mount()
    {
        $this->pos = null;
        $this->showAddBtn = false;
        $this->org_chart = '';
    }

    public function selectPosition()
    {
        $this->emit('addPositionFilter', $this->pos);
        $this->resetPage();
//        $this->emit('refreshDatatable');
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


    public function columns(): array
    {
        return [
            Column::make(__('common.SL'), 'sl')->selected(),
            Column::make(__('common.Username'), 'username')
                ->sortable()
                ->searchable(),
            Column::make(__('common.Name'), 'name')
                ->sortable()
                ->selected()
                ->searchable(),
            Column::make(__('org.Org Chart'), 'org_chart_code')
                ->sortable()
                ->selected()
                ->searchable(),

            Column::make(__('org.Position'), 'org_position_code')
                ->sortable()
                ->selected()
                ->searchable(),

            Column::make(__('org.Employee ID'), 'employee_id')
                ->sortable()
                ->selected()
                ->searchable(),
            Column::make(__('common.Email'), 'email')
                ->sortable()
                ->selected()
                ->searchable(),
            Column::make(__('common.Date of Birth'), 'dob')
                ->sortable()
                ->selected()
                ->searchable(),

            Column::make(__('common.gender'), 'gender')
                ->sortable()
                ->selected()
                ->searchable(),

            Column::make(__('org.Start working date'), 'start_working_date')
                ->sortable()
                ->selected()
                ->searchable(),

            Column::make(__('common.Phone'), 'phone')
                ->sortable()
                ->selected()
                ->searchable(),

            Column::make(__('common.Status'), 'status')
                ->selected()
                ->sortable()
        ];
    }

    public function query()
    {
        $this->serial = ($this->page - 1) * 10;

        $query = User::where('teach_via', 1)->with('position', 'branch');
        if (isModuleActive('UserType')) {
            $query->whereHas('userRoles', function ($q) {
                $q->where('role_id', 3);
            });
        } else {
            $query->where('role_id', 3);
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
            $query->whereIn('org_chart_code', $ids);

        }
        if (Auth::user()->role_id != 1) {
            $assign_code = [];
            if (Auth::user()->policy) {
                $branches = Auth::user()->policy->branches;
                foreach ($branches as $branch) {
                    $assign_code[] = $branch->branch->code;
                }
            }
            $query->whereIn('org_chart_code', $assign_code);
        }

        if (!empty($this->position)) {
            $query->where('org_position_code', $this->position);
        }
        $query->latest();
        return $query;
    }

    public function rowView(): string
    {

        $this->emptyMessage = trans("common.No data available in the table");
        return 'livewire.student.row';
    }

    public function paginationView()
    {
        return 'backend.partials._pagination';
    }

    public function render()
    {
        $positions = OrgPosition::orderBy('order', 'asc')->get();
        return view('livewire.student.datatable')
            ->with([
                'columns' => $this->columns(),
                'rowView' => $this->rowView(),
                'filtersView' => $this->filtersView(),
                'customFilters' => $this->filters(),
                'rows' => $this->rows,
                'modalsView' => $this->modalsView(),
                'bulkActions' => $this->bulkActions,
                'positions' => $positions,


            ]);
    }


}
