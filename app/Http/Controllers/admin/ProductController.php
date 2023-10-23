<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request){
        $products = Product::latest();

        if(!empty($request->get('keyword'))){
            $products = $products->where('title','like','%'.$request->get('keyword').'%');
        }

        $products = $products->paginate(5);
        return view('admin.product.index',compact('products'));
    }

    public function create(Request $request , $categorySlug = null){
        $data=[];
        // $category = $request->category_id->get();
        $categories = Category::orderBy('name','ASC')->get();
        $subcategories =SubCategory::orderBy('name','ASC')->get();

        // if(!empty($categorySlug)){
        //     $category = Category::where('slug',$categorySlug)->first();
        //     $subcategories = $subcategories->where('category_id',$category->id);
        // }

        $brands = Brand::orderBy('name','ASC')->get();
        $data['categories']=$categories;
        $data['brands']=$brands;
        $data['subcategories']=$subcategories;
        return view('admin.product.create', $data);
    }

    public function store(Request $request){
        
        

        
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:2048|dimensions:min_width=300,min_height=300,max_width=1000,max_height=1000',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'sub_category' => 'required|numeric',
            'brand' => 'required|numeric',
            'feature' => 'required|in:Yes,No'
        ]);

        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rule['qty'] = 'required|numeric';
        }

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('product'), $imageName);
        
            $product = new Product;
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->image = $imageName;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->feature;
            $product->shipping_returns = $request->shipping_returns;
            $product->short_description = $request->short_description;
            $product->save();
        

            return redirect()->route('product.index',)->with('success','Product added successfully');

    }

    public function edit($id){

        $product = Product::where('id',$id)->first();
        $data=[];
        $categories = Category::orderBy('name','ASC')->get();
        $subcategories = SubCategory::orderBy('name','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $data['categories']=$categories;
        $data['brands']=$brands;
        $data['subcategories']=$subcategories;
        return view('admin.product.edit',['product'=>$product],$data);
    }

    public function update(Request $request, $id){

        $product = Product::where('id',$id)->first();
        $oldImage = $product->image;
        $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:products,slug,'.$product->id.',id',
            'price' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,png,jpeg,gif|max:2048|dimensions:min_width=300,min_height=300,max_width=1000,max_height=1000',
            'sku' => 'required|unique:products,sku,'.$product->id.',id',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'sub_category' => 'required|numeric',
            'brand' => 'required|numeric',
            'feature' => 'required|in:Yes,No'
        ]);

        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rule['qty'] = 'required|numeric';
        }

        if(isset($request->image)){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('product'), $imageName);
            $product->image = $imageName;
            File::delete(public_path().'/product/'.$oldImage);
        }

        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        $product->barcode = $request->barcode;
        $product->track_qty = $request->track_qty;
        $product->qty = $request->qty;
        $product->status = $request->status;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->brand_id = $request->brand;
        $product->is_featured = $request->feature;
        $product->shipping_returns = $request->shipping_returns;
        $product->short_description = $request->short_description;
        $product->save();
    

        return redirect()->route('product.index')->with('success','Product updated successfully');


    }

    public function destroy($id){
        
        $product = Product::where('id',$id)->first();
        File::delete(public_path().'/product/'.$product->image);
        $product->delete();


        return redirect()->route('product.index')->with('success','Product deleted successfully');

    }

    public function getProducts(Request $request){

    }
}
