<div class="row">

    @if(isset($result))
        @foreach($result as $quiz)

            <div class="col-lg-4 col-xl-3 col-md-6">
                <div class="quiz_wizged mb_30">
                    <a href="{{courseDetailsUrl(@$quiz->id,@$quiz->type,@$quiz->slug)}}">
                        <div class="thumb">
                            <div class="thumb_inner lazy"
                                 data-src="{{ getCourseImage($quiz->thumbnail) }}">
                            </div>

                            @if(showEcommerce())
                                <span class="prise_tag">
                               @if (@$quiz->discount_price!=null)
                                        <span class="prev_prise">
                                  {{getPriceFormat($quiz->price)}}
                                  </span>
                                    @endif
                                <span>
                                @if (@$quiz->discount_price!=null)
                                        {{getPriceFormat($quiz->discount_price)}}
                                    @else
                                        {{getPriceFormat($quiz->price)}}
                                    @endif
                                </span>
                                </span>
                            @endif
                            <span class="live_quiz">{{__('quiz.Quiz')}}</span>
                        </div>

                    </a>

                    <div class="course_content">
                        <a href="{{courseDetailsUrl(@$quiz->id,@$quiz->type,@$quiz->slug)}}">
                            <h4 class="noBrake" title=" {{$quiz->title}}">
                                {{$quiz->title}}
                            </h4>
                        </a>
                        <div class="rating_cart">
                            <div class="rateing">
                                <span>{{$quiz->totalReview}}/5</span>
                                <i class="fas fa-star"></i>
                            </div>
                            @auth()
                                @if(!$quiz->isLoginUserEnrolled && !$quiz->isLoginUserCart)
                                    <a href="#" class="cart_store"
                                       data-id="{{$quiz->id}}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                @endif
                            @endauth
                            @guest()
                                @if(!$quiz->isGuestUserCart)
                                    <a href="#" class="cart_store"
                                       data-id="{{$quiz->id}}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                @endif
                            @endguest
                        </div>
                        <div class="course_less_students">
                            <a> <i class="ti-agenda"></i> {{count($quiz->quiz->assign)}}
                                {{__('frontend.Question')}}</a>
                            <a>
                                <i class="ti-user"></i> {{$quiz->total_enrolled}} {{__('frontend.Students')}}
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    @endif

    <script>
        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }
    </script>
</div>
