<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request){
        $categories = Category::latest();

        if(!empty($request->get('keyword'))){
            $categories = $categories->where('name','like','%'.$request->get('keyword').'%');
        }

        $categories = $categories->paginate(5);
        return view('admin.category.index',compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:2048|dimensions:min_width=300,min_height=300,max_width=1000,max_height=1000'
        ]);
            

        

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('category'), $imageName);



        
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->image = $imageName;
            $category->save();

            // $request->session()->$request->session()->flash('success','Category added successfully');

            return redirect()->route('category.index')->with('success','Category added successfully');

        
    }

    public function edit($id){
        $category = Category::where('id',$id)->first();
        return view('admin.category.edit',['category'=>$category]);
    }

    public function update(Request $request, $id){

        $category = Category::where('id',$id)->first();
        $oldImage = $category->image;
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id.',id',
            'image' => 'nullable|mimes:jpg,png,jpeg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'
            // 'image' => 'nullable|mimes:png|max:100|dimensions:width=300,height=300'
        ]);

        

        if(isset($request->image)){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('category'), $imageName);
            $category->image = $imageName;
            File::delete(public_path().'/category/'.$oldImage);
        }

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->save();

        return redirect()->route('category.index')->with('success','Category updated successfully');


    }

    public function destroy($id){
        
        $category = Category::where('id',$id)->first();
        File::delete(public_path().'/category/'.$category->image);
        $category->delete();


        return redirect()->route('category.index')->with('success','Category deleted successfully');

    }
}
