<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest;//バリデーション

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $Request)
    {
        //dd($Request);
        //searchと一緒にしたから未使用
        //タグ押下
        $tag='#'.$Request->tag;//URLパラメータの値を取得する
        $posts=Post::latest()->where('description', 'like', "%$tag%")->get();//
        //dd($posts);
        $posts->load('user', 'comments.user', 'likes', 'tags');//｜理解（投稿した人、コメントとコメント書いた人）
        $login_id=\Auth::user()->id;

        return view('pages.index', compact('posts'))->with('login_id', $login_id)->with('s_word', "");


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //dd($request->input('place'));
        
        //場所を取得
        $user_id=\Auth::user()->id;
        //dd($id);
        $places=Post::where('user_id', $user_id)->select('place')->groupByRaw('place')->get()->pluck('place');
        //dd($posts);

        $login_user=\Auth::user()->name;
        $login_id=\Auth::user()->id;

        $targetPlace="";
        $latitude=0;
        $longitude=0;

        if($request->input('place')){//場所指定あり

            $geo=Post::where('place', $request->input('place'))->first();
            $latitude=$geo->latitude;
            $longitude=$geo->longitude;
            //dd($longitude);
            $targetPlace=$request->input('place');

        }

        return view('pages.post.create')
        ->with('places', $places)
        ->with('login_user', $login_user)
        ->with('login_id', $login_id)
        ->with('targetPlace', $targetPlace)
        ->with('latitude', $latitude)
        ->with('longitude', $longitude);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        //ユーザー
        $user=\Auth::user();

        //画像
        $image_path="";//画像ファイル
        if($request->hasFile('image')){//ファイルが送信されたか
            if($request->file('image')->isValid()){//ファイルがアップロードされたか
                //①Starageファサード
                //$image_path = Storage::put('/public/images/', $request->file('image'));
                
                //②通常
                $image_path = $request->file('image')->store('public/images');
                //dd($image_path);
                $image_path=basename($image_path);
                //dd($image_path);

            }
        }

        //Postインスタンス生成
        $post=new Post();
       
        //設定
        $post->description=$request->description;
        $post->img_url=$image_path;
        $post->user_id=$user->id;

        $post->datetimepicture=$request->datetimepicture;
        $post->status=0;//未承認
        $post->latitude=$request->latitude;;//緯度
        $post->longitude=$request->longitude;;//経度
        if($request->newplace==""){
            $post->place=$request->place;//場所
        }else{
            $post->place=$request->newplace;//場所
        }
        
        //dd($post->place);
        $post->save();


        $this->getTags($request->description, $post);


        //リダイレクト
        return redirect()->route('index');
        //return redirect()->route('post.create')->with('message', '投稿しました');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::find($id);
        //dd($post);

        $login_user=\Auth::user()->name;
        $login_id=\Auth::user()->id;
        
        return view('pages.post.edit', compact('post'))->with('login_user', $login_user)->with('login_id', $login_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $image_path="";//画像ファイル
        if($request->hasFile('image')){//ファイルが送信されたか
            if($request->file('image')->isValid()){//ファイルがアップロードされたか
                //①Starageファサード
                //$image_path = Storage::put('/public/images/', $request->file('image'));
                
                //②通常
                $image_path = $request->file('image')->store('public/images');
                //dd($image_path);
                $image_path=basename($image_path);
                //dd($image_path);

            }
        }

        $post=Post::find($id);
        //dd($user);
        $post->description=$request->description;
        $post->img_url=$image_path;
        $post->place=$request->place;
        $post->datetimepicture=$request->datetimepicture;
        $post->latitude=$request->latitude;
        $post->longitude=$request->longitude;

        //$user=Auth::user();//auth()->user();
        //$post->user_id=$user->id;
        $post->update();

        //$request->description;

        $this->getTags($request->description, $post);


        //dd($post);
        return redirect()->route('index');
        //return redirect()->route('post.create')->with('message', '投稿しました');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*******************************
    * タグ抽出
    * 自分の投稿追加（store）・変更（update）
    * 参考
    *  https://qiita.com/AkiYanagimoto/items/b363d673d9f2bf63fc0f
    *  https://engineering.mobalab.net/2019/06/21/laravelの多対多のリレーションについて/
    ******************************/
    public function getTags($description, $post)
    {

        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $description, $match);
        $tags = [];
        //dd($match);[0]#programmer  [1]programmer
        foreach ($match[1] as $tag) {
            $found = Tag::firstOrCreate(['name' => $tag]);//あれば取得、ないならインサートしモデルインスタンスを返す

            array_push($tags, $found);
        }
        // 投稿に紐付けされるタグのidを配列化
        $tags_id = [];
        foreach ($tags as $tag) {
            array_push($tags_id, $tag['id']);
        }

        $tags_id=array_unique($tags_id);//重複タグをまとめる
        //dd($tags_id);
        //一旦全ての中間テーブル削除
        $post->tags()->detach();

        //Postインスタンスのtagsメソッドで紐づけ対象のidを引数にして中間テーブルにレコードが自動的に挿入される
        $post->tags()->attach($tags_id);
    }

}
