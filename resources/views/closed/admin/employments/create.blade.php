@extends('layouts.closed')
@section('title', 'Добавить связь')
@section('content')
    <h1>Добавить связь: Преподаватель - Занятие</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            {{$errors->first()}}
        </div>
    @endif
    <form method="post" action="/admin/employments">
        @csrf
        <div class="form-group">
            <label>Преподаватель:</label>
            <select name="teacher_id" class="form-control form-control-block">
                <option value="">Выберите преподавателя</option>
                @foreach($teachers as $teacher)
                    <option value="{{$teacher->id}}"
                        {{ (old('teacher_id') == $teacher->id ? "selected":"") }}>
                        {{$teacher->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Учреждение:</label>
            <select name="organisation_id"
                    class="form-control form-control-block dynamic"
                    data-dependant="associations">
                <option value="">Выберите учреждение</option>
                @foreach($organisations as $organisation)
                    <option value="{{$organisation->id}}"
                        {{ (old('organisations') == $organisation->id ? "selected":"") }}>
                        {{$organisation->short_name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Объединение:</label>
            <select id="associations"
                name="association_id" class="form-control form-control-block">
                <option value="">Выберите объединение</option>
            </select>
        </div>
        <div id="output"><pre></pre></div>
        <button type="submit" class="btn btn-success">Добавить связь</button>
    </form>
    <script>
        let dropdowns = document.querySelectorAll('.dynamic');
        for (let dropdown of dropdowns) {
            dropdown.addEventListener('change', dynamicDropdown);
        }

        function dynamicDropdown() {
            let body = {
                value: this.value,
                dependant: this.dataset.dependant,
            };

            let path = new URL(window.location.href);
            path = path.pathname.split('/');
            path.pop();
            path.push('fetch-' + this.dataset.dependant);
            path = path.join('/');

            fetch(path, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify(body),
            })
                .then(response => response.text())
                .then(result => {
                    document.getElementById(this.dataset.dependant).innerHTML = result;
                });
        }

    </script>
@endsection
