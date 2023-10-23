@extends('admin.layouts.parent')
@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sub Category - {{$subcategory->name}}</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('subcategory.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('subcategory.update',$subcategory->id)}}" method="POST" enctype="multipart/form-data" id="categoryForm" name="categoryForm">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Category</label>
                                <select name="category" id="category" value="{{$subcategory->categoryName}}" class="form-control">
                                    @if($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                    <option {{($subcategory->category_id == $category->id) ? 'selected': ''}} value="{{ $category->id }}">{{$category->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{$subcategory->name}}" class="form-control" placeholder="Name">
                                @if ($errors->has('name'))
                                <span class="text-danger">{{  $errors->first('name')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" value="{{$subcategory->slug}}" class="form-control" placeholder="Slug">
                                @if ($errors->has('slug'))
                                <span class="text-danger">{{  $errors->first('slug')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">status</label>
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($subcategory->status == 1) ? 'selected': ''}} value="1">Active</option>	
                                    <option {{ ($subcategory->status == 0) ? 'selected': ''}} value="0">Block</option>
                                </select>	
                            </div>
                        </div>	
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="showHome">Show on Home</label>
                                <select name="showHome" id="showHome" class="form-control">
                                    <option {{ ($subcategory->showHome == 'Yes') ? 'selected': ''}} value="Yes">Yes</option>	
                                    <option {{ ($subcategory->showHome == 'No') ? 'selected': ''}} value="No">No</option>
                                   
                                </select>	
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" value="{{$subcategory->image}}"/>
                            @if ($errors->has('image'))
                            <span class="text-danger">{{  $errors->first('image')  }}</span>
                            @endif 
                        </div>								
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('subcategory.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
