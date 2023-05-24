@if(isset($result))
    <div class="row">
        @foreach($result as $instructor)

            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="single_instractor mb_30">
                    <a href="{{route('instructorDetails',[$instructor->id,Str::slug($instructor->name,'-')])}}"
                       class="thumb">
                        <img src="{{getInstructorImage($instructor->image)}}" alt="">
                    </a>
                    <a href="{{route('instructorDetails',[$instructor->id,Str::slug($instructor->name,'-')])}}">
                        <h4>{{$instructor->name}}</h4></a>
                    <span>{{$instructor->headline}}</span>
                </div>
            </div>
        @endforeach
    </div>
    @if(isset($has_pagination))
        <div class="row">
            @if ($result->hasPages())
                <div class="pagination-wrapper">
                    {{ $result->links() }}
                </div>
            @endif
        </div>
    @endif
@endif
