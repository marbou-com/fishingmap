<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title>{{Consts::SITE_NAME}}｜ユーザー一覧</title>
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



        <div class="container" id="app">
          <div class="row" >
            <div  class="col" style="display:flex;" >



              @foreach($users as $user)


                <div class="col-md-12" >
                <div class="card-container">
                  <div class="card u-clearfix">
                    <div class="card-body" >
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
                        <div class="card-read" >



                        {{-- @php
                        $isFollow=0;
                        @endphp

                        @foreach($user->users_to as $u)
                          @if($u->from_follow_id==Auth::user()->id && $u->to_follow_id==$user->id)
                            @php
                              $isFollow=1;
                              break;
                            @endphp
                          @else
                            @php
                              $isFollow=0;
                          @endphp
                          @endif
                        @endforeach --}}



                          {{-- @if($isFollow==0)
                            <form action="{{route('follows.store')}}" method="POST">
                              @csrf
                              <input type="hidden" name="to_follow_id" value="{{ $user->id }}">
                              <input type="hidden" name="is_follow" value="1">
                              <button class="btn btn-default" btn-type="follow" type="submit">フォローする</button>
              
                            </form>

                          @else
                            <form action="{{route('follows.destroy' , ['follow'=>$user->id])}}" method="POST">
                              @csrf
                              @method('delete')
                              <input type="hidden" name="to_follow_id" value="{{ $user->id }}">
                              <input type="hidden" name="is_follow" value="0">
                              <button class="btn btn-default" btn-type="follow" type="submit">フォローはずす</button>
              
                            </form>
                          @endif --}}
                          
                          <div >
                            <follow-component
                            :user="{{ json_encode($user->id)}}"
                          ></follow-component>
                          </div> 


                        </div>
                    </div>
                    <img src="{{ asset('storage/images/img/'.$user->logo_url) }}" alt="" class="img-circle" style="width:30%"/>
                  </div>
                  
                  <div class="card-shadow"></div>

              </div>
            </div>
          </div>

             @endforeach
        </div>

      </div>
    </div>


        
    <script src="./js/app.js"></script>

    </body>
</html>



