@extends('layouts.app')


@section('content')
    <div class="col-md-6">
            {{session('message')}}
        @foreach($posts as $post)
        <div class="c-post-block" style="height: auto;">
            <div class="post">
              <div class="name">
                <a href="{{ route('users.show', ['user'=>$post->user->id]) }}">
                    <img src="{{ asset('storage/images/img/'.$post->user->logo_url) }}" class="profile-img" style="width: 10%;"/>
                    <p>
                        {{ $post->user->name }}
                    </p>
                </a>
              </div>

              <button aria-label="profile settings" class="btn profile-settings-btn" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="fas fa-angle-down"></i>
              </button>
              
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <!--ログイン自分のものなら編集-->
                @if($post->user->id==auth()->id())
                <a class="dropdown-item" href="{{ route('posts.edit' ,['post'=>$post->id]) }}">
                    編集 
                </a>
                @else
                    <li>通報する</li>
                    <li>フォローする</li>
                @endauth

              </div>

            </div>

            <div class="post-image">
              <img src="{{ asset('storage/images/'.$post->img_url) }}" width="100%"/>
            </div>

            <div class="likes">
                <div class="left-icons">
                    @if($post->is_like)
                    <!--いいね！削除-->
                    <form action="{{ route('likes.destroy', ['like'=> $post->like_id] ) }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="post_id" value="{{ $post->id }}" required>
                        <button type="submit" style="display:contents">
                            <i class="fas fa-heart"></i>

                        </button>
                    </form>

                    @else
                    <!--いいね！-->
                    <form action="{{ route('likes.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit" style="display:contents">
                            <i class="far fa-heart"></i>

                        </button>
                    </form>
                    @endif

                </div>
            </div>


             <!--自分説明-->
             <div class="comments">
                <p>
                    <img style="width:3%" src="{{ asset('storage/images/img/'.$post->user->logo_url) }}">
                    &nbsp;{{ $post->description }}</p>
            </div>           


             
            <!--説明のタグ-->
            <div class="comments">
                @foreach($post->tags as $tag)
                    <a href="{{ route('posts.index' ,['tag'=>$tag->name]) }}">#{{ $tag->name }}</a>                  
                @endforeach               

            </div>

            @if(count($post->likes)>0)
            @php
             //dd($posts);   
            @endphp
            <div class="like-count">
                <i class="fas fa-heart"></i>
                <p>{{ count($post->likes) }} 人がいいね</p>
                @foreach($post->likes as $like)
                    <img src="{{ asset('storage/images/img/'.$like->user->logo_url) }}">
                @endforeach



            </div>
            @endif






                <!--コメント-->
                @foreach($post->comments as $comment)
                <div class="comments">
                    <p>
                        <img src="{{ asset('storage/images/img/'.$comment->user->logo_url) }}" style="width: 3%;">&nbsp;
                        <span class="user-name">{{ $comment->user->name }}</span>
                        {{ $comment->description }}
                    </p>
                </div>
                @endforeach

                <!--コメントのタグ-->
                <div class="comments">
                    @foreach($post->comments as $comment)


                        @foreach($comment->tags as $tag)

                            <a href="{{ route('posts.index' ,['tag'=>$tag->name]) }}">#{{$tag->name}}</a>                  
                        @endforeach               

                    @endforeach               
                
                </div>


            <div class="comment-input">
                <form action="{{ route('comments.store')}}"  method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ auth::user()->id }}">
                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                <input type="text" name="description" placeholder="コメントを追加">
                <!--<textarea name="description" placeholder="コメントを追加" width="100%"></textarea>-->

                <button class="btn btn-link" type="submit">
                    <i class="fas fa-paper-plane"></i>&nbsp;投稿する
                </button>
            </form>
            </div>
        </div>
        @endforeach
    </div>
    
@endsection
