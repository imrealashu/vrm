<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Visual Route Manager</title>
    <link rel="stylesheet" href="{{ elixir('vendor/vrm/libs/css/bulma.min.css') }}"/>
    <link rel="stylesheet" href="{{ elixir('vendor/vrm/css/app.css') }}"/>
</head>
<body>

<div class="header" style="background: #fdfdfd; border-bottom: 1px solid #EEEEEE; margin-bottom: 10px; padding: 5px;">
    <div class="container">
        <nav class="nav">
            <div class="nav-left">
                <a class="nav-item is-brand" href="/vrm">
                    <h4 class="title is-4">VisualRouteManager</h4>
                </a>
            </div>

            <div id="nav-menu" class="nav-right nav-menu">
                @if(session()->has('vrm-admin'))
                    <a class="nav-item is-active" href="vrm/logout">LOGOUT</a>
                @endif
            </div>
        </nav>
    </div>
</div>

<div class="container">
    <div class="row">
        @yield('content')
    </div>
</div>

<script src="{{ elixir('vendor/vrm/libs/js/vue.min.js') }}"></script>
<script src="{{ elixir('vendor/vrm/libs/js/axios.min.js') }}"></script>
@yield('script')
</body>
</html>