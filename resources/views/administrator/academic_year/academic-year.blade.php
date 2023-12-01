@extends('layouts.admin-layout')

@section('content')
    <academic-year :prop-user="{{ Auth::user() }}"></academic-year>
@endsection
