<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\tag;


class IndexController extends Controller
{
    public function index(Request $request){


        //検索
        $search = $request->input('search');
        if(trim($search)!=""){
            $posts=Post::latest()->where('description', 'like', "%$search%")->get();
        }else{
            $posts=Post::latest()->get();
        }

        

        $posts->load('user', 'comments.user', 'likes.user', 'tags', 'comments.tags',);//｜理解（投稿した人、コメントとコメント書いた人）
        //dd($posts->like_id);
        
        if ( \Auth::check() ) {
            // ログイン済みのときの処理
            $login_user=\Auth::user()->name;
            $login_id=\Auth::user()->id;

           

            return view('pages.index', compact('posts'))
            ->with('login_id', $login_id)
            ->with('login_user', $login_user)
            ->with('s_word', $search)
            ;            
        } else {
            // ログインしていないときの処理
            return view('pages.index', compact('posts')); 
        }



        //dd($result);

    } 

}
