<option value="">Выберите {{$name}}</option>
@foreach($options as $option)
    <option value="{{$option->id}}"
        {{ (old(request()->input('dependant')) == $option->id ? "selected":"") }}>
        {{$option->name}}
    </option>
@endforeach
