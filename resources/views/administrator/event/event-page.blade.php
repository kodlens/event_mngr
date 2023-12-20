@extends('layouts.admin-layout')

@section('content')
    @auth()
        <event-page :prop-user='@json(Auth::user())'></event-page>
    @endauth
@endsection
