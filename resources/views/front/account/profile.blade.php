@extends('front.layouts.parent')
@section('content')
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
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item">My Account</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('account.updateProfile')}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3">               
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{Auth::user()->name}}" placeholder="Enter Your Name" class="form-control">
                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{  $errors->first('name')  }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">            
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" value="{{Auth::user()->email}}" placeholder="Enter Your Email" class="form-control">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{  $errors->first('email')  }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">                                    
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{Auth::user()->phone}}" placeholder="Enter Your Phone" class="form-control">
                                </div>

                                

                                <div class="d-flex">
                                    <button class="btn btn-dark" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection