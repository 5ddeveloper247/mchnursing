@extends(theme('layouts.master'))
@section('title'){{Settings('site_title')  ? Settings('site_title')  : 'Infix LMS'}} | {{__('frontendmanage.Home')}} @endsection
@section('css') @endsection
@section('js') @endsection
<link
href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900"
rel="stylesheet"
/>
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/4.5.6/css/ionicons.min.css"

/>

<link rel="stylesheet" href="{{ asset('public/assets/owl.carousel.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/assets/owl.theme.default.min.css') }}" />

<link rel="stylesheet" href="{{ asset('public/assets/style.css') }}" />
@section('mainContent')
<div class="row m-0">
  <div class="col-md-6 bg-danger">
    <section class="ftco-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="featured-carousel owl-carousel">
              <div class="item">
                <div class="work-wrap d-md-flex">
                  <div
                    class="img order-md-last"
                    style="background-image: url(images/work-1.jpg);"
                  ></div>
                  <div
                    class="text text-left leftimg text-lg-right p-4 px-xl-5 d-flex align-items-center"
                  >
                    <div class="desc w-100">
                      <div class="row justify-content-end">
                        <div class="col-xl-8">
                          <!-- <p>
                            Far far away, behind the word mountains, far
                            from the countries.
                          </p> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="work-wrap d-md-flex">
                  <img src="{{ asset('public/assets/c1.jpg') }}" class="d-block" style="height: 400px">

                  <div
                    class="text text-left leftimg1 text-lg-right p-4 px-xl-5 d-flex align-items-center"
                  >
                    <div class="desc w-100">
                      <div class="row justify-content-end">
                        <div class="col-xl-8">
                          <!-- <p>
                            Far far away, behind the word mountains, far
                            from the countries.
                          </p> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="work-wrap d-md-flex">
                 
                  <img src="{{ asset('public/assets/c1.jpg') }}" class="d-block" style="height: 400px">
                  <div
                    class="text text-left leftimg1 text-lg-right p-4 px-xl-5 d-flex align-items-center"
                  >
                    <div class="desc w-100">
                      <div class="row justify-content-end">
                        <div class="col-xl-8">
                          <!-- <p>
                            Far far away, behind the word mountains, far
                            from the countries.
                          </p> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          
             
          </div>
        </div>
      </div>
    </section>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
  (function ($) {
"use strict";

var fullHeight = function () {
$(".js-fullheight").css("height", $(window).height());
$(window).resize(function () {
  $(".js-fullheight").css("height", $(window).height());
});
};
fullHeight();

var carousel = function () {
$(".featured-carousel").owlCarousel({
  loop: true,
  autoplay: false,
  margin: 30,
  animateOut: "fadeOut",
  animateIn: "fadeIn",
  nav: true,
  dots: true,
  autoplayHoverPause: false,
  items: 2,
  navText: [
    "<p><small>Prev</small><span class='ion-ios-arrow-round-back'></span></p>",
    "<p><small>Next</small><span class='ion-ios-arrow-round-forward'></span></p>",
  ],
  // responsive: {
  //   0: {
  //     items: 1,
  //   },
  //   600: {
  //     items: 1,
  //   },
  //   1000: {
  //     items: 1,
  //   },
  // },
});
};
carousel();
})(jQuery);

 </script>
@endsection
