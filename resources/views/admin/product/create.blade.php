@extends('admin.layouts.parent')
@section('content')
    <!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
                    <form action="{{route('product.store')}}" method="post" name="productForm" enctype="multipart/form-data">		
                        @csrf			
                        <div class="container-fluid my-2">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Create Product</h1>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <a href="{{route('product.index')}}" class="btn btn-primary">Back</a>
                                </div>
                            </div>
                        </div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">								
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" name="title" id="title" value="{{old('title')}}" class="form-control" placeholder="Title">	
                                                    @if ($errors->has('title'))
                                                    <span class="text-danger">{{  $errors->first('title')  }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="slug">Slug</label>
                                                    <input type="text" name="slug" id="slug" value="{{old('slug')}}" class="form-control" placeholder="Slug">	
                                                    @if ($errors->has('slug'))
                                                    <span class="text-danger">{{  $errors->first('slug')  }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" value="{{old('description')}}" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="description">Short Description</label>
                                                    <input type="text" name="short_description" id="short_description" class="form-control" placeholder="">
                                                    @if ($errors->has('short_description'))
                                                    <span class="text-danger">{{  $errors->first('short_description')  }}</span>
                                                    @endif	
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="description">Shipping and Returns</label>
                                                    <input type="text" name="shipping_returns" id="shipping_returns" class="form-control" placeholder="">
                                                    @if ($errors->has('shipping_returns'))
                                                    <span class="text-danger">{{  $errors->first('shipping_returns')  }}</span>
                                                    @endif	
                                                </div>
                                            </div>                                           
                                        </div>
                                    </div>	                                                                      
                                </div>
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control" value="{{old('image')}}"/>
                                    @if ($errors->has('image'))
                                    <span class="text-danger">{{  $errors->first('image')  }}</span>
                                    @endif 
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Pricing</h2>								
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="price">Price</label>
                                                    <input type="text" name="price" id="price" value="{{old('price')}}" class="form-control" placeholder="Price">	
                                                    @if ($errors->has('price'))
                                                    <span class="text-danger">{{  $errors->first('price')  }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="compare_price">Compare at Price</label>
                                                    <input type="text" name="compare_price" id="compare_price" value="{{old('compare_price')}}" class="form-control" placeholder="Compare Price">
                                                    <p class="text-muted mt-3">
                                                        To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                    </p>	
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>	                                                                      
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Inventory</h2>								
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="sku">SKU (Stock Keeping Unit)</label>
                                                    <input type="text" name="sku" id="sku" value="{{old('sku')}}" class="form-control" placeholder="sku">
                                                    @if ($errors->has('sku'))
                                                    <span class="text-danger">{{  $errors->first('sku')  }}</span>
                                                    @endif	
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="barcode">Barcode</label>
                                                    <input type="text" name="barcode" value="{{old('barcode')}}" id="barcode" class="form-control" placeholder="Barcode">	
                                                </div>
                                            </div>   
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="hidden" name="track_qty" value="No">
                                                        <input class="custom-control-input" type="checkbox" id="track_qty" value="Yes" name="track_qty" checked>
                                                        <label for="track_qty" name="track_qty" value="{{old('track_qty')}}" class="custom-control-label">Track Quantity</label>
                                                        @if ($errors->has('track_qty'))
                                                        <span class="text-danger">{{  $errors->first('track_qty')  }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="number" min="0" name="qty" id="qty" value="{{old('qty')}}" class="form-control" placeholder="Qty">	
                                                </div>
                                            </div>                                         
                                        </div>
                                    </div>	                                                                      
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product status</h2>
                                        <div class="mb-3">
                                            <select name="status" id="status" value="{{old('status')}}" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Block</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="card">
                                    <div class="card-body">	
                                        <h2 class="h4  mb-3">Product category</h2>
                                        <div class="mb-3">
                                            <label for="category">Category</label>
                                            <select name="category" id="category" value="{{old('category')}}" class="form-control">
                                                <option value="">Select a category</option>
                                                @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}" 
                                                    {{-- onclick="window.location.href='{{route('product.create',$category->slug)}}'" --}}
                                                    > {{$category->name}} </option>
                                                @endforeach
                                                @if ($errors->has('category'))
                                                <span class="text-danger">{{  $errors->first('category')  }}</span>
                                                @endif
                                                @endif
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            
                                            <label for="category">Sub category</label>
                                            <select name="sub_category" id="sub_category" value="{{old('sub_category')}}" class="form-control">
                                                <option value="">Select a subcategory</option>
                                                @if ($subcategories->isNotEmpty())
                                                @foreach ($subcategories as $subcategory)
                                                <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>

                                                @endforeach
                                                @if ($errors->has('sub_category'))
                                                <span class="text-danger">{{  $errors->first('sub_category')  }}</span>
                                                @endif
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product brand</h2>
                                        <div class="mb-3">
                                            <select name="brand" id="brand" value="{{old('brand')}}" class="form-control">
                                                <option value="">Select a brand</option>
                                                @if ($brands->isNotEmpty())
                                                @foreach ($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                @endforeach
                                                @if ($errors->has('brand'))
                                                <span class="text-danger">{{  $errors->first('brand')  }}</span>
                                                @endif
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Featured product</h2>
                                        <div class="mb-3">
                                            <select name="feature" id="feature" value="{{old('feature')}}" class="form-control">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>                                                
                                            </select>
                                            @if ($errors->has('feature'))
                                            <span class="text-danger">{{  $errors->first('feature')  }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>                                 
                            </div>
                        </div>
						
						<div class="pb-5 pt-3">
							<button type="submit" class="btn btn-primary">Create</button>
							<a href="{{route('product.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
					</div>
                </form>

					<!-- /.card -->
				</section>
				<!-- /.content -->
			</div>
@endsection

@section('customJs')
    
@endsection