<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function index(Request $request){
        $brands = Brand::latest();


        if(!empty($request->get('keyword'))){
            $brands = $brands->where('name','like','%'.$request->get('keyword').'%');
        }

        $brands = $brands->paginate(5);
        return view('admin.brand.index',compact('brands'));
    }

    public function create(){
        return view('admin.brand.create');

    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands'
            
        ]);
            

    



        
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();


            return redirect()->route('brand.index')->with('success','Brand added successfully');

        
    }

    public function edit($id){
        $brand = Brand::where('id',$id)->first();
        return view('admin.brand.edit',['brand'=>$brand]);
    }

    public function update(Request $request, $id){

        $brand = Brand::where('id',$id)->first();
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,'.$brand->id.',id'
            
        ]);

        

        

        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;

        $brand->save();

        return redirect()->route('brand.index')->with('success','Brand updated successfully');


    }

    public function destroy($id){
        
        $brand = Brand::where('id',$id)->first();
        $brand->delete();


        return redirect()->route('brand.index')->with('success','Brand deleted successfully');

    }

}
