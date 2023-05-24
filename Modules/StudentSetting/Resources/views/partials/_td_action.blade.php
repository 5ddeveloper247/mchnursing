<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button"
            id="dropdownMenu2" data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
        {{trans('common.Action')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right"
         aria-labelledby="dropdownMenu2">
        @if (permissionCheck('student.secretLogin'))
            <a class="dropdown-item" href="{{route('secretLogin', $query->id)}}"
               type="button">{{trans('common.Secret Login') }}</a>
        @endif


            <a href="{{route('student.student.view', $query->id)}}"
                class="dropdown-item"
                type="button">{{trans('common.View') }}
            </a>


        @if (permissionCheck('student.edit'))
            <button
                data-item-id="{{$query->id}}"
                class="dropdown-item editStudent"
                type="button">{{trans('common.Edit') }}
            </button>
        @endif

        @if (permissionCheck('student.delete'))
            <button class="dropdown-item deleteStudent"
                    data-id="{{$query->id}}"
                    type="button">{{trans('common.Delete')}}
            </button>
        @endif

        @if (permissionCheck('student.courses'))
            <a class="dropdown-item" href="{{route('student.courses', $query->id)}}"
               data-id="{{$query->id}}" type="button">{{trans('courses.Course')}}</a>
        @endif

        @if (isModuleActive('SkillAndPathway'))
            <a class="dropdown-item" href="{{route('student.skillgroup', $query->id)}}"
               data-id="{{$query->id}}" type="button">{{trans('group.group')}}</a>
        @endif


    </div>
</div>
