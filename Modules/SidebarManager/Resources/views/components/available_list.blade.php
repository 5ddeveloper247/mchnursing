<h4>{{__('common.Available menu items')}}</h4>
<div class="">
    <div class="row">
        <div class="col-xl-12">
            <!-- menu_setup_wrap  -->
            <div class="dd available_list">
                <div class="dd-list min-height-400 available-items-container" data-id="remove" data-section_id="remove"
                     id="available_list">

                    @isset($unused_menus)
                        @if($unused_menus->count())
                            @foreach($unused_menus as $menu)

                                <div class="dd-item listed_menu" data-id="{{$menu->id}}"
                                     data-parent_id="{{$menu->parent_route}}">
                                    <div class="dd-handle">
                                        <div class="menu_icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                            <span class="make-sub-menu toggle-menu-icon">
                                                <i class="ti-back-left"></i>
                                            </span>
                                        <i class="ti-close remove_menu"></i>
                                    </div>
                                </div>

                            @endforeach
                        @else
                            <span class=' empty_list'>{{__('common.No more items available')}}</span>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
