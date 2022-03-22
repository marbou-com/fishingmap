<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Follow;

class FollowController extends Controller
{
    public function store($id){

        $follow=new Follow();
        $follow->from_follow_id = \Auth::user()->id;
        $follow->to_follow_id = $id;
        $follow->is_follow = 1;
        $follow->save();


        $result = false; //追加

        return response()->json([
            'result' => $result, 
            //'count' => $count, 
        ]); 

        /*
        $isFollow=$request->is_follow && 
                $follow::where('to_user_id', \Auth::user()->id)
                ->where('from_user_id', $request->to_user_id)
                ->where('is_follow', true)
                ->exists();

        */
        //dd($request->all());

        //return redirect()->route('users.show' ,['user'=>$request->to_follow_id]);
        //return redirect()->back();

    }

    public function destroy($id)
    {
        //($request->all());
        $follow = Follow::findByUserIdAndToUserId(\Auth::user()->id, $id);
        $follow->delete();
        
            //return redirect()->route('index')->width('message',"削除したよ");
        
            //return redirect()->back();

            $result = true; //追加

            return response()->json([
                'result' => $result, 
                //'count' => $count, 
            ]); 

    }

    public function hasfavorite ($id)
    //ログインユーザーがアクセスしてきたとき
    {
        $follow = Follow::where('from_follow_id', \Auth::user()->id)->where('to_follow_id', $id);

        if ($follow->exists()) {
            $result = false;
        } else {
            $result = true;
        }

        //$result = true;
        return response()->json($result);
    }

    public function count ($id) //以下追加
    {
        $count = Follow::where('to_follow_id', $id)->count();
        return response()->json($count);
    }

}
