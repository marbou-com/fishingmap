<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Tag;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $comment=new Comment();
        $comment->user_id=$request->user_id;
        $comment->post_id=$request->post_id;
        $comment->description=$request->description;
        $comment->save();


        $this->getTags($request->description, $comment);


        return redirect()->route('index');

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    * コメント追加（store）
    * 参考
    *  https://qiita.com/AkiYanagimoto/items/b363d673d9f2bf63fc0f
    *  https://engineering.mobalab.net/2019/06/21/laravelの多対多のリレーションについて/
    ******************************/
    public function getTags($description, $comment)
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
        //一旦全ての中間テーブル削除
        //dd($comment->tags());
        //$comment->tags()->detach();
        //dd($tags_id);

        //commentインスタンスのtagsメソッドで紐づけ対象のidを引数にして中間テーブルにレコードが自動的に挿入される
        $comment->tags()->attach($tags_id);
    }


}
