@extends('layouts.admin-layout')

@section('content')

    @if($id > 0)
        <event-page-create-edit :prop-id="{{ $id }}" :prop-data='@json($data)'></event-page-create-edit>

    @else
        <event-page-create-edit :prop-id="0" :prop-data='@json($data)'></event-page-create-edit>

    @endif
@endsection
