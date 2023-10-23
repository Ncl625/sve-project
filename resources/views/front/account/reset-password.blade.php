@extends('front.layouts.parent')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('account.login')}}">Login</a></li>
            </ol>
        </div>
    </div>
</section>
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible d-flex justify-content-center align-item-center">
    <h4><i class="icon fa fa-check"></i> Success! {{Session::get('success')}}</h4>
    </div>
@endif
@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible d-flex justify-content-center align-item-center">
    <h4><i class="icon fa fa-ban"></i> Error! {{Session::get('error')}}</h4>
    </div>

@endif
<section class=" section-10">
    <div class="container">
        <div class="login-form">    
            <form action="{{route('account.processResetPassword')}}" method="post">
                @csrf
                <input type="hidden" name="token" id="token" value="{{$token}}">
                <h4 class="modal-title">Reset Password</h4>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="New Password" id="new_password" name="new_password">
                    @if ($errors->has('new_password'))
                    <span class="text-danger">{{  $errors->first('new_password')  }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Confirm Password" id="confirm_password" name="confirm_password">
                    @if ($errors->has('confirm_password'))
                    <span class="text-danger">{{  $errors->first('confirm_password')  }}</span>
                    @endif
                </div>
                
                 
                <input type="submit" class="btn btn-dark btn-block btn-lg" value="Submit">              
            </form>			
            <div class="text-center small">Login to your account? <a href="{{route('account.login')}}">Login</a></div>
        </div>
    </div>
</section>
@endsection