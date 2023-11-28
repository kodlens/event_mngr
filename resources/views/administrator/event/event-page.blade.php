@extends('layouts.admin-layout')

@section('content')
    @auth()
        <event-page :prop-user='{{ Auth::user() }}'></event-page>
    @endauth
@endsection
