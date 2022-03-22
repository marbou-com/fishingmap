<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Like;

class FavoriteController extends Controller
{
    //
    public function store($id)
    {
        //dd(111);
        //$post = Post::find($id);
        //$post->users()->attach(Auth::id());


        $user=\Auth::user();
        $like=new Like();
        $like->user_id=$user->id;
        $like->post_id=$id;
        //$like->description=$request->description;
        $like->save();

        $count = Like::where('post_id', $id)->count();
        $result = false; //追加

        return response()->json([
            'result' => $result, 
            'count' => $count, 
        ]); 

    }
    
    public function destroy($id)
    {
        //dd($id);
        //$post = Post::find($id);
        //$post->users()->detach(Auth::id());

        $like = Like::findByUserIdAndPostId(\Auth::user()->id, $id);
        $like->delete();

        $count = Like::where('post_id', $id)->count();
        $result = true; //追加

        return response()->json([
            'result' => $result, 
            'count' => $count, 
        ]); 
        
    }

    public function hasfavorite ($id)
    //ログインユーザーがアクセスしてきたとき
    {
        $like = Like::where('user_id', \Auth::user()->id)->where('post_id', $id);

        if ($like->exists()) {
            $result = false;
        } else {
            $result = true;
        }

        //$result = true;
        return response()->json($result);
    }

    public function count ($id) //以下追加
    {
        $count = Like::where('post_id', $id)->count();
        return response()->json($count);
    }

}
