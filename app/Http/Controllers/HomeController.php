<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');//アクセスがあった場合にログインされていない状態だと login のページへ強制的にリダイレクト
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function mapinfo($s_word)
    {


        //dd(123);

        //検索
        //$search = $s_word;
        
        // if($s_word){
        //     $posts=Post::latest()->where('description', 'like', "%$s_word%")->get();
        // }else{
        //     $posts=Post::latest()->get();
        // }
        if ($s_word=="nosearch") {//null（検索しない）か空検索    
            $posts=Post::latest()->get();
        }else{
            $posts=Post::latest()->where('description', 'like', "%$s_word%")->get();

        }
          
        



        $posts->load('user');//
        $result=array();

        foreach($posts as $val){
            array_push($result, 
                array(
                    'id'=> $val->id
                    ,'userid' => $val->id
                    ,'category' => 1
                    ,'categoryname' => 22
                    ,'latitude' => $val->latitude
                    ,'longitude' => $val->longitude
                    ,'address' => "アドレス"
                    ,'place' => $val->place
                    ,'comment' => $val->description
                    ,'img_url' => $val->img_url
                    ,'datetime' => $val->datetimepicture
                    ,'logo_url' => $val->user->logo_url
                    ,'nickname' => $val->user->name
                    ,'updatetime' => $val->datetimepicture
                )
            );
        }
        


        return $result;

    }
}
