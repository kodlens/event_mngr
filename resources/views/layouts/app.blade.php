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

    </style>

</head>
<body>
    <div id="app">
    <b-navbar>
        <template #brand>
            <b-navbar-item>
               EMAPP
            </b-navbar-item>
        </template>
        <template #start>
           
        </template>

        <template #end>
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

    <form action="/logout" method="post" id="logout">
        @csrf
    </form>

    <div>
        @yield('content')
    </div>


    </div>
</body>
</html>
