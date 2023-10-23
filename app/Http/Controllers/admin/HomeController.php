<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }

    public function changePassword(){
        return view('admin.change-password');
    }

    public function updatePassword(Request $request){


        $request->validate([
            
            'old_password' => 'required',
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|same:new_password'
        ]);

        $admin = User::select('id','password')->where('id',Auth::guard('admin')->user()->id)->first();
        // dd($admin);

        if(Hash::check($request->old_password,$admin->password)){
            User::where('id',$admin->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->route('admin.dashboard')->with('success','Password updated successfully');

        }else{

            return back()->with('error','Invalid password');

        }



    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
