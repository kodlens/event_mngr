<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        html body{
            font-family: 'Roboto Slab', serif;
            font-family: 'Ubuntu', sans-serif;
        }
    </style>

</head>
<body>
    <div id="app">

    <b-navbar>
        <template #brand>
            <b-navbar-item>
                <img
                    src="/img/logo.png"
                    alt="emapp logo"
                >
            </b-navbar-item>
        </template>
        <template #start>
           
          
            <!-- <b-navbar-dropdown label="Info">
                <b-navbar-item href="#">
                    About
                </b-navbar-item>
                <b-navbar-item href="#">
                    Contact
                </b-navbar-item>
            </b-navbar-dropdown> -->
        </template>

        <template #end>
            <b-navbar-item href="/event-feeds">
                HOME
            </b-navbar-item>

            <b-navbar-item href="/profile">
                {{ auth()->user()->fname }}
            </b-navbar-item>

            <b-navbar-item tag="div">
                <div class="buttons">
                    <b-button
                        onclick="document.getElementById('logout').submit()"
                        icon-left="logout"
                        class="button is-danger" outlined>
                    </b-button>
                </div>
            </b-navbar-item>
        </template>
    </b-navbar>

    <form action="/logout" id="logout" method="post">
        @csrf
    </form>
       


    <div>
        @yield('content')
    </div>


    </div>
</body>
</html>
