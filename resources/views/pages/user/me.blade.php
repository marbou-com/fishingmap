<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title>{{Consts::SITE_NAME}}｜自分の一覧</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
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
        <script src="{{Consts::MAPKEY_NAME}}" async defer></script>
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
                    <a class="navbar-brand" href="/">{{Consts::SITE_NAME}}</a>
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

        </div><!-- /.container -->

        <div class="container">
          <div class="row">
            <div class="col" style="display:flex;/* flexbox */justify-content:center; /* 水平方向 */align-items: center; /* 垂直方向 */">




              <div class="card-container">
                <div class="card u-clearfix">
                  <div class="card-body">
                    <span class="card-author subtle">
                      <div>
                        {{ count($user->posts) }}投稿
                        {{ $fCnt_t }}フォロワー
                        {{ $fCnt_f }}フォロー
                      </div> 
                    </span>
                    <h2 class="card-title">{{ $user->name }}</h2>
                    <span class="card-description subtle">
                      {{ $user->description }}
                    </span>
                    <div class="card-read">
                        <a href="{{ route( 'users.edit' ,['user' => $user->id]) }}">
                        プロフィールを編集 
                        </a>
                    </div>
                  </div>
                  <img src="{{ asset('storage/images/img/'.$user->logo_url) }}" alt="" class="img-circle" style="width:25%"/>
                </div>
                <div class="card-shadow"></div>
              </div>
            </div>
        </div>



        
        <div class="container" style="margin-top:5%">

          <div class="p-user-show">
            <!--
            <div class="c-user-profile" style="margin-bottom:4%">
              <div class="profile">
                @foreach($user->posts as $post)
                  <button class="btn btn-default" type="">
                    <a class="" href="{{ route('posts.create') }}" style=""> {{ $post->place }}</a>
                  </button>
                @endforeach
              </div>
            </div>
          -->


            <!-- End of profile section -->
        
             @include('components.posts.gallery', ['posts' => $user->posts])
         
              <!-- End of gallery -->
          </div>

        </div><!--container-->
    </body>
</html>



