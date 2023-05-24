<a class="dropdown-item"
   href="{{route('student.courses', $query->id)}}"
   data-id="{{$query->id}}"
   type="button">
    {{ $query->enrollCourse->count() }}
</a>
