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

<section class="container">
    <div class="col-md-12 text-center py-5">
    <h1>THANK YOU</h1>
    <p></p>
    <h2>Waiting for your next purchase</h2>
    </div>
</section>
@endsection