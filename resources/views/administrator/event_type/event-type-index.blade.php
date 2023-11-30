@extends('layouts.admin-layout')

@section('content')
    @auth()
        <event-type-index></event-type-index>
    @endauth
@endsection
