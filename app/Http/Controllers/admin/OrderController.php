<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){

        $orders = Order::latest('orders.created_at')->select('orders.*','users.name','users.email');
        $orders = $orders->leftJoin('users','users.id','orders.user_id');

        if($request->get('keyword') != ''){
            $orders = $orders->where('users.name','like','%'.$request->keyword.'%');
            $orders = $orders->orWhere('users.email','like','%'.$request->keyword.'%');
            $orders = $orders->orWhere('orders.id','like','%'.$request->keyword.'%');
        }

        $orders = $orders->paginate(6);

        return view('admin.orders.list',[
            'orders' => $orders
        ]);
    }

    public function detail($id){

        $order = Order::where('orders.id',$id)->leftJoin('countries','countries.id','orders.country_id')->select('orders.*','countries.name as country')->first();

        $orderItems = OrderItem::where('order_id',$id)->get();
        return view('admin.orders.detail',[
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }

    public function updateStatus(Request $request,$id){
        $order = Order::where('id',$id)->first();
        $order->status = $request->status;
        if(isset($request->shipped_date)){
            $order->shipped_date = $request->shipped_date;
        }
        // dd($request->all());
        $order->save();
        
        return redirect()->route('order.detail',$order->id)->with('success','Order status updated');

    }
}
