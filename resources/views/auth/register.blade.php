<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title>{{Consts::SITE_NAME}}｜ユーザー登録</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/user_style.css') }}" rel="stylesheet">
        <link href="{{ asset('css/login_style.css') }}" rel="stylesheet">
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

        <div class="container">

            <div class="form-wrapper">
                <h1>Register</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">

                        <div class="form-item">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="name">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="form-item">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row">

                        <div class="form-item">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="form-item">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="password">
                        </div>
                    </div>

                    <div class="button-panel">
                        
                        <button type="submit" class="button">
                            {{ __('Register') }}
                        </button>

                    </div>
                </form>

                <div class="form-footer">
                    <span>
                        アカウントをお持ちですか？
                        <a class="" href="{{ route('login') }}">
                            ログインする
                        </a>
                    </span>
                </div>

            </div>
        </div>

    </body>
</html>