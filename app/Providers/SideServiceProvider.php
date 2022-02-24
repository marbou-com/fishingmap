<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\View;
use App\User;
use App\Follow;








class SideServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            
            $users="";
            if(Auth::check()){//ログインしたか
                $user = Auth::user();
                $users = User::where('id', '<>' , $user->id)->get();

                $users->load('users');//フォローされているか

                //$login_id=$user->id;

                //$Follows_t=Follow::where('to_follow_id',$user->id)->get();//されている人数
                //$fCnt_t=count($Follows_t);
                //dd($users);
                //$view->with('users', $users);
     
            }else{
                $users = User::all();
            }

            $view->with('users', $users);

        });
    }
}
