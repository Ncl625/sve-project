@extends('admin.layouts.parent')
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('admin.dashboard')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('admin.updatePassword')}}" method="POST" enctype="multipart/form-data" id="categoryForm" name="categoryForm">
            @csrf
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="old_password">Old Password</label>
                                <input type="password" name="old_password" id="old_password" class="form-control" placeholder="old password">
                                @if ($errors->has('old_password'))
                                <span class="text-danger">{{  $errors->first('old_password')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" placeholder="new password">
                                @if ($errors->has('new_password'))
                                <span class="text-danger">{{  $errors->first('new_password')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                	
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="confirm password">
                                @if ($errors->has('confirm_password'))
                                <span class="text-danger">{{  $errors->first('confirm_password')  }}</span>
                                @endif	
                            </div>
                        </div>	
                        								
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('admin.dashboard')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
