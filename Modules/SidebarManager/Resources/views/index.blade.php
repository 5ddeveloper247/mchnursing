@extends('backend.master')
@push('styles')
    <link rel="stylesheet" href="{{asset('Modules/SidebarManager/Resources/assets/css/style.css')}}"/>
    <link rel="stylesheet" href="{{asset('Modules/SidebarManager/Resources/assets/css/icon-picker.css')}}"/>
@endpush

@section('mainContent')
    @php
        $LanguageList = getLanguageList();
    @endphp
    <div class="role_permission_wrap">
        <div class="permission_title d-flex flex-wrap justify-content-between mb_20">
            <h4>{{ trans('setting.Sidebar Manager') }}</h4>
            <a href="#" id="resetMenu"
               class="primary-btn radius_30px mr-10 fix-gr-bg">{{__('setting.Reset to default')}}</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb_20">
            <div class="white-box available_box  student-details ">
                <div class="add-visitor">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header pt-0 pb-0" id="headingOne">
                                <h5 class="mb-0 create-title" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="false"
                                    aria-controls="collapseOne">
                                    <button class="btn btn-link add_btn_link">
                                        {{__('common.Add')}}       {{__('common.Section')}}
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                 data-parent="#accordion">
                                <div class="card-body">
                                    <form action="" id="addSectionForm">
                                        <div class="row pt-0">
                                            @if(isModuleActive('FrontendMultiLang') || isModuleActive('Org'))
                                                <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                    role="tablist">
                                                    @foreach ($LanguageList as $key => $language)
                                                        <li class="nav-item">
                                                            <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                               href="#element{{$language->code}}"
                                                               role="tab"
                                                               data-toggle="tab">{{ $language->native }}  </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                        <div id="row_element_div">
                                            <div class="tab-content">
                                                @foreach ($LanguageList as $key => $language)
                                                    <div role="tabpanel"
                                                         class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                         id="element{{$language->code}}">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label"
                                                                           for="name">{{ __('common.Name') }} <span
                                                                            class="textdanger">*</span>
                                                                    </label>
                                                                    <input class="primary_input_field name section_name"
                                                                           type="text"
                                                                           id=""
                                                                           name="name[{{$language->code}}]"
                                                                           autocomplete="off"
                                                                           placeholder="{{__('common.Name')}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-lg-12 text-center">
                                                <button id="addSectionBtn" type="button"
                                                        class="primary-btn fix-gr-bg submit_btn "
                                                        data-toggle="tooltip"
                                                        title="" data-original-title="">
                                                    <span class="ti-check"></span>
                                                    {{__('common.Save')}} </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if(isModuleActive('Org'))
                            <div class="card mt-2">
                                <div class="card-header pt-0 pb-0" id="headingTwo">
                                    <h5 class="mb-0 create-title" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        <button class="btn btn-link add_btn_link">
                                            {{__('common.Add')}}       {{__('common.Menu')}}
                                        </button>
                                    </h5>
                                </div>
                                @if(isModuleActive('Org') || isModuleActive('FrontendMultiLang'))
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <form action="" id="addMenuForm">

                                                <div class="row pt-0">
                                                    @if(isModuleActive('FrontendMultiLang') || isModuleActive('Org'))
                                                        <ul class="nav nav-tabs no-bottom-border  mt-sm-md-20 mb-10 ml-3"
                                                            role="tablist">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <li class="nav-item">
                                                                    <a class="nav-link  @if (auth()->user()->language_code == $language->code) active @endif"
                                                                       href="#element1{{$language->code}}"
                                                                       role="tab"
                                                                       data-toggle="tab">{{ $language->native }}  </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                    <div class="col-lg-12">
                                                        <div class="tab-content">
                                                            @foreach ($LanguageList as $key => $language)
                                                                <div role="tabpanel"
                                                                     class="tab-pane fade @if (auth()->user()->language_code == $language->code) show active @endif  "
                                                                     id="element1{{$language->code}}">


                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="name">{{ __('common.Label') }} <span
                                                                                class="textdanger">*</span>
                                                                        </label>
                                                                        <input
                                                                            class="primary_input_field name menu_name"
                                                                            type="text"
                                                                            name="label[{{$language->code}}]"
                                                                            autocomplete="off"
                                                                            placeholder="{{__('common.Label')}}">
                                                                    </div>


                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label"
                                                                   for="name">{{ __('common.Route') }} {{ __('common.Name') }}

                                                                <span
                                                                    class="textdanger">*</span>
                                                            </label>
                                                            <input class="primary_input_field name route_name"
                                                                   type="text"

                                                                   name="route" autocomplete="off"
                                                                   placeholder="{{__('common.Route')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <button id="addMenuBtn" type="button"
                                                                class="primary-btn fix-gr-bg submit_btn"
                                                                data-toggle="tooltip"
                                                                title="" data-original-title="">
                                                            <span class="ti-check"></span>
                                                            {{__('common.Save')}} </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endif
                    </div>
                    <div class="mt_20" id="available_menu_div">
                        @include('sidebarmanager::components.available_list')
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb_20">
            <div class="white-box">
                <input type="hidden" name="data" id="items-data" value="">
                <div class="add-visitor" id="menu_idv">
                    @include('sidebarmanager::components.components')
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="white-box">
                <div class="add-visitor" id="live_preview_div">
                    @include('sidebarmanager::components.live_preview')
                </div>
            </div>
        </div>
    </div>

    {{--    @include('sidebarmanager::components.edit_modal')--}}
@endsection



@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{asset('Modules/SidebarManager/Resources/assets/js/icon-picker.js')}}"></script>
    <script>
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $("#previewMenu").metisMenu();
                initSortable();

                function initSortable() {
                    $('#itemDiv').sortable({
                        cursor: "move",
                        containment: "parent",
                        update: function (event, ui) {
                            let ids = $(this).sortable('toArray', {attribute: 'data-id'});
                            let data = {
                                ids: ids,
                                _token: '{{ csrf_token() }}'
                            };
                            $.post("{{ route('sidebar-manager.sort-section') }}", data, function (response) {
                                reloadAfterChange(response)
                            }).fail(function (response) {
                                if (response.responseJSON.error) {
                                    toastr.error(response.responseJSON.error, "{{__('common.Error')}}");
                                    hidePreloader()
                                    return false;
                                }
                            });

                        }
                    }).disableSelection();


                    $('.dd-list').sortable({
                        cursor: "move",
                        connectWith: ".dd-list",
                        items: '.dd-item',
                        scroll: true,
                        helper: 'clone',
                        appendTo: 'body',
                        update: function (event, ui) {

                            makeFirstChildRoot();
                            saveItemsPosition();
                            checkEmptyList();
                        },
                        receive: function (event, ui) {
                            let parent_id = event.target.attributes[1].value;
                            let section_id = event.target.attributes[2].value;

                            ui.item.attr("data-section_id", parent_id);
                            ui.item.attr("data-parent_id", parent_id);
                            ui.item.removeClass('ml_20')


                            makeFirstChildRoot();
                            saveItemsPosition();
                            checkEmptyList();
                        }
                    });
                }


                function checkEmptyList() {
                    $('.dd-list').each(function () {
                        if ($(this).has("div").length < 1) {
                            $(this).html(`
                                  <span class="empty_list">No more items available</span>
                              `);
                        } else {
                            $(this).find('.empty_list').remove();
                        }
                    })
                }

                function makeFirstChildRoot() {
                    $(".menu-list div:first-child").removeClass("ml_20");
                }

                function reloadAfterChange(response) {

                    $('#menu_idv').html(response.menus);
                    $('#available_menu_div').html(response.available_list);
                    $('#live_preview_div').html(response.live_preview);
                    $("#previewMenu").metisMenu();
                    hidePreloader();
                    initSortable();
                }

                //for update menu list
                function saveItemsPosition() {
                    var items = [];
                    let new_parent = '';
                    $(".menu_item_div .listed_menu").each(function () {
                        var id = $(this).attr("data-id");
                        var section_id = $(this).attr("data-section_id");
                        var parent_id = $(this).attr("data-parent_id");
                        if (parent_id == undefined) {
                            parent_id = $(this).prev().attr('data-section_id');
                        }
                        if (section_id == undefined) {
                            section_id = $(this).prev().attr('data-section_id');
                        }

                        if (id) {

                            var itemObject = {id: id, parent_id: parent_id, section_id: section_id};
                            //sub menu
                            if ($(this).hasClass("ml_20")) {
                                $(this).addClass('sub_menu_item')
                                $(this).removeClass('menu_item')

                                itemObject["is_sub_menu"] = "1";
                                if (new_parent != '') {
                                    parent_id = new_parent;
                                }
                                itemObject["parent_id"] = parent_id;
                                $(this).attr("data-parent_id", parent_id);
                            } else {
                                new_parent = id;
                                $(this).removeClass('sub_menu_item')
                                $(this).addClass('menu_item')
                            }
                            items.push(itemObject);
                        }
                    });

                    //convert array to json data and save into an input field
                    if (Object.keys(items).length) {
                        $("#items-data").val(JSON.stringify(items));
                        let ids = JSON.stringify(items);

                        $.post("{{route('sidebar-manager.menu-update')}}", {
                            '_token': '{{ csrf_token() }}',
                            'ids': ids
                        }, function (response) {
                            reloadAfterChange(response)
                        })
                            .fail(function (response) {
                                if (response.responseJSON.error) {
                                    toastr.error(response.responseJSON.error, "{{__('common.Error')}}");
                                    hidePreloader()
                                    return false;
                                }
                            });

                    } else {
                        $("#items-data").val("");
                    }
                }

                $(document).on('click', '.make-sub-menu', function () {
                    console.log('make submenu')
                    var $item = $(this).closest(".listed_menu");
                    let previous_id = $item.prev().data('parent_id');
                    $item.attr('data-parent_id', previous_id);
                    console.log(previous_id)

                    var $clickableIcon = $(this).closest(".toggle-menu-icon");
                    $item.addClass("ml_20");
                    $clickableIcon.addClass("make-root-menu");
                    $clickableIcon.removeClass("make-sub-menu");
                    $clickableIcon.html("<i class='ti-back-right'></i>");
                    saveItemsPosition();
                    // feather.replace();
                });

                $(document).on('click', '#menuUpdate', function () {

                    let formElement = $('#menuEditForm').serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");


                    $.ajax({
                        url: "{{route('sidebar-manager.menu-edit')}}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            $('#commonModal').modal('hide');
                            reloadAfterChange(response)
                            toastr.success("{{__('common.Operation successful')}}", "{{__('common.Success')}}");
                        },
                        error: function (response) {
                            $.each(response.responseJSON.errors, function (k, v) {
                                toastr.error(v, "{{__('common.Error')}}");
                            });
                        }
                    });
                    {{--$.post("{{route('sidebar-manager.menu-edit')}}", formData, function (response) {--}}
                    {{--    reloadAfterChange(response);--}}
                    {{--});--}}

                });

                $(document).on('click', '#sectionUpdate', function () {

                    let formElement = $('#sectionEditForm').serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        url: "{{route('sidebar-manager.section-edit')}}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            $('#commonModal').modal('hide');
                            reloadAfterChange(response)
                            toastr.success("{{__('common.Operation successful')}}", "{{__('common.Success')}}");
                        },
                        error: function (response) {
                            $.each(response.responseJSON.errors, function (k, v) {
                                toastr.error(v, "{{__('common.Error')}}");
                            });
                        }
                    });

                });


                //make root menu
                $(document).on('click', '.make-root-menu', function () {
                    console.log('make menu')
                    var $item = $(this).closest(".listed_menu");
                    var parent_id = $item.prev().attr('data-section_id');
                    $item.attr('data-parent_id', parent_id);
                    var $clickableIcon = $(this).closest(".toggle-menu-icon");
                    $item.removeClass("ml_20");
                    $clickableIcon.removeClass("make-root-menu");
                    $clickableIcon.addClass("make-sub-menu");
                    $clickableIcon.html("<i class='ti-back-left'></i>");

                    saveItemsPosition();
                    // feather.replace();
                });

                $(document).on('click', '.remove_menu', function () {
                    //restore the selected item to item container
                    var $item = $(this).closest(".listed_menu"),
                        itemClone = $item.clone();
                    let id = $item.data('id');

                    //don't restore custom menu item
                    itemClone.removeClass("ml_20");
                    $("#available_list").append(itemClone);

                    //remove drag/drop text from item container
                    removeEmptyAreaText($("#available_list"));

                    //remove the row finally
                    $item.fadeOut(300, function () {
                        $item.remove();


                        let data = {
                            id: id,
                            _token: "{{csrf_token()}}"
                        }
                        showPreloader()
                        $.post('{{route('sidebar-manager.menu-remove')}}', data, function (response) {
                            reloadAfterChange(response)
                        });


                        saveItemsPosition();
                        checkEmptyList();
                        // addEmptyAreaText($(".sortable-items-container"));
                    });
                    // adjustHeightOfItemsContainer();
                });

                //remove drag/drop text from new added area if there is no elements available
                function removeEmptyAreaText(index) {
                    if ($(index).has("div").length > 0) {
                        $(index).find("span.empty-area-text").remove();
                    }
                }


                $(document).on('click', '.toggle_up_down', function (event) {
                    $(this).parent().parent().siblings(".menu_list").toggleClass('d-none');
                    if ($(this).hasClass('ti-angle-up')) {
                        $(this).removeClass('ti-angle-up');
                        $(this).addClass('ti-angle-down');
                    } else if ($(this).hasClass('ti-angle-down')) {
                        $(this).removeClass('ti-angle-down');
                        $(this).addClass('ti-angle-up');
                    }
                });
                // addSectionBtn
                $(document).on('click', '#addSectionBtn', function (event) {
                    event.preventDefault();
                    showPreloader();
                    let formElement = $('#addSectionForm').serializeArray()
                    let formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });

                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        url: "{{route('sidebar-manager.section.store')}}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            hidePreloader();
                            reloadAfterChange(response)
                            $('.section_name').val('');
                            // initSortable();
                            toastr.success("{{__('common.Operation successful')}}", "{{__('common.Success')}}");
                        },
                        error: function (response) {
                            hidePreloader()

                            $.each(response.responseJSON.errors, function (k, v) {
                                toastr.error(v, "{{__('common.Error')}}");
                            });
                        }
                    });

                });

                $(document).on('click', '#addMenuBtn', function (event) {
                    event.preventDefault();
                    showPreloader();
                    var formElement = $('#addMenuForm').serializeArray()
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });


                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        url: "{{route('sidebar-manager.menu-store')}}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function (response) {
                            reloadAfterChange(response)
                            $('.menu_name').val('');
                            $('.route_name').val('');
                            toastr.success("{{__('common.Operation successful')}}", "{{__('common.Success')}}");
                        },
                        error: function (response) {
                            hidePreloader();

                            $.each(response.responseJSON.errors, function (k, v) {
                                toastr.error(v, "{{__('common.Error')}}");
                            });

                        }
                    });

                });

                $(document).on('click', '.delete_section', function () {
                    let id = $(this).data('id');
                    let data = {
                        id: id,
                        _token: "{{csrf_token()}}"
                    }
                    showPreloader();
                    $.post('{{route("sidebar-manager.delete-section")}}', data, function (response) {
                        reloadAfterChange(response)
                    });
                });

                $(document).on('click', '#resetMenu', function (event) {
                    event.preventDefault();
                    let data = {
                        _token: "{{csrf_token()}}"
                    }
                    showPreloader();
                    $.post('{{route("sidebar-manager.reset-own-menu")}}', data, function (response) {
                        if (response.msg == 'Success') {
                            toastr.success("{{__('common.Operation successful')}}", "{{__('common.Success')}}");
                            location.reload();
                        }
                    }).fail(function (response) {
                        if (response.responseJSON.error) {
                            toastr.error(response.responseJSON.error, "{{__('common.Error')}}");
                            hidePreloader()
                            return false;
                        }
                    });
                });

            });

            $(document).ready(function () {
                console.log("ready!");
            });


            function hidePreloader() {
                $('.preloader').fadeOut('slow');
            }

            function showPreloader() {
                $('.preloader').fadeIn('slow');
            }
        })(jQuery);


    </script>

@endpush
