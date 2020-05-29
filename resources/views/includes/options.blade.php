@isset($all)
    @if ($all)
        <option value="">Все</option>
    @endif
@endisset

@foreach($options as $option)
    <option value="{{$option->id}}"
        {{ (old(request()->input('dependant')) == $option->id ? "selected":"") }}>
        {{$option->name}}
    </option>
@endforeach
