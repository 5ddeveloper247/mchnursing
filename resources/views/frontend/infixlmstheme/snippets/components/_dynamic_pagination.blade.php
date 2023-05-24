@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link prevDynamicPage" href="#" rel="prev"
                       aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif


            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" data-page="{{$page}}" aria-current="page"><span
                                    class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link changeDynamicPage"
                                   href="#" data-page="{{$page}}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link nextDynamicPage" href="#" rel="next"
                       aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
<script>
    $(document).on('click', '.changeDynamicPage', function (e) {
        e.preventDefault();
        let $this = $(this);
        let page = $(this).data('page');
        loadData($this, page);
    });

    $(document).on('click', '.nextDynamicPage', function (e) {
        e.preventDefault();
        let $this = $(this);
        let page = $(this).closest('.pagination').find('.page-item.active').data('page');
        page = page + 1;
        loadData($this, page);
    });

    $(document).on('click', '.prevDynamicPage', function (e) {
        e.preventDefault();
        let $this = $(this);
        let page = $(this).closest('.pagination').find('.page-item.active').data('page');
        page = page - 1;
        loadData($this, page);
    });


    function loadData(element, page) {
        $('.preloader').fadeIn('slow');
        let div = element.closest('.dynamicData');
        let parent = div.parent();
        let data = {};

        $.each(parent.data(), function (i, v) {
            data['data-' + i.split(/(?=[A-Z])/).join('-').toLowerCase()] = v;
        });
        data['page'] = page;

        let url = div.data('dynamic-href');
        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            dataType: 'html',
            success: function (res) {
                div.html(res);
                $('.preloader').fadeOut('slow');

            }
        });
    }

    if ($.isFunction($.fn.lazy)) {
        $('.lazy').lazy();
    }
    if ($.isFunction($.fn.niceSelect)) {
        if ($('.small_select').length > 0) {
            $('.small_select').niceSelect();
        }
    }

</script>
