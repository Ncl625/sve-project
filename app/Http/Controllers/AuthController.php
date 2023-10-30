<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class AuthController extends Controller
{
    public function login(){
        return view("front.account.login");
    }

    public function register(){
        return view('front.account.register');
    }

    public function processRegister(Request $request){


        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->sendEmailVerificationNotification();

        return redirect()->route('account.login')->with('success','You have been registered successfully. We have sent you a verification email.');
    }

    public function authenticate(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()){

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$request->get('remember'))){

                if(session()->has('url.intended')){

                    return redirect(session()->get('url.intended'));

                }

                return redirect()->route('account.profile');

            }else{
                return redirect()->route('account.login')->with('error','Invalid email or password')->withInput($request->only('email'));
            }

        }else{
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }


    }

    public function profile(){


        return view('front.account.profile');
    }

    public function updateProfile(Request $request){

        $user = Auth::user();

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;

        if($user->email == $request->email){

        }else{
            $user->email = $request->email;
            $user->email_verified_at = null;
        }
        // dd($user->email);


        $user->save();

        return back()->with('success','Profile updated successfully');

    }

    public function orders(){

        $user = Auth::user();

        $orders = Order::where('user_id',$user->id)->orderBy('created_at','DESC')->get();
        $data['orders'] = $orders;

        return view('front.account.order',$data);
    }

    public function orderDetail($id){

        $user = Auth::user();

        $order = Order::where('user_id',$user->id)->where('id',$id)->first();
        $data['order'] = $order;

        $orderItems = OrderItem::where('order_id',$id)->get();
        $data['orderItems'] = $orderItems;


        return view('front.account.order-detail',$data);
    }

    public function changePassword(){
        return view('front.account.change-password');
    }

    public function updatePassword(Request $request){


        $request->validate([

            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        $user = User::select('id','password')->where('id',Auth::user()->id)->first();
        // dd($user);

        if(Hash::check($request->old_password,$user->password)){
            User::where('id',$user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->route('account.profile')->with('success','Password updated successfully');

        }else{

            return back()->with('error','Invalid password');

        }



    }

    public function logout(){
        Auth::logout();
        Cart::destroy();
        if(session()->has('url.intended')){

            session()->forget('url.intended');
            // return redirect(session()->get('url.intended'));

        }
        return redirect()->route('account.login')->with('success','You have been successfully logged out');
        // return redirect()->route('account.profile')->with('success','You have been successfully logged out');
    }

    public function forgotPassword(){
        return view('front.account.forgot-password');
    }

    public function processForgotPassword(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(60);

        DB::table('password_reset_tokens')->where('email',$request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send Email

        $user = User::where('email',$request->email)->first();

        $formData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'you have requested to reset your password'
        ];

        Mail::to($request->email)->send(new ForgotPassword($formData));

        return redirect()->route('account.forgotPassword')->with('success','You have been sent an email');

    }

    public function resetPassword($token){
        // dd($token);
        $tokenExist = DB::table('password_reset_tokens')->where('token',$token)->first();

        if($tokenExist == null){
            return redirect()->route('account.forgotPassword')->with('error','Invalid request');
        }

        return view('front.account.reset-password',[
            'token' => $token
        ]);
    }

    public function processResetPassword(Request $request){

        $request->validate([
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        $token = $request->token;
        $tokenObj = DB::table('password_reset_tokens')->where('token',$token)->first();

        if($tokenObj == null){
            return redirect()->route('account.forgotPassword')->with('error','Invalid request');
        }

        $user = User::where('email',$tokenObj->email)->first();

        User::where('id',$user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('account.login')->with('success','Your password has been reset');
    }
}
