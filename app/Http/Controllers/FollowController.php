<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Follow;

class FollowController extends Controller
{
    public function store(Request $request){

        $follow=new Follow();
        $follow->from_follow_id = \Auth::user()->id;
        $follow->to_follow_id = $request->to_follow_id;
        $follow->is_follow = $request->is_follow;
        $follow->save();

        /*
        $isFollow=$request->is_follow && 
                $follow::where('to_user_id', \Auth::user()->id)
                ->where('from_user_id', $request->to_user_id)
                ->where('is_follow', true)
                ->exists();

        */
        //dd($request->all());

        //return redirect()->route('users.show' ,['user'=>$request->to_follow_id]);
        return redirect()->back();

    }

    public function destroy(Request $request)
    {
        ($request->all());
        $follow = Follow::findByUserIdAndToUserId(\Auth::user()->id, $request->input('to_follow_id'));
        $follow->delete();
        
            //return redirect()->route('index')->width('message',"削除したよ");
        
            return redirect()->back();



        }

}
