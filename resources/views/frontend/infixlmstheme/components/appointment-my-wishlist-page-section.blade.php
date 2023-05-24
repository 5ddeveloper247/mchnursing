<!-- tutor listing item:start -->
<section class="section_padding tutor_listing">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-md-12">
                <div class="tutor_listing_title">
                    
                    <p> {{ isset($wishlists) ? count($wishlists) : 0}} {{ __('appointment.saved tutors') }}</p>
                </div>
                @isset($wishlists)               
                    @foreach ($wishlists as $list)              
                    <div class="tutor_listing_item">
                        <div class="tutor_listing_item_left">
                            <div class="tutor_listing_item_profile_img">
                                <img src="{{ asset($list->instructor->image) }}" alt="">
                            </div>
                        </div>
                        <div class="tutor_listing_item_right">
                            <div class="tutor_listing_item_info">
                                <div class="tutor_listing_item_info_profile">
                                    <h4>
                                        <a href="{{ route('appointment.instructor',[$list->instructor->slug]) }}">{{ $list->instructor->name }}
                                        <img src="{{ asset('Modules/Appointment/Resources/assets/frontend/') }}/img/all-icons/country/{{ strtolower($list->instructor->userCountry->iso2) }}.svg" alt="" width="21" height="15">
                                        </span><span>
                                        {{-- <img src="{{ asset('Modules/Appointment/Resources/assets/frontend/') }}/img/all-icons/badge.svg" alt=""> --}}
                                        </span>
                                    </h4>
                                    <ul>
                                        <li class='star'><i class="fa fa-star"></i>({{ $list->instructor->instructor_reviews_count }} {{ __('appointment.Ratings') }})</li>
                                        <li><i class="fa fa-user-friends"></i>
                                            {{ $list->instructor->bookStudents ? count($list->instructor->bookStudents) : 0 }} {{ __('appointment.students') }}
                                        </li>
                                        {{-- <li><i class="fas fa-globe"></i>English</li> --}}
                                    </ul>
                                    
                                            
                                        
                                    <p>{{ __('appointment.Speaks') }} : 
                                        @foreach ($list->instructor->teachingLanguages as $language)
                                        {{ $language->language->name }} <span style="color:{{ $language->level->color }};background-color:{{ $language->level->background_color }} ">{{ $language->level->title }}</span> 
                                        @endforeach
                                    </p>
                                </div>
                                <p> <?php echo $list->instructor->about ?></p>
                                
                            </div>  
                            <div class="tutor_listing_item_info_price text-end">
                                <h3>{{ getPriceFormat($list->instructor->hour_rate) }} <small>/ {{ __('appointment.Hr.') }}</small></h3>
                                @if($settings->trail_lesson ==1)
                                    <a href="{{ route('book-trail-lesson',[$list->instructor->slug]) }}" class="theme_btn">{{ __('appointment.Book Trial Lesson') }}</a>
                                @endif
                                <a href="{{ route('store.wishlist', [$instructor->slug ?? $instructor->id]) }}" class="theme_btn bg-transparent">
                                    {{ __('appointment.Add to Wishlist') }}
                                </a>
                            </div>
                        </div>

                        <!-- listing popup -->
                        
                    </div>
                    @endforeach
                @endisset
            </div>
        </div>
    </div>
</section>
<!-- tutor listing item:end -->