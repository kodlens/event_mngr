@extends('layouts.admin-layout')

@section('content')

    @if($id > 0)
        <question-create-edit :prop-id="{{ $id }}"
            :prop-data='@json($data)'></question-create-edit>
    @else
        <question-create-edit :prop-id="0"
            :prop-data='{}'></question-create-edit>
    @endif


@endsection
