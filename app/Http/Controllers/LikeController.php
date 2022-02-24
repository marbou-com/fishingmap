<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Like;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        //
        
        $user=\Auth::user();
        $like=new Like();
        $like->user_id=$user->id;
        $like->post_id=$request->post_id;
        //$like->description=$request->description;
        $like->save();

        return redirect()->route('index');

    }

    public function destroy(Request $request)
    {
        //dd($request);
        $like = Like::findByUserIdAndPostId(\Auth::user()->id, $request->input('post_id'));
        $like->delete();
        
            //return redirect()->route('index')->width('message',"削除したよ");
        
            return redirect()->back();



        }

}
