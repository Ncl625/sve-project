<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;


class SubCategoryController extends Controller
{
    public function index(Request $request){
        $subcategories = SubCategory::select('sub_categories.*','categories.name as categoryName')->latest('id')->leftJoin('categories','categories.id','sub_categories.category_id');

        if(!empty($request->get('keyword'))){
            $subcategories = $subcategories->where('sub_categories.name','like','%'.$request->get('keyword').'%');
        }

        $subcategories = $subcategories->paginate(5);
        return view('admin.subcategory.index',compact('subcategories'));
    }

    public function create(){
        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        return view('admin.subcategory.create',$data);
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:2048|dimensions:min_width=300,min_height=300,max_width=1000,max_height=1000'
            
        ]);
            
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('subcategory'), $imageName);


        
            $subCategory = new SubCategory();
            $subCategory->category_id = $request->category;
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->image = $imageName;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->save();


            return redirect()->route('subcategory.index')->with('success','Sub Category added successfully');

    }

    public function edit($id, Request $request){
        $categories = Category::orderBy('name','ASC')->get();
        $data['categories'] = $categories;
        $subcategory = SubCategory::where('id',$id)->first();
        $data['subcategory'] = $subcategory;

        return view('admin.subcategory.edit',$data);
    }

    public function update(Request $request, $id){

        $subcategory = SubCategory::where('id',$id)->first();
        $oldImage = $subcategory->image;
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:sub_categories,slug,'.$subcategory->id.',id',
            'image' => 'nullable|mimes:jpg,png,jpeg,gif|max:2048|dimensions:min_width=300,min_height=300,max_width=1000,max_height=1000'
        ]);

        

        if(isset($request->image)){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('subcategory'), $imageName);
            $subcategory->image = $imageName;
            File::delete(public_path().'/subcategory/'.$oldImage);
        }
        
        $subcategory->category_id = $request->category;
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        $subcategory->showHome = $request->showHome;
        $subcategory->save();

        return redirect()->route('subcategory.index')->with('success','Sub Category updated successfully');


    }

    public function destroy($id){
        
        $subcategory = SubCategory::where('id',$id)->first();
        File::delete(public_path().'/subcategory/'.$subcategory->image);
        $subcategory->delete();


        return redirect()->route('subcategory.index')->with('success','Sub Category deleted successfully');

    }

}
