<!-- tutor listing item:start -->
<section class="section_padding tutor_listing">
    <div class="container">
        <div class="row ipad-colmun-reverse">
            <div class="col-xl-3 col-lg-6">

                <input type="hidden" class="class_route" name="class_route"
                    value="{{ route('appointment.instructors') }}">
                <x-appointment-tutor-finder-sidebar :categories="$categories" :levels="$levels" :genders="$genders" :weekDays="$weekDays" :countries="$countries" :categoriesIds="$categoriesIds" :levelIds="$levelIds" :genderIds="$genderIds" :priceRange="$priceRange" :ageRange="$ageRange" :days="$days" :country="$country" :type="$type"
                />

            </div>
            <div class="col-xl-8 col-md-12">
                <div class="tutor_listing_title d-flex align-item-center flex-wrap">
                    <p>{{ count($instructors) }} {{ __('appointment.Teachers Available') }}</p>
                    <select class='active_nice_select' id="order">
                        <option> Type</option>
                        <option value="2">{{ __('appointment.In-Person') }}</option>
                        <option value="3">{{ __('appointment.Online') }}</option>
                        <option value="4">{{ __('appointment.Individual') }}</option>
                        <option value="5">{{ __('appointment.Group') }}</option>
                        <option value="6">{{ __('appointment.Individual(Online)') }}</option>
                        <option value="7">{{ __('appointment.Group(Online)') }}</option>
                    </select>
                </div>
                @foreach ($instructors as $instructor)
                    <div class="tutor_listing_item">
                        <div class="tutor_listing_item_left">
                            <div class="tutor_listing_item_profile_img">
                                <img src="{{ asset($instructor->image) }}" alt="">
                            </div>
                        </div>
                        <div class="tutor_listing_item_right">
                            <div class="tutor_listing_item_info">
                                <div class="tutor_listing_item_info_profile">
                                    <h4>
                                        <a
                                            href="{{ route('appointment.instructor', [$instructor->slug ?? $instructor->id]) }}">
                                            {{ $instructor->name }} </a>
                                            <img src="{{ asset('Modules/Appointment/Resources/assets/frontend/') }}/img/all-icons/country/{{ strtolower($instructor->userCountry->iso2) }}.svg"
                                                alt="" width="21" height="15">
                                            </span><span>
                                                {{-- <img src="{{ asset('Modules/Appointment/Resources/assets/frontend/') }}/img/all-icons/badge.svg" alt=""> --}}
                                            </span>
                                    </h4>
                                    <ul>
                                    @if($settings->review_option == 1)
                                        <li class='star'><i
                                                class="fa fa-star"></i>({{ $instructor->instructor_reviews_count }}
                                            {{ __('appointment.Ratings') }})</li>
                                    @endif        
                                    @if($settings->number_of_student == 1)
                                        <li><i class="fa fa-user-friends"></i>
                                            {{ count($instructor->bookStudents) }}
                                            {{ __('appointment.students') }}
                                        </li>
                                    @endif
                                        {{-- <li><i class="fas fa-globe"></i>English</li> --}}
                                    </ul>



                                    <p>{{ __('appointment.Speaks') }} :
                                        @foreach ($instructor->teachingLanguages as $language)
                                            {{ $language->language->name }} <span
                                                style="color:{{ $language->level->color }};background-color:{{ $language->level->background_color }} ">{{ $language->level->title }}</span>
                                        @endforeach
                                    </p>
                                </div>
                                <p> <?php echo $instructor->about; ?></p>

                            </div>
                            <div class="tutor_listing_item_info_price text-right">
                                <h3>{{ getPriceFormat($instructor->hour_rate) }} <small>/
                                        {{ __('appointment.Hr.') }}</small></h3>
                                @if ($settings->trail_lesson == 1)
                                    <a href="{{ route('book-trail-lesson', [$instructor->slug ?? $instructor->id]) }}"
                                        class="theme_btn ">{{ __('appointment.Book Trial Lesson') }}</a>
                                @endif
                                <a href="{{ route('store.wishlist', [$instructor->slug ?? $instructor->id]) }}"
                                    class="theme_btn bg-transparent">
                                    {{ __('appointment.Add to Wishlist') }}
                                </a>
                            </div>
                        </div>

                        <!-- listing popup -->

                    </div>
                @endforeach
                <!-- paginations -->
                @if (count($instructors) > 10)
                    <div class="text-center">
                        <nav class="page_pagination">
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-left"></i>Prev</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#" current-page>3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#"><span>...</span></a></li>
                                <li><a href="#">8</a></li>
                                <li><a href="#">Next<i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- tutor listing item:end -->
