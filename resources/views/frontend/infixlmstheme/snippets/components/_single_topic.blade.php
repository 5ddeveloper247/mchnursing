@if(isset($result))
    <duv class="row">

        <div class="col-12">
            <div class="box_header d-flex flex-wrap align-items-center justify-content-between">
                <h5 class="font_16 f_w_500 mb_30">{{@$result->total()}} {{__('frontend.Course are found')}}</h5>
                <div class="box_header_right mb_30">
                    <div class="short_select d-flex align-items-center">
                        <div class="mobile_filter mr_10">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="13"
                                 viewBox="0 0 19.5 13">
                                <g transform="translate(28)">
                                    <rect id="" data-name="Rectangle 1" width="19.5"
                                          height="2" rx="1"
                                          transform="translate(-28)"
                                          fill="var(--system_primery_color)"/>
                                    <rect id="" data-name="Rectangle 2" width="15.5"
                                          height="2" rx="1"
                                          transform="translate(-26 5.5)"
                                          fill="var(--system_primery_color)"/>
                                    <rect id="" data-name="Rectangle 3" width="5" height="2"
                                          rx="1"
                                          transform="translate(-20.75 11)"
                                          fill="var(--system_primery_color)"/>
                                </g>
                            </svg>
                        </div>
                        <h5 class="mr_10 font_16 f_w_500 mb-0">{{__('frontend.Order By')}}:</h5>
                        <select class="small_select" id="order">
                            <option data-display="">{{__('frontend.None')}}</option>
                            <option
                                value="price" {{request('order')=="price"?'selected':''}}>{{__('frontend.Price')}}</option>
                            <option
                                value="created_at" {{request('order')=="created_at"?'selected':''}}>{{__('frontend.Date')}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        @forelse ($result as $course)
            <div class="col-lg-6 col-xl-4">
                <div class="couse_wizged">
                    <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">
                        <div class="thumb">

                            <div class="thumb_inner lazy"
                                 data-src="{{ getCourseImage($course->thumbnail) }}">
                            </div>
                            <x-price-tag :price="$course->price"
                                         :discount="$course->discount_price"/>
                        </div>
                    </a>
                    <div class="course_content">
                        <a href="{{courseDetailsUrl(@$course->id,@$course->type,@$course->slug)}}">

                            <h4 class="noBrake" title=" {{$course->title}}">
                                {{$course->title}}
                            </h4>
                        </a>
                        <div class="rating_cart">
                            <div class="rateing">
                                <span>{{$course->totalReview}}/5</span>

                                <i class="fas fa-star"></i>
                            </div>
                            @if(!onlySubscription())
                                @auth()
                                    @if(!$course->isLoginUserEnrolled && !$course->isLoginUserCart)
                                        <a href="#" class="cart_store"
                                           data-id="{{$course->id}}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    @endif
                                @endauth
                                @guest()
                                    @if(!$course->isGuestUserCart)
                                        <a href="#" class="cart_store"
                                           data-id="{{$course->id}}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    @endif
                                @endguest
                            @endif
                        </div>
                        <div class="course_less_students">
                            @if($course->type==1)
                                <a> <i class="ti-agenda"></i> {{count($course->lessons)}}
                                    {{__('frontend.Lessons')}}</a>
                            @elseif($course->type==2)
                                <a> <i class="ti-agenda"></i>
                                    {{count($course->quiz->assign)}}
                                    {{__('frontend.Question')}}</a>
                            @elseif($course->type==3)
                                <a> <i
                                        class="ti-agenda"></i> {{ $course->class->total_class}}
                                    {{__('frontend.Classes')}}</a>
                            @endif
                            <a>
                                <i class="ti-user"></i> {{$course->total_enrolled}} {{__('frontend.Students')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-lg-12">
                <div
                    class="Nocouse_wizged text-center d-flex align-items-center justify-content-center">
                    <div class="thumb">
                        <img style="width: 50px"
                             src="{{ asset('public/frontend/infixlmstheme') }}/img/not-found.png"
                             alt="">
                    </div>
                    <h1>
                        {{__('frontend.No Course Found')}}
                    </h1>
                </div>
            </div>
        @endforelse
        @if(isset($has_pagination))
            {{ $result->appends(Request::all())->links(theme('snippets.components._dynamic_pagination')) }}
        @endif

    </duv>
    <script>
        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }
    </script>
@endif
