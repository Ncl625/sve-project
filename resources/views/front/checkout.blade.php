@extends('front.layouts.parent')
@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">Checkout</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-9 pt-4">
    <div class="container">
        <form name="orderForm" id="orderForm" action="{{ route('front.processCheckout') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="first_name" id="first_name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : old('first_name') }}" class="form-control" placeholder="First Name">
                                    </div>       
                                    @if ($errors->has('first_name'))
                                    <span class="text-danger">{{  $errors->first('first_name')  }}</span>
                                    @endif     
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="last_name" id="last_name" value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : old('last_name')}}" class="form-control" placeholder="Last Name">
                                    </div>       
                                    @if ($errors->has('last_name'))
                                    <span class="text-danger">{{  $errors->first('last_name')  }}</span>
                                    @endif      
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" value="{{ (!empty($customerAddress)) ? $customerAddress->email : old('email')}}" class="form-control" placeholder="Email">
                                    </div>    
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{  $errors->first('email')  }}</span>
                                    @endif         
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Select a Country</option>
                                            @if ($countries->isNotEmpty())
                                                @foreach ($countries as $country)
                                                    <option {{  (!empty($customerAddress)) && ($customerAddress->country_id == $country->id) ? 'selected' : '' }} value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>   
                                    @if ($errors->has('country'))
                                    <span class="text-danger">{{  $errors->first('country')  }}</span>
                                    @endif          
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">{{ (!empty($customerAddress)) ? $customerAddress->address : old('address')}}</textarea>
                                    </div>     
                                    @if ($errors->has('address'))
                                    <span class="text-danger">{{  $errors->first('address')  }}</span>
                                    @endif        
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="apartment" value="{{ (!empty($customerAddress)) ? $customerAddress->apartment : old('apartment')}}" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                                    </div>  
                                    @if ($errors->has('apartment'))
                                    <span class="text-danger">{{  $errors->first('apartment')  }}</span>
                                    @endif           
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="city" id="city" value="{{ (!empty($customerAddress)) ? $customerAddress->city : old('city')}}" class="form-control" placeholder="City">
                                    </div> 
                                    @if ($errors->has('city'))
                                    <span class="text-danger">{{  $errors->first('city')  }}</span>
                                    @endif            
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="state" id="state" value="{{ (!empty($customerAddress)) ? $customerAddress->state : old('state')}}" class="form-control" placeholder="State">
                                    </div> 
                                    @if ($errors->has('state'))
                                    <span class="text-danger">{{  $errors->first('state')  }}</span>
                                    @endif            
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" name="zip" id="zip" value="{{ (!empty($customerAddress)) ? $customerAddress->zip : old('zip')}}" class="form-control" placeholder="Zip">
                                    </div> 
                                    @if ($errors->has('zip'))
                                    <span class="text-danger">{{  $errors->first('zip')  }}</span>
                                    @endif            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" value="{{ (!empty($customerAddress)) ? $customerAddress->mobile : old('mobile')}}" class="form-control" placeholder="Mobile No.">
                                    </div> 
                                    @if ($errors->has('mobile'))
                                    <span class="text-danger">{{  $errors->first('mobile')  }}</span>
                                    @endif            
                                </div>
                                

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" id="order_notes" value="{{old('order_notes')}}" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div> 
                                </div>

                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div>                    
                    <div class="card cart-summery">
                        <div class="card-body">
                            @foreach (Cart::content() as $item)
                                <div class="d-flex justify-content-between pb-2">
                                    <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                                    <div class="h6">${{$item->price*$item->qty}}</div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6"><strong>${{Cart::subtotal()}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6"><strong>$0</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5"><strong>${{Cart::subtotal()}}</strong></div>
                            </div>                            
                        </div>
                    </div>   
                    
                    <div class="card payment-form ">                        
                        <h3 class="card-title h5 mb-3">Payment Details</h3>
                        <div>
                            <input checked type="radio" value="cod" name="payment_method" id="payment_method_one">
                            <label for="payment_method_one" class="form-check-label">Cash on delivery</label>
                        </div>
                        <div>
                            <input type="radio" value="stripe" name="payment_method" id="payment_method_two">
                            <label for="payment_method_two" class="form-check-label">Stripe</label>
                        </div>
                        <div class="card-body p-0 d-none" id="card-payment-form">
                            <div class="mb-3 mt-3">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">CVV Code</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                </div>
                            </div>
                            
                        </div>  
                        <div class="pt-4">
                            {{-- <a href="#" >Pay Now</a> --}}
                            <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</button>
                        </div>                      
                    </div>

                        
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
@section('customJs')
    <script>
        $("#payment_method_one").click(function(){
            if($(this).is(":checked")==true){
                $("#card-payment-form").addClass('d-none');
            }
        })
        $("#payment_method_two").click(function(){
            if($(this).is(":checked")==true){
                $("#card-payment-form").removeClass('d-none');
            }
        })
    </script>
@endsection