<h4>{{__('common.Menu List')}}</h4>
<div class="">
    <div class="row">
        <div class="col-xl-12 menu_item_div" id="itemDiv">

            @if(isset($sections))
                @foreach($sections as $section)

                    <div class="closed_section" data-id="{{$section->id}}">
                        <!-- menu_setup_wrap  -->
                        @if(!empty($section->name))
                            <div class="section_nav">
                                <h5>{{$section->name}}</h5>
                                <div class="setting_icons">
                                     <span class="edit-btn">
                                                             <a class=" btn-modal"
                                                                data-container="#commonModal" type="button"
                                                                href="{{route('sidebar-manager.section-edit-form',$section->id)}}"
                                                             >
                                                           <i class="ti-pencil"></i>
                                                        </a>

                                                        </span>
                                    <i class="ti-close delete_section" data-id="{{$section->id}}"></i>
                                    <i class="ti-angle-up toggle_up_down"></i>
                                </div>
                            </div>
                        @endif
                        <div class="dd menu_list sortable-list">
                            @if($section->activeMenus->count())
                                <div class="dd-list menu-list" data-id="{{$section->id}}"
                                     data-section_id="{{$section->id}}">
                                    @foreach($section->activeMenus as $menu)
                                        @if(!$menu->module ||  isModuleActive($menu->module))
                                            @php
                                                $submenus =$section->activeSubmenus->where('parent_route',$menu->route)->where('parent_route','!=','dashboard');
                                                   if ($menu->theme && $menu->theme!=currentTheme()){
                                                    continue;
                                                }
                                            @endphp
                                            <div class="dd-item listed_menu menu_item"
                                                 data-id="{{$menu->id}}"
                                                 data-parent_id="{{$menu->id}}"
                                                 data-section_id="{{$section->id}}"
                                                 data-icon="{{$menu->icon}}"
                                                 data-name="{{$menu->name}}"
                                            >
                                                <div class="dd-handle">
                                                    <div class="menu_icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                             height="24"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round"
                                                             class="feather feather-move icon-16 text-off mr5">
                                                            <polyline points="5 9 2 12 5 15"></polyline>
                                                            <polyline points="9 5 12 2 15 5"></polyline>
                                                            <polyline points="15 19 12 22 9 19"></polyline>
                                                            <polyline points="19 9 22 12 19 15"></polyline>
                                                            <line x1="2" y1="12" x2="22" y2="12"></line>
                                                            <line x1="12" y1="2" x2="12" y2="22"></line>
                                                        </svg>
                                                    </div>
                                                    {{$menu->name}}
                                                </div>
                                                <div class="edit_icon">
                                                   <span class="edit-btn">
                                                        <a class=" btn-modal"
                                                           data-container="#commonModal" type="button"
                                                           href="{{route('sidebar-manager.menu-edit-form',$menu->id)}}"
                                                        >
                                                           <i class="ti-pencil"></i>
                                                        </a>

                                                   </span>
                                                    <span class="make-sub-menu toggle-menu-icon">
                                                    <i class="ti-back-left"></i>
                                                </span>
                                                    <i class="ti-close remove_menu"></i>
                                                </div>
                                            </div>
                                            @if($menu->route!='dashboard')
                                                @foreach($submenus as $submenu)
                                                    @if(!$submenu->module ||  isModuleActive($submenu->module))
                                                        @php
                                                            if ($submenu->theme && $submenu->theme!=currentTheme()){
                                                                  continue;
                                                              }
                                                        @endphp
                                                        <div class="dd-item listed_menu ml_20 sub_menu_item"
                                                             data-id="{{$submenu->id}}"
                                                             data-parent_id="{{$menu->id}}"
                                                             data-section_id="{{$section->id}}"
                                                             data-icon="{{$submenu->icon}}"
                                                             data-name="{{$submenu->name}}"
                                                        >
                                                            <div class="dd-handle">
                                                                <div class="menu_icon">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                         width="24"
                                                                         height="24" viewBox="0 0 24 24" fill="none"
                                                                         stroke="currentColor" stroke-width="2"
                                                                         stroke-linecap="round"
                                                                         stroke-linejoin="round"
                                                                         class="feather feather-move icon-16 text-off mr5">
                                                                        <polyline points="5 9 2 12 5 15"></polyline>
                                                                        <polyline points="9 5 12 2 15 5"></polyline>
                                                                        <polyline
                                                                            points="15 19 12 22 9 19"></polyline>
                                                                        <polyline
                                                                            points="19 9 22 12 19 15"></polyline>
                                                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                                                        <line x1="12" y1="2" x2="12" y2="22"></line>
                                                                    </svg>
                                                                </div>
                                                                {{$submenu->name}}
                                                            </div>
                                                            <div class="edit_icon">
                                                         <span class="edit-btn">
                                                             <a class=" btn-modal"
                                                                data-container="#commonModal" type="button"
                                                                href="{{route('sidebar-manager.menu-edit-form',$submenu->id)}}"
                                                             >
                                                           <i class="ti-pencil"></i>
                                                        </a>

                                                        </span>

                                                                <span class="make-root-menu toggle-menu-icon">
                                                            <i class="ti-back-right"></i>
                                                        </span>
                                                                <i class="ti-close remove_menu"></i>
                                                            </div>

                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endif
                                    @endforeach


                                </div>
                            @else
                                <div class="dd-list menu-list" data-id="{{$section->id}}"
                                     data-section_id="{{$section->id}}">
                                    <span class="empty_list">{{__('common.No more items available')}}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
