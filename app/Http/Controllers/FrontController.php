<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){

        $products = Product::where('is_featured','Yes')->where('status',1)->paginate(4);
        $data['featuredProducts'] = $products;
        $latestProducts = Product::orderBy('id','DESC')->where('status',1)->take(8)->paginate(4);
        $data['latestProducts'] = $latestProducts;

        return view('front.home', $data);
    }
}
