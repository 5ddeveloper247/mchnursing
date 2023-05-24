<div class="row">
    <div class="col-xxl-9 col-xl-8">
        <div class="row reward-paginations align-items-center">
            <div class="col-lg-4 col-xl-5 col-xxl-3 d-none d-lg-block">

                <p>Showing <strong>{{$paginator->firstItem()}}-{{$paginator->lastItem()}}</strong> from
                    <strong>{{$paginator->total()}}</strong> data</p>
            </div>
            <div class="col-lg-8 col-xl-7 col-xxl-9">
                @if ($paginator->hasPages())
                    <ul class="paginations justify-content-center justify-content-lg-end">

                        @if ($paginator->onFirstPage())
                            <li class="paginations-list disabled"><a href="#" class="prev"><i
                                        class="fa fa-caret-left"></i></a></li>
                        @else
                            <li class="paginations-list"><a href="{{ $paginator->previousPageUrl() }}" class="prev"><i
                                        class="fa fa-caret-left"></i></a></li>
                        @endif


                        @foreach ($elements as $element)

                            @if (is_string($element))
                                <li class="paginations-list"><a href="#" class="paginations-links "
                                                                aria-current="page">{{ $element }}</a>
                                </li>
                            @endif



                            @if (is_array($element))
                                @foreach ($element as $page => $url)

                                    @if ($page == $paginator->currentPage())
                                        <li class="paginations-list"><a href="#" class="paginations-links active"
                                                                        aria-current="page">{{ $page }}</a>
                                        </li>
                                    @else
                                        <li class="paginations-list"><a href="{{ $url }}" class="paginations-links "
                                                                        aria-current="page">{{ $page }}</a>
                                        </li>
                                    @endif

                                @endforeach
                            @endif
                        @endforeach


                        @if ($paginator->hasMorePages())
                            <li class="paginations-list"><a href="{{ $paginator->nextPageUrl() }}" class="next"><i
                                        class="fa fa-caret-right"></i></a></li>
                        @else
                            <li class="paginations-list disabled"><a href="#"> <i class="fa fa-caret-right"></i> </a>
                            </li>
                        @endif

                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
