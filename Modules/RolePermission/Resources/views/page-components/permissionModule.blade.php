@php
    //    if (isModuleActive('Org')){
    //        $ignore =[
    //            'regular_student_import',
    //            'student.new_enroll',
    //            'student.student_field',
    //            'student.courses',
    //            'usertype',
    //            'staffs.index',
    //            'hr.department.index',
    //            'homework_list',
    //            'staffs.settings',
    //            'permission.roles.index',
    //            'admin.enrollLogs',
    //            'admin.instructor.payout'
    //        ];
    //    }else{
    //          $ignore =[
    //              'permission.student-roles',
    //              'org.branch',
    //              'org.position'
    //          ];
    //
    //    }
    //   @if(!$submenu->module ||  isModuleActive($menu->module))
         $subMenus =$permissions->where('parent_route',$Module->route)
@endphp

<div class="single_role_blocks">
    <div class="single_permission" id="{{ $Module->id }}">
        <div class="permission_header d-flex align-items-center justify-content-between">
            <div>
                <input type="checkbox" name="module_id[]" value="{{ $Module->id }}" id="Main_Module_{{ $key }}"
                       class="common-radio permission-checkAll main_module_id_{{ $Module->id }}" {{ $role->permissions->contains('id',$Module->id) ? 'checked' : '' }} >
                <label for="Main_Module_{{ $key }}">{{ $Module->name }}</label>
            </div>
            @if(count($subMenus)!=0)
                <div class="arrow collapsed" data-toggle="collapse" data-target="#Role{{ $Module->id }}"></div>
            @endif
        </div>

        <div id="Role{{ $Module->id }}" class="collapse">
            <div class="permission_body">
                <ul>
                    @foreach ($subMenus->where('menu_status',1) as $SubMenu)

                        @if(!$SubMenu->module ||  isModuleActive($SubMenu->module))

                            @php

                                if ($SubMenu->theme && $SubMenu->theme!=currentTheme()){
                                    continue;
                                }
                            @endphp
                            <li>
                                <div class="submodule">
                                    <input id="Sub_Module_{{ $SubMenu->id }}" name="module_id[]"
                                           value="{{ $SubMenu->id }}"
                                           class="infix_csk common-radio  module_id_{{ $Module->id }} module_link"
                                           {{ $role->permissions->contains('id',$SubMenu->id) ? 'checked' : '' }}  type="checkbox">

                                    <label
                                        for="Sub_Module_{{ $SubMenu->id }}">{{$SubMenu->name}}</label>
                                    <br>
                                </div>

                                <ul class="option">
                                    @php
                                        //                                    if (isModuleActive('Org')){
                                        //                                        $ignore2 =[
                                        //                                            'student.courses',
                                        //                                        ];
                                        //                                        $SubMenu->actionList =$ActionList->where('parent_route',$SubMenu->route)->whereNotIn('route',$ignore2);
                                        //                                    }else{
                                        //                                        $SubMenu->actionList =$ActionList->where('parent_route',$SubMenu->route);
                                        //                                    }

                                                                            $SubMenu->actionList =$permissions->where('parent_route',$SubMenu->route)
                                    @endphp
                                    @foreach ($SubMenu->actionList as $action)
                                        @if(!$action->module ||  isModuleActive($action->module))
                                            @php
                                                if ($action->theme && $action->theme!=currentTheme()){
                                                      continue;
                                                  }
                                            @endphp
                                            <li>
                                                <div class="module_link_option_div" id="{{ $SubMenu->id }}">
                                                    <input id="Option_{{  $action->id }}" name="module_id[]"
                                                           value="{{  $action->id }}"
                                                           class="infix_csk common-radio module_id_{{ $Module->id }} module_option_{{ $Module->id }}_{{ $SubMenu->id }} module_link_option"
                                                           {{ $role->permissions->contains('id',$action->id) ? 'checked' : ''  }}  type="checkbox">
                                                    <label
                                                        for="Option_{{  $action->id }}">{{ $action->name}}</label>
                                                    <br>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
