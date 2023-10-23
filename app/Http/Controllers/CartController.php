<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $product = Product::find($request->id);
        
        if($product == null){
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ]);
        }

        if(Cart::count() > 0){

            $cartContent = Cart::content();
            $productAlreadyExist = false;

            foreach ($cartContent as $item) {
                if($item->id == $product->id){
                    $productAlreadyExist = true;
                }
            }


            if($productAlreadyExist == false){
                Cart::add($product->id, $product->title, 1, $product->price, ['image' => $product->image]);
                $status = true;
                $message = $product->title.' added to cart';
            }else{
                $status = false;
                $message = $product->title.' already added to cart';
            }


        }else{
            echo 'Cart is empty now adding a new product';
            Cart::add($product->id, $product->title, 1, $product->price, ['image' => $product->image]);
            $status = true;
            $message = $product->title.' added to cart';

        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function cart(){
        $cartContent = Cart::content();
        $data['cartContent'] = $cartContent;
        return view('front.cart',$data);
    }

    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);
        $product = Product::find($itemInfo->id);
        // check product qty
        if($product->track_qty == 'Yes'){
            if($qty <= $product->qty){
                Cart::update($rowId,$qty);
                $message = 'Cart updated successfully';
                $status = true;
                session()->flash('success',$message);
            }else{
                $message = 'Requested quantity ('.$qty.') not available';
                $status = false;
                session()->flash('error',$message);
            }
        }else{
            Cart::update($rowId,$qty);
                $message = 'Cart updated successfully';
                $status = true;
                session()->flash('success',$message);
        }


        

        
        
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function deleteItem(Request $request){

        $itemInfo = Cart::get($request->rowId);

        if($itemInfo == null){
            $errorMessage = 'Item not found in cart';
            session()->flash('error',$errorMessage);
            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);
        }else{
            Cart::remove($request->rowId);
            $successMessage = 'Item removed from cart successfully';
            session()->flash('success',$successMessage);
            return response()->json([
                'status' => true,
                'message' => $successMessage
            ]);
        }
    }

    public function checkout(){

        if(Cart::count() == 0){
            return redirect()->route('front.cart');
        }
        $countries = Country::orderBy('name','ASC')->get();
        $customerAddress = CustomerAddress::where('user_id',Auth::user()->id)->first();
        return view('front.checkout',[
            'countries' => $countries,
            'customerAddress' => $customerAddress
        ]);
    }

    public function processCheckout(Request $request){

        $request->validate([
            'first_name' => 'required|min:3',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:10',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);

//customer address
        $user = Auth::user();

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->apartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,
                'first_name' => $request->first_name,
            ]
        );

        //order details

        if($request->payment_method == 'cod'){
            $subTotal = Cart::subtotal(2,'.','');
            $shipping = 0;
            $discount = 0;
            $coupon = 0;
            $grandTotal = $subTotal+$shipping;

            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total = $grandTotal;
            $order->user_id = $user->id;
            $order->payment_status = 'due';
            $order->status = 'pending';

            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->country_id = $request->country;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->zip = $request->zip;
            $order->notes = $request->order_notes;

            $order->save();

            //orderitem details

            foreach(Cart::content() as $item){
                $orderItem = new OrderItem;
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price*$item->qty;
                $orderItem->save();
            }
                

                Cart::destroy();

                return redirect()->route('front.thanks')->with('success','You have successfully placed your order.');

            
            

        }else{
            //stripe
        }

    }

    public function thanks(){
        return view('front.thanks');

    }
}
