<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title>{{Consts::SITE_NAME}}｜投稿編集</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/user_style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/mobiscroll.custom-2.5.3.min.css') }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        
        <script src="{{Consts::MAPKEY_NAME}}" async defer></script>
        <script type="text/javascript" src="{{ asset('js/mobiscroll.custom-2.5.3.min.js') }}"></script>
        <script>
            $(function() {
				$('#datetimepicture').mobiscroll({
				  preset: 'datetime',
				  dateFormat: 'yy:mm:dd', // 日付フォーマット('2013/04/01' ゼロパディング yy＝年：4桁)
				  dateOrder: 'yymmdd', // 日付表示時の並び順(年-月-日)
				  timeFormat: 'HH:ii', // 時刻フォーマット('23:59' ゼロパディング)
				  timeWheels: 'Ahhii' // 時刻表示時の並び順(AM/PM-時-分)
				});
            });

			var _default_ido=37.214558;//
			var _default_keido=140.994458;
			function init() {
			    //現在位置取得
			    if(navigator.geolocation) {// Try W3C Geolocation (Preferred)
			    	browserSupportGetlocationFlag = true;
					navigator.geolocation.getCurrentPosition(function(position) {
						initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
						nowlat = position.coords.latitude;
						nowlng = position.coords.longitude;
			            process_by_mode(position,"GetPosi");//各処理
				    }, function(error) {
			                process_by_mode(null,"NotPosi");//各処理
				       }, {enableHighAccuracy : true ,timeout: 60000} // android
				    );
			    }
			    else if (google.gears) {// Try Google Gears Geolocation
			    	browserSupportGetlocationFlag = true;
					var geo = google.gears.factory.create('beta.geolocation');
					geo.getCurrentPosition(function(position) {
					    initialLocation = new google.maps.LatLng(position.latitude,position.longitude);//現在位置取得！
			    		nowlat = position.coords.latitude;
			    		nowlng = position.coords.longitude;
			            process_by_mode(position,"GetPosi");//各処理
			    	}, function(error) {//位置情報取得できなかった場合
			                process_by_mode(null,"NotPosi");//各処理
			    	   }, {enableHighAccuracy:true,timeout: 60000} // android　高精度の位置情報を取得
			    	);
			    }
			    else {// Browser doesn't support Geolocation
			        process_by_mode (null,"NoSupport");//各処理
			    }
			}

            function process_by_mode(position,state){
			    //現在地取得
			    lat_now = 0;
				lng_now = 0;
				/*
			    switch (state){
				    case "GetPosi"://位置情報取得成功
					    lat_now = position.coords.latitude;//現在位置（緯度）
					    lng_now = position.coords.longitude;//現在位置（経度）
			            break;
				    default://失敗時は(WIN vista以前)
					    lat_now = _default_ido;//（緯度）
					    lng_now = _default_keido;//（経度）
				        break;
			    }
			    */

				// 初期位置

				var egiTown = new google.maps.LatLng($("#latitude").val()*1, $("#longitude").val()*1);

				// マップ表示
				var egimap = new google.maps.Map(document.getElementById("map"), {
					center: egiTown,
					zoom:13,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});

				// ドラッグできるマーカーを表示
				var marker = new google.maps.Marker({
					position: egiTown,
					draggable: true
				});
				marker.setMap(egimap)	;

                //初期表示時の緯度経度設定
			    document.getElementById('latitude').value = $("#latitude").val();
				document.getElementById('longitude').value = $("#longitude").val();

				// マーカーのドロップ（ドラッグ終了）時のイベント
				google.maps.event.addListener( marker, 'dragend', function(ev){
					document.getElementById('latitude').value = ev.latLng.lat();
					document.getElementById('longitude').value = ev.latLng.lng();
				});
            }
			// ONLOADイベントにセット
			//window.onload = init();
        </script>
        <style>
			#map {
			    height: 340px;
			    background: #ccc;
			}
        </style>
    </head>
    <body onload="init()">
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">エギングマップ</a>
                </div><!-- /.navbar-header -->
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('posts.create') }}" target="">投稿</a></li>
                        <li><a href="{{ route( 'users.show' ,['user' => $login_id]) }}" target="">登録データ一覧</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('ログアウト') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                            </form>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </div><!-- /.navbar -->
        <div class="container">
        


            @if ($errors->any())
            <!--エラーメッセージ-->
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach

                    @if(empty($errors->first('image')))
                    <li>画像ファイルがあれば、再度、選択してください。</li>
                    @endif
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('posts.update', ['post'=>$post->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <br>
                <fieldset class="control-group">
                    <div class="form-group">
                        <label>場所</label>
                        <input type="text" class="form-control" id="place" name="place" value="{{ old('place',$post->place) }}">
                    </div>
                </fieldset>

                <fieldset class="control-group">
                    <div class="form-group">
                        <img src="{{ asset('storage/images/'.$post->img_url) }}">
                        <input type="file" name="image" accept="" >
                    </div>
                </fieldset>
                
                <fieldset class="control-group">
                    <div class="form-group">
		    			<input type="hidden" class="form-control" id="latitude" name="latitude" size="20" value="{{ old('latitude',$post->latitude) }}"/>
    					<input type="hidden" class="form-control" id="longitude" name="longitude" size="20" value="{{ old('longitude',$post->longitude) }}"/>
                    </div>
                </fieldset>

                <fieldset class="control-group">
                    <div class="form-group">
                        <textarea
                            class="form-control @error('description') is-invalid @enderror"
                            name="description"
                            placeholder="description"
                            >{{ old('description',$post->description) }}</textarea>
                    </div>
                </fieldset>

                <fieldset class="control-group">
	                <div class="form-group">
					    <!-- ここにMapを表示する-->
	                    <label for="map">撮影場所<br />（マーカーをドラッグし撮影場所に移動して下さい。）</label>
					    <div id="map"></div><!-- /map -->
	                </div><!-- content-->
                </fieldset>
                <fieldset class="control-group">
                    <div class="form-group">
    	                <label for="datetimepicture">撮影時刻</label>
                        <input type="datetimepicture" name="datetimepicture" id="datetimepicture" class="form-control mobiscroll" readonly="readonly" value="{{ old('datetimepicture',$post->datetimepicture) }}" />
    	            </div>
                </fieldset>
                <button type="submit" class="btn btn-primary">
                    更新する
                </button>

            </form>

        </div><!--container-->
    </body>
</html>


