<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;//バリデーション
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Follow;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //dd(111);
        $users="";
        if(Auth::check()){//ログインしたか
            $user = Auth::user();
            $users = User::where('id', '<>' , $user->id)->get();

            $login_user=Auth::user()->name;
            $login_id=Auth::user()->id;

            $users->load('users_to');//フォローしているか

            
            $Follows_t=Follow::where('to_follow_id',$login_id)->get();//されている人数
            $fCnt_t=count($Follows_t);

            $Follows_f=Follow::where('from_follow_id',$login_id)->get();//している人数
            $fCnt_f=count($Follows_f);

            //$login_id=$user->id;

            //$Follows_t=Follow::where('to_follow_id',$user->id)->get();//されている人数
            //$fCnt_t=count($Follows_t);
            //dd($users);
            //$view->with('users', $users);
    
        }else{
            $users = User::all();
        }
        
        return view('pages.user.list', compact('users'))
            ->with(['fCnt_t' => $fCnt_t, 'fCnt_f' => $fCnt_f, 'login_user' => $login_user , 'login_id' => $login_id]);





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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //User::first('id');
        $login_user=\Auth::user()->name;
        $login_id=\Auth::user()->id;
        
        //dd($id);
        if($id==\Auth::user()->id){
            

            $user=User::where('id',$id)->first();
            $user->load('posts', 'posts.likes', 'posts.comments');
            //dd($user);

            $Follows_t=Follow::where('to_follow_id',$id)->get();//されている人数
            $fCnt_t=count($Follows_t);

            $Follows_f=Follow::where('from_follow_id',$id)->get();//している人数
            $fCnt_f=count($Follows_f);
            return view('pages.user.me', compact('user'))
            ->with([ 'fCnt_t' => $fCnt_t, 'fCnt_f' => $fCnt_f, 'login_user' => $login_user, 'login_id' => $login_id]);//自分



        }else{


            $user=User::where('id',$id)->first();
            $user->load('posts', 'posts.likes', 'posts.comments');

            $isFollow=Follow::where('to_follow_id',$id)
                          ->where('from_follow_id',\Auth::user()->id)->exists();//フォローしているか

            $Follows_t=Follow::where('to_follow_id',$id)->get();//されている人数
            $fCnt_t=count($Follows_t);

            $Follows_f=Follow::where('from_follow_id',$id)->get();//している人数
            $fCnt_f=count($Follows_f);

            //dd($isFollow);
            return view('pages.user.show', compact('user'))
            ->with(['isFollow'=>$isFollow, 'fCnt_t' => $fCnt_t, 'fCnt_f' => $fCnt_f, 'login_user' => $login_user , 'login_id' => $login_id]);
            
            //他の人
        }
        //$user->load('');
        //dd($user);
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::where('id',$id)->first();
        $login_id=$user->id;
        $login_user=$user->name;

        return view('auth.user.profile-edit', compact('user'))->with('login_id', $login_id)->with('login_user', $login_user);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {

        $image_path="";
        if($request->hasFile('logo_url')){
            if($request->file('logo_url')->isValid()){
                $image_path=$request->file('logo_url')->store('public/images/img');
                //dd($image_path);
                $image_path=basename($image_path);
            }

        }

        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->logo_url=$image_path;
        $user->description=$request->description;
        //$user->password=$request->password;
        $user->update();

        return redirect()->route('users.edit' ,['user' => $id])->with('massage','変更完了');

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
}
