<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <title>{{Consts::SITE_NAME}}｜トップ</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
        <link href="{{ asset('css/map_style.css') }}" rel="stylesheet" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
	    <link href="{{ asset('css/lightbox.css') }}" rel="stylesheet" /><!--画像拡大-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>-->
        <script src="{{Consts::MAPKEY_NAME}}" async defer></script>
        <script type="text/javascript" src="{{ asset('js/photomap.js') }}"></script>
	    <script src="{{ asset('js/lightbox-2.6.min.js') }}"></script><!--画像拡大-->
        <script>
            //チェックボックス全チェック
            function checkbox_changer( flg ) {
                // if(flg){//全てチェックする
                //     $("#allcheck").hide();
                //     $("#allnoncheck").show();
                // }else{//全てチェックはずす
                //     $("#allcheck").show();
                //     $("#allnoncheck").hide();
                // }

                // var obj = document.chbox.elements['service-checkbox2'];
                // var len = obj.length;

                // if( !len ) {
                //     // checkboxが一つしかないときはこちらの処理
                //     if( !obj.disabled ) {
                //         // 有効なcheckboxだけチェックする
                //         obj.checked = flg;
                //     }
                // }
                // else {
                //     // checkboxが複数あるときはこちらの処理
                //     for( i=0; i < len; i++ ) {
                //         if( !obj[i].disabled ) {
                //             // 有効なcheckboxだけチェックする
                //             obj[i].checked = flg;
                //         }
                //     }
                // }

                // //選択されているチェックボックス値を全て取得しマーカー立てる
                // AllVals = new Array;
                // if (navigator.userAgent.indexOf("MSIE")!=-1 && navigator.userAgent.indexOf("Trident/4.0")!=-1){
        		// 	var cnt = 0;//チェックボックス数
                //     for (e = 0; e < document.chbox.elements.length; e++){     //チェックボックスの数を数える
                //         if(document.chbox.elements[e].type == "checkbox")
                //         {
                //             cnt++;
                //         }
                //     }
                //     for( i=0; i<cnt; i++ ){
                //       //チェックされているか確認する
                //       if( document.chbox.elements[i].checked ){
                //         //チェックボックスのvalue値を変数strに入れる
                //         AllVals.push(document.chbox.elements[i].value);
                //       }
                //     }
                //                 }else{
                //     $("input[name=service-checkbox2]:checked").map(function() {
                //         AllVals.push($(this).val());
                //     });
                //     $("input[name=service-checkbox]:checked").map(function() {
                //         AllVals.push($(this).val());
                //     });
                // }
                
                //$("input[name=service-checkbox]").trigger("click");//イベント発火
                //$("input[name=service-checkbox2]").trigger("click");//イベント発火
            }
            (function () {
			    viewMap();
            });
        </script>


    <style>
        /* マップを表示する div 要素の高さを必ず明示的に指定します。 */
        #mapDiv {
          text-align: center;
          height: 500px;
          width: 100%;
          margin-bottom: 3%;
        }

        .img-container{
            display:flex;/* flexbox */
            justify-content:left; /* 水平方向 */
            align-items: center; /* 垂直方向 */
        }
    </style>

    </head>
    <body>
        <div class="bs-docs-header" style="padding-top: 40px;padding-bottom: 0px;font-size: 24px;text-align: left;">
            <h1 class="">
                <img class="img-responsive" src="{{ asset('storage/images/img/map.png') }}" alt="エギングマップ"  />
            </h1>
        </div>

        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div><!-- /.navbar-header -->

            <div class="collapse navbar-collapse">
                @auth
                <form class="navbar-form navbar-right" action="/" >
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Search" id="search" name="search" value="{{ $s_word }}">
                    </div>
                </form>
                @endauth               
                <ul class="nav navbar-nav navbar-right">
                    @auth
                        <li><a href="{{ route('posts.create') }}" target="">投稿する</a></li>
                        <li><a href="{{ route( 'users.show' ,['user' => $login_id]) }}" target="">登録データ一覧</a></li>
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
                    @endauth
                    @guest
                        <li><a href="{{route('register')}}" target="_blank"><span class="glyphicon glyphicon-user"></span> 新規ユーザー登録</a></li>
                        <li><a href="{{route('login')}}" target="_blank"><span class="glyphicon glyphicon-camera"></span> ログイン（投稿）</a></li>
                    @endguest
                </ul>
            </div>
        </div><!-- /.container -->
        </div><!-- /.navbar -->

        <div class="container" >
            <div class="row" id="app">


                <!--マップ表示-->
                <div class="col-xs-12 col-sm-9" >
                    <div id="mapDiv"></div>

                    

                    @foreach($posts as $post)
                        <div class="thumbnail">
                            <div class="panel-heading">
                                <div class="img-container">
                                    <img class="img-circle" src="{{ asset('storage/images/img/'.$post->user->logo_url) }}" style="width:20px">
                                        &nbsp;<a href="{{ route('users.show', ['user'=>$post->user->id]) }}">{{ $post->user->name }}</a>                   
                                </div>
                            </div>
                            <div class="" >
                                <img loading="lazy" src="{{ asset('storage/images/'.$post->img_url) }}" class="card-img-top" alt="" style="width:100%">
                                <div class="caption" >
                                    @auth
                                        {{-- @if($post->is_like)
                                            <!--いいねしている-->
                                            {{-- <form action="{{ route('likes.destroy', ['like'=> $post->like_id] ) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="post_id" value="{{ $post->id }}" required>
                                                <button type="submit" style="display:contents">
                                                    <i class="fas fa-heart"></i>
            
                                                </button>
                                            </form>  

                                            <div >
                                                <like-component
                                                :post="{{ json_encode($post->id)}}"
                                            ></like-component>
                                            </div> 
                                        @else
                                            <!--いいねしていない-->
                                            <form action="{{ route('likes.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <button type="submit" style="display:contents">
                                                    <i class="far fa-heart"></i>
                                                </button>
                                            </form>  

                                            <div >
                                                <like-component
                                                :post="{{ json_encode($post->id)}}"
                                            ></like-component>
                                            </div>                                      
                                        @endif --}}

                                        <div >
                                            <like-component
                                            :post="{{ json_encode($post->id)}}"
                                        ></like-component>
                                        </div> 

                                    @endauth

                                    <p class="card-text"> 
                                        <p>釣果日：{{ $post->datetimepicture }}</p>
                                        <p>場所：{{ $post->place }}</p>
                                        <p>メモ：{{Str::limit($post->description, 35, '…' )}}</p>
                                    </p>

                                    @foreach($post->tags as $tag)
                                        <!--<a href="{{ route('posts.index' ,['tag'=>$tag->name]) }}">#{{ $tag->name }}</a>-->               
                                        <a href="{{ route('index' ,['search'=>$tag->name]) }}">#{{ $tag->name }}</a>                  
                                    @endforeach

                                    <p class="card-text">
                                        <small class="text-muted">
                                            @if(count($post->likes)>0)
                                            <div class="like-count">
                                                <p>{{ count($post->likes) }} 人がいいね&nbsp;
                                                @foreach($post->likes as $like)
                                                    <img class="img-circle" src="{{ asset('storage/images/img/'.$like->user->logo_url) }}" style="width:20px">
                                                @endforeach
                                                </p>
                                            </div>
                                            @endif                                        
                                        </small>
                                    </p>
                                </div><!--card-body-->

                                <!--コメント-->
                                @foreach($post->comments as $comment)
                                    <div class="comments">
                                        <p>
                                            <img class="img-circle" src="{{ asset('storage/images/img/'.$comment->user->logo_url) }}" style="width: 20px;">&nbsp;
                                            <a href="{{ route('users.show', ['user'=>$comment->user->id]) }}"><span class="user-name">{{ $comment->user->name }}</span></a>
                                            {{Str::limit($comment->description, 35, '…' )}}
                                        </p>
                                    </div>
                                @endforeach
                                <!--コメントのタグ-->
                                <div class="comments">
                                    @foreach($post->comments as $comment)
                                        @foreach($comment->tags as $tag)
                                        <!--<a href="{{ route('posts.index' ,['tag'=>$tag->name]) }}">#{{ $tag->name }}</a>-->       
                                        <a href="{{ route('index' ,['search'=>$tag->name]) }}">#{{ $tag->name }}</a>                  
                                        @endforeach               
                                    @endforeach               
                                </div>

                            </div><!--card-->

                            <div class="comment-input">
                                <form action="{{ route('comments.store')}}"  method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <hr>
                                    <div style="display: flex;">
                                        <textarea name="description" placeholder="コメントを追加" style="border: 0;resize: none;outline: 0;width: 90%;"></textarea>
                                        
                                        <button class="btn" type="submit">
                                            <i class="fas fa-paper-plane"></i>&nbsp;投稿する
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div><!--card-group-->
                    @endforeach
            </div><!--row-->


            <div class="col-xs-12 col-sm-3" id="sidebar" role="navigation">
                <div class="well" id="">
                    <h4>おすすめユーザー</h4>
                    <hr>
                        <div class="row">
                            @foreach($users as $user)
                            @if ($loop->index > 4)
                                <small class="text-muted">
                                    <a href="{{ route('users.index') }}">≫もっと見る</a>
                                </small>
                                @php
                                    break;
                                @endphp
                                
                            @endif

                            <div class="comments" style="display: -webkit-flex; display: flex;">
                                <p>
                                    <img class="img-circle" src="{{ asset('storage/images/img/'.$user->logo_url) }}" style="width: 30px;">&nbsp;
                                    <ul style=" list-style-type: none ;padding-left: 5px;">
                                        <li>
                                            <a href="{{ route('users.show', ['user'=>$user->id]) }}">
                                            <span class="user-name">{{Str::limit($user->name, 25, '…' )}}</span>
                                            
                                            </a>
                                        </li>
                                        @auth
                                        @foreach($user->users as $u)
                                            @if($u->to_follow_id==\Auth::user()->id)
                                            <li>
                                                <small class="text-muted">あなたをフォロー中です</small>
                                            </li>
                                            @endif
                                        @endforeach
                                        @endauth
                                    </ul>
                                    
                                </p>
                            </div>                             
                            @endforeach
                            
                            <?php
                            // foreach($name as $key => $value){
                            //     print '<div class="col-xs-6 col-md-6"><label class="checkbox"><img src="img/'.$key.'.png" alt="アイコン" width="24" height="24" />
                            //                    <input type="checkbox" checked name="service-checkbox" value="'.$key.'">'.$value."".
                            //               '</label>
                            //            </div>';
                            // }
                            print '</div><!-- ./row -->';
                            //print '<hr><h4>撮影年月</h4>'
                            //. '<p><span id="allcheck" class=""><a href="javascript:void(0)" onClick="checkbox_changer(true); return false;">全てチェックする</a></span></p>'
                            //. '<p><span id="allnoncheck" class=""><a href="javascript:void(0)" onClick="checkbox_changer(false); return false;">全てのチェックを外す</a></span></p>';
                            //基準年月から現在年月までの差分月数を求める
                             //$oldbaseYYYY="0000";
                             //$oldbaseMM="00";
                             //$baseYYYYMM=($baseYYYY*12)+$baseMM*1;//基準年月
                             //$nowYYYYMM=(date('Y')*12)+date('m')*1;//現在年月
                            //  for($ii=0;$ii<count($photoList);$ii++){
                            //      $datetimeYm=explode(":",$photoList[$ii]['datetime']);
                            //      $baseYYYY=(string)$datetimeYm[0];//
                            //      $baseMM=(string)sprintf("%02d", $datetimeYm[1]);//
                            //      if($baseYYYY.$baseMM!=$oldbaseYYYY.$oldbaseMM){
                            //          //$diff =  $nowYYYYMM - $baseYYYYMM + 1;//差分月数
                            //          $y=$baseYYYY*1;//現在年
                            //          $m=$baseMM*1;//現在月
                            //          //for($s=0;$s<$diff;$s++){
                            //             print '<p><label class="checkbox">
                            //                            <input type="checkbox"  checked name="service-checkbox2" value="'.$y.sprintf("%02d", $m).'">'.$y."年".$m."月"."".
                            //                       '</label>
                            //                    </p>';
                            //             //$m=$m-1;
                            //             //if($m<1){
                            //             //    $y=$y-1;
                            //             //    $m=12;
                            //             //}
                            //          //}
                            //      }
                            //      $oldbaseYYYY=$baseYYYY;
                            //      $oldbaseMM=$baseMM;
                            //  }
                            ?>
                    </div><!-- /.well -->
                    <a href="{{ route('study') }}">≫Vue</a>
            </div><!-- /#sidebar -->


        </div><!-- /.container -->

        <div class="container">
            <div class="footer">
                <h4></h4>
                <p><span></span>　<span>石川県金沢市</span>　<span></span></p>
                <p>Copyright&copy; All rights reserved.</p>
            </div>
        </div><!-- /.container -->
        
        <script src="js/app.js"></script>

    </body>
</html>
