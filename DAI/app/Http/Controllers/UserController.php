<?php

namespace App\Http\Controllers;

use App\User;
use App\User_Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        if (Auth::check()) {
            $user = Auth::user();

            $id = $user->id;

            $profile = DB::select('select * from user__profiles where user_id = ?', [$id]);


            return view('dai_views.user_profile', compact('profile'));

        }
        else{
            return redirect('/login');
        }
    }

    public function updateProfile(Request $request){
        if (Auth::check()) {
            $user = Auth::user();
            $user_profile = User_Profile::where('user_id', $user->id)->first();

            $user_table = User::where('id', $user->id)->first();
            $image = $user_profile->user_image;
            $coins = $user_profile->user_coins;
            $user_id = $user->id;

            $user_table->email = $request->email;
            $user_profile->username = $request->username;
            $user_profile->firstName = $request->firstName;
            $user_profile->lastName = $request->lastName;
            $user_profile->user_image = $image;
            $user_profile->user_coins = $coins;
            $user_profile->user_id = $user_id;

            if ($user_table->save()) {

                $user_profile->save();

                $alert_status = true ;
            }

            return $this->index();
        }else{
            return redirect('/login') ;
        }
    }

    public function users(){
        if (Auth::check()) {

            $users = User::all() ;
            $profiles = array() ;
            $count = 0 ;

            foreach ($users as $user){

                $user_profile = User_Profile::where('user_id',$user->id)->first() ;
                $profiles[$count] = $user_profile ;
                $count += 1 ;

            }


            return view('dai_views.users',compact('users','profiles'));
        }else{
            return redirect('/login') ;
        }
    }

    public function make_admin(Request $request){
        if (Auth::check()){
            $id = $request->user_id ;
            $user = User::where('id',$id)->first();
            $user->role = "admin" ;
            $user->save() ;

            return back() ;

        }else{
            return redirect('/login') ;
        }
    }

    public function delete_user(Request $request){
        if (Auth::check()){
            $id = $request->user_id ;
            User::where('id',$id)->delete();

            return back() ;
        }else{
            return redirect('/login') ;
        }
    }
}
