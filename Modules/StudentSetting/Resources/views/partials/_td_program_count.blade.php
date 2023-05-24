<a class="dropdown-item"
   href="{{route('student.programs', $query->id)}}"
   data-id="{{$query->id}}"
   type="button">
    {{ $query->enrollProgrom->count()}}
</a>
