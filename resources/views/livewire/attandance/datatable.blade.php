<div :wire:key="student-list">
    <style>
        .QA_section.check_box_table .QA_table .table thead tr th:first-child, .QA_table .table tbody td:first-child {
            padding-left: 25px !important;
        }

        .QA_section.check_box_table .QA_table .table thead tr th {
            padding-left: 12px !important;
        }

        .QA_section .QA_table .table thead th {
            vertical-align: middle !important;
        }

    </style>
    <div>
        <div
            @if (is_numeric($refresh))
            wire:poll.{{ $refresh }}ms
            @elseif(is_string($refresh))
            @if ($refresh === '.keep-alive' || $refresh === 'keep-alive')
            wire:poll.keep-alive
            @elseif($refresh === '.visible' || $refresh === 'visible')
            wire:poll.visible
            @else
            wire:poll="{{ $refresh }}"
            @endif
            @endif
            class="container-fluid p-0"
        >
            @include('livewire.partials.org_attendance_class_filter',compact('categories'))

            <div class="d-md-flex justify-content-between mb_15">

                <div class="d-md-flex">
                    <div>
                        @include('livewire.partials.org_position_select',compact('positions'))
                    </div>
                </div>
                <div class="d-md-flex">
                    <div>
                        @include('livewire.partials.org_student_status_select',compact('positions'))
                    </div>
                </div>


                <div class="d-md-flex">
                    <div>

                        @include('livewire.partials.search')
                    </div>
                </div>
                <div class="d-md-flex">
                    <div>

                        @include('livewire-tables::bootstrap-4.includes.column-select')
                    </div>
                </div>
                <div class="d-md-flex">
                    <div class=" btn-group">
                        @if($this->selectedRowsQuery->count()!=0)
                            <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 pl-3 pr-3 pt_10 line-height-14"
                               href="#" id="deleteStudent"><i
                                    class="ti-trash"></i>{{__('common.Delete')}}</a>
                        @endif
                        <a class="primary-btn radius_30px mr-10 fix-gr-bg mt-10 pl-3 pr-3 pt_10 line-height-14Modules/Org/Resources/views/material/index.blade.php"
                           href="#" wire:click="export()"><i
                                class="ti-download"></i>{{__('org.Export')}}</a>
                        <div class="mr-10 fix-gr-bg mt-10  pr-3 ">


                        </div>

                    </div>
                </div>
            </div>

            @include('livewire-tables::bootstrap-4.includes.table')
            @include('livewire-tables::bootstrap-4.includes.pagination')

            <input type="hidden" id="showAddBtn" value=" {{$showAddBtn?'1':'0'}}">
            <input type="hidden" id="org_chart" value=" {{$org_chart}}">
            <input type="hidden" id="selectedRow" value=" {{$this->selectedRowsQuery->count()}}">
            @if($this->selectedRowsQuery->count()!=0)

                @foreach($this->selectedRowsQuery->get() as $row)
                    <input type="hidden" name="selectedRowsId[]" value="{{$row->id}}">
                @endforeach
            @endif

        </div>

        @php
            //@dump()
        @endphp
        {{--        @dump($this->selectedRowsQuery->get(['id']))--}}
    </div>
    @push('js')
        <script>

        </script>
    @endpush

    <script>


    </script>
</div>
