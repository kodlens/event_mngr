@extends('layouts.admin-layout')

@section('content')
    <event-attendance :prop-event-id="{{ $id }}"
        :prop-data='@json($data)'
        ></event-attendance>
@endsection
