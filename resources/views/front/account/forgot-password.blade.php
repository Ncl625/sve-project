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
            <form action="{{route('account.processForgotPassword')}}" method="post">
                @csrf
                <h4 class="modal-title">Enter your email</h4>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Email" value="{{old('email')}}" name="email">
                    @if ($errors->has('email'))
                    <span class="text-danger">{{  $errors->first('email')  }}</span>
                    @endif
                </div>
                
                 
                <input type="submit" class="btn btn-dark btn-block btn-lg" value="Submit">              
            </form>			
            <div class="text-center small">Login to your account? <a href="{{route('account.login')}}">Login</a></div>
        </div>
    </div>
</section>
@endsection