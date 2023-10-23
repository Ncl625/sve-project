@extends('admin.layouts.parent')
@section('content')
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">					
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product - {{$product->title}}</h1>
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
            <form action="{{route('product.update',$product->id)}}" method="POST" enctype="multipart/form-data" id="productForm" name="productForm">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">								
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Title</label>
                                <input type="text" name="title" id="title" value="{{$product->title}}" class="form-control" placeholder="Title">
                                @if ($errors->has('title'))
                                <span class="text-danger">{{  $errors->first('title')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" value="{{$product->slug}}" class="form-control" placeholder="Slug">
                                @if ($errors->has('slug'))
                                <span class="text-danger">{{  $errors->first('slug')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description">Description</label>
                                <input type="text" name="description" id="description" value="{{$product->description}}" class="form-control" placeholder="Description">
                                @if ($errors->has('description'))
                                <span class="text-danger">{{  $errors->first('description')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description">Short Description</label>
                                <input type="text" name="short_description" id="short_description" value="{{$product->short_description}}" class="form-control" placeholder="">
                                @if ($errors->has('short_description'))
                                <span class="text-danger">{{  $errors->first('short_description')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description">Shipping and Returns</label>
                                <input type="text" name="shipping_returns" id="shipping_returns" value="{{$product->shipping_returns}}" class="form-control" placeholder="">
                                @if ($errors->has('shipping_returns'))
                                <span class="text-danger">{{  $errors->first('shipping_returns')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control" value="{{$product->image}}"/>
                            @if ($errors->has('image'))
                            <span class="text-danger">{{  $errors->first('image')  }}</span>
                            @endif 
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price">Price</label>
                                <input type="text" name="price" id="price" value="{{$product->price}}" class="form-control" placeholder="Price">
                                @if ($errors->has('price'))
                                <span class="text-danger">{{  $errors->first('price')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="compare_price">Compare at Price</label>
                                <input type="text" name="compare_price" id="compare_price" value="{{$product->compare_price}}" class="form-control" placeholder="Compare Price">
                                @if ($errors->has('compare_price'))
                                <span class="text-danger">{{  $errors->first('compare_price')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sku">SKU(Stock keeping unit)</label>
                                <input type="text" name="sku" id="sku" value="{{$product->sku}}" class="form-control" placeholder="SKU">
                                @if ($errors->has('sku'))
                                <span class="text-danger">{{  $errors->first('sku')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="barcode">Barcode</label>
                                <input type="text" name="barcode" id="barcode" value="{{$product->barcode}}" class="form-control" placeholder="Barcode">
                                @if ($errors->has('barcode'))
                                <span class="text-danger">{{  $errors->first('barcode')  }}</span>
                                @endif	
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="hidden" name="track_qty" value="No">
                                    <input class="custom-control-input" type="checkbox" id="track_qty" value="Yes" name="track_qty" checked>
                                    <label for="track_qty" name="track_qty" value="{{$product->track_qty}}" class="custom-control-label">Track Quantity</label>
                                    @if ($errors->has('track_qty'))
                                    <span class="text-danger">{{  $errors->first('track_qty')  }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="number" min="0" name="qty" id="qty" value="{{$product->qty}}" class="form-control" placeholder="Qty">	
                            </div>
                        </div>
                        <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Product status</h2>
                                        <div class="mb-3">
                                            <select name="status" id="status" value="{{$product->status}}" class="form-control">
                                                <option {{ ($product->status == 1) ? 'selected': ''}} value="1">Active</option>	
                                                <option {{ ($product->status == 0) ? 'selected': ''}} value="0">Block</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 	
                        <div class="card">
                            <div class="card-body">	
                                <h2 class="h4  mb-3">Product Category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" value="{{$product->category_id}}" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                        <option {{ ($product->category_id == $category->id) ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>


                                        @endforeach
                                        @if ($errors->has('category'))
                                        <span class="text-danger">{{  $errors->first('category')  }}</span>
                                        @endif
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub Category</label>
                                    <select name="sub_category" id="sub_category" value="{{old('sub_category')}}" class="form-control">
                                        <option value="">Select a Subcategory</option>
                                        @if ($subcategories->isNotEmpty())
                                        @foreach ($subcategories as $subcategory)
                                        <option {{ ($product->sub_category_id == $subcategory->id) ? 'selected': ''}} value="{{$subcategory->id}}">{{$subcategory->name}}</option>


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
                                <h2 class="h4 mb-3">Product Brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" value="{{old('brand')}}" class="form-control">
                                        <option value="">Select a Brand</option>
                                        @if ($brands->isNotEmpty())
                                        @foreach ($brands as $brand)
                                        <option {{ ($product->brand_id == $brand->id) ? 'selected': ''}} value="{{$brand->id}}">{{$brand->name}}</option>

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
                                <h2 class="h4 mb-3">Featured Product</h2>
                                <div class="mb-3">
                                    <select name="feature" id="feature" value="{{$product->feature}}" class="form-control">
                                        <option {{ ($product->feature == 'Yes') ? 'selected': ''}} value="Yes">Yes</option>	
                                        <option {{ ($product->feature == 'No') ? 'selected': ''}} value="No">No</option>                                               
                                    </select>
                                    @if ($errors->has('feature'))
                                    <span class="text-danger">{{  $errors->first('feature')  }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">	
                                <h2 class="h4 mb-3">Related Products</h2>
                                <div class="mb-3">
                                   <select class="related-product w-100" name="related_products" id="related_products">

                                   </select>
                                   
                                </div>
                            </div>
                        </div>							
                    </div>
                </div>							
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{route('product.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('customJs')
    <script>
        $('.related-product').select2({
        ajax: {
            url: '{{ route("product.getProducts") }}',
            dataType: 'json',
            tags: true,
            multiple: true,
            minimumInputLength: 3,
            processResults: function (data) {
                return {
                    results: data.tags
                };
            }
        }
    }); 
    </script>
@endsection