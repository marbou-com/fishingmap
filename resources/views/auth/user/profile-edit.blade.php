<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title>{{Consts::SITE_NAME}}｜ユーザー編集</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/user_style.css') }}" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet" /><!--画像拡大-->
        <script src="{{ asset('js/lightbox-2.6.min.js') }}"></script><!--画像拡大-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtDYwL2zygagkBG2OA5KxNuqbxGGY0Zkk&callback=initMap" async defer></script>
        <script>
	        $(function () {
			    //削除確認ダイアログ
			    $(".btn").click(function() {
			        if($(this).attr("name")=="del"){
				        var flag = confirm ( "選択された投稿情報を削除しますか？");
				        return flag;
			        }
			    });
            });
        </script>
    </head>

    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">{{Consts::SITE_NAME}}</a>
                </div><!-- /.navbar-header -->
                <div class="collapse navbar-collapse">
                  <ul class="nav navbar-nav">
                      <li><a href="{{ route('posts.create') }}" target="">投稿</a></li>
                      <li><a href="{{ route( 'users.show' ,['user' => $login_id]) }}" target="">登録データ一覧</a></li>
                      
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">こんにちは {{ $login_user }} さん <b class="caret"></b></a>
                          <ul class="dropdown-menu">
                              <li>
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
                      </li>
                  </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </div><!-- /.navbar -->



        <div class="container">

        <!--成功メッセージ-->
        @if(session('massage'))
          <div class="m-3 alert alert-primary">
            {{ session('massage') }}
          </div>
        @endif

        <!--エラー-->
        @foreach ($errors->all() as $err)
          <div class="m-3 alert alert-danger">
            <li>{{ $err }}</li>
          </div>
        @endforeach


        <form class="row " action="{{ route( 'users.update' , ['user'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')




                
                  <div class="row">
                    <div class="col" style="display:flex;/* flexbox */justify-content:center; /* 水平方向 */align-items: center; /* 垂直方向 */">
                      @if($user->logo_url)
                      <img class="my-5 w-100" alt="" src="{{ asset('storage/images/img/'.$user->logo_url) }}" alt="" >
                      @else
                      <img class="my-5 w-100" alt="" src="{{ asset('storage/images/img/avater.png') }}" alt="" >
                      @endif 

                      <fieldset class="control-group">
                        <div class="form-group">
                            <label for="file">画像ファイル</label>
                            <input type="file" name="logo_url" id="logo_url" accept=""/>
                        </div>
                      </fieldset>
                    </div>
                  </div>
                




                <fieldset class="control-group">
                  <div class="form-group">
                      <label>name</label>
                      <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                  </div>
                </fieldset>


                <fieldset class="control-group">
                  <div class="form-group">
                      <label>email</label>
                      <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                  </div>
                </fieldset>


                <fieldset class="control-group">
                  <div class="form-group">
                      <textarea
                          class="form-control @error('description') is-invalid @enderror"
                          name="description"
                          placeholder="description"
                          >{{ old('description',$user->description) }}</textarea>
                  </div>
                </fieldset>

                <button type="submit" class="btn btn-primary">
                  更新する
                </button>



        </form>
      </div>
    </body>
</html>