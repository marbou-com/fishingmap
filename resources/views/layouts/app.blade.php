<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtDYwL2zygagkBG2OA5KxNuqbxGGY0Zkk&callback=initMap" async defer></script>
    <script src="{{ asset('js/photomap.js') }}"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        /* マップを表示する div 要素の高さを必ず明示的に指定します。 */
        #mapDiv {
          text-align: center;
          height: 400px;
          width: 100%;
        }
    </style>
    <script>
        function checkbox_changer( flg ) {
            viewMap();
            
        }
    
       /*
       function initMap() {
        var target = document.getElementById('mapDiv');
        var empire = {lat: 36.559007, lng: 136.652444};  
        //Empire State Bldg の緯度（latitude）と経度（longitude）
        map = new google.maps.Map(target, {
            center: empire,
            zoom: 14
        });
        } 
        */   
    </script>
</head>
<body>
    <div id="app">
        <div id="mapDiv"></div>
     
        <div>
            @auth
                @include('layouts._header')
            @endauth
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        @auth
                            @foreach($users as $user)
                            <div class="c-post-block" style="height: auto;">
                                <div class="post">
                                    <div class="name">
                                        <a href="{{ route('users.show', ['user'=>$user->id]) }}">
                                            <img src="{{ asset('storage/images/img/'.$user->logo_url) }}" class="profile-img" style="width: 10%;"/>
                                            <p>
                                                {{ $user->name }}
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endauth
                    </div>
                    @yield('content')
                    <div class="col-md-3"></div>
                </div>
            </div>
        </div>
        <p><span id="allcheck" class=""><a href="javascript:void(0)" onClick="checkbox_changer(true); return false;">全てチェックする</a></span></p>
        <p><span id="allnoncheck" class=""><a href="javascript:void(0)" onClick="checkbox_changer(false); return false;">全てのチェックを外す</a></span></p>
    </div>
</body>
</html>
