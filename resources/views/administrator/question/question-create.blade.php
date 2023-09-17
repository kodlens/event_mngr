@extends('layouts.admin-layout')

@section('content')

    @if($id > 0)
        <question-create :prop-id="{{ $id }}"
            :prop-data='@json($data)'></question-create>
    @else
        <question-create :prop-id="0"
            :prop-data='{}'></question-create>
    @endif


@endsection
