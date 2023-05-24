<div class="">

    <div class="package_carousel_active owl-carousel">
        @if(isset($result ))
            @foreach($result  as $category)

                <div class="single_package">
                    <div class="icon">
                        <img src="{{asset($category->image)}}" alt="">
                    </div>
                    <a href="{{route('courses')}}?category={{$category->id}}">
                        <h4>{{$category->name}}</h4>
                    </a>
                    <p>{{$category->courses_count}} {{__('frontend.Courses')}}</p>
                </div>
            @endforeach
        @endif
    </div>

    <script>

    </script>
</div>
