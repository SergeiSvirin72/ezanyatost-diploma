@extends('layouts.closed')
@section('title', 'Домашние задания')
@section('content')
    <h1>Домашние задания</h1>
    <form name="fetch">
        <input type="hidden" name="header">
        <input type="hidden" id="dynamic-fetch" class="dynamic-start" value="/report/homework/student/fetch">
        @csrf
    </form>
    <div class="table-wrapper">
        <table class="table table-lg table-scroll">

        </table>
    </div>
    <script src="{{ asset('js/dynamicDropdown.js') }}"></script>
@endsection
