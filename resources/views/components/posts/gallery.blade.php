

      @foreach($posts as $post)
        <div class="col-md-4">
          <div class="well">
            
          
            <img src="{{ asset('storage/images/'.$post->img_url) }}" class="thumbnail" alt="">
           


          <div class="gallery-item-info">

            <div>
              <span class="card-author subtle">
                {{ count($post->likes) }} いいね
                {{ count($post->comments) }} コメント
              </span>
            </div> 

            <div>
              <b><i class="fas fa-map-marker-alt"></i> {{ $post->place }}</b>
            </div>

            <div class="aa">
              {{ $post->description }}
            </div>
          
            <div>
              <span class="card-author subtle">
              {{ $post->datetimepicture }}
              </span>
             </div>
             <hr>




          </div>
        
      
        <div>
          @if(auth()->id()==$post->user_id)
            <button type="button" class="btn btn-primary">
              <a class="" href="{{ route('posts.edit' ,['post'=>$post->id]) }}" style="color:white">編集</a>
            </button>
            <button type="button" class="btn btn-warning">削除</button>
          @endif
        </div>

          </div><!--well-->



        </div>
      @endforeach


