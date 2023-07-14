@extends('website.master')

@section('title')
Checkout Page
@endsection

@section('body')

    <div class="breadcrumbs">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                        <h1 class="page-title">checkout</h1>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                        <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                        <li><a href="index.html">Shop</a></li>
                        <li>checkout</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="checkout-steps-form-style-1">
                       <ul class="nav nav-pills">
                           <li><a href="" class="nav-link active" data-bs-target="#cash" data-bs-toggle="pill">Cash On Delivery</a></li>
                           <li><a href="" class="nav-link" data-bs-target="#online" data-bs-toggle="pill">Online</a></li>
                       </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="cash">
                                <form action="{{route('new-cash-order')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Full Name</label>
                                                <div class="col-md-12 form-input form">
                                                    @if(isset($customer->id))
                                                    <input type="text" required name="name" value="{{$customer->name}}" readonly placeholder="Full Name">
                                                    @else
                                                        <input type="text" required name="name" placeholder="Full Name">
                                                        <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : ''}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Email Address</label>
                                                <div class="form-input form">
                                                    @if(isset($customer->id))
                                                       <input type="email" required name="email" value="{{$customer->email}}" readonly placeholder="Email Address"/>
                                                    @else
                                                        <input type="email" required name="email" placeholder="Email Address"/>
                                                        <span class="text-danger">{{ $errors->has('email') ? $errors->first('email') : ''}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="single-form form-default">
                                                <label>Phone Number</label>
                                                <div class="form-input form">
                                                    @if(isset($customer->id))
                                                        <input type="number" required name="mobile" value="{{$customer->mobile}}" readonly placeholder="Phone Number">
                                                    @else
                                                        <input type="number" required name="mobile" placeholder="Phone Number">
                                                        <span class="text-danger">{{ $errors->has('mobile') ? $errors->first('mobile') : ''}}</span>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Delivery Address</label>
                                                <div class="form-input form">
                                                    <textarea  placeholder="Order Delivery Address" style="padding-top: 10px; height: 100px;"  name="delivery_address"></textarea>
                                                    <span class="text-danger">{{ $errors->has('delivery_address') ? $errors->first('delivery_address') : ''}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form form-default">
                                                <label>Payment Type</label>
                                                <div class="">
                                                    <label><input type="radio" checked name="payment_type" value="1"> Cash On Delivery</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-checkbox checkbox-style-3">
                                                <input type="checkbox" id="checkbox-3" checked>
                                                <label for="checkbox-3"><span></span></label>
                                                <p>I accept all terms & conditions</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="single-form button">
                                                <button type="submit" class="btn" >Confirm Order</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade show" id="online"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-price-table ">
                            <h5 class="title">Shopping Cart Summery</h5>
                            <div class="sub-total-price">
                                @php($total=0)
                                @foreach(ShoppingCart::all() as $item)
                                <div class="total-price">
                                    <p class="value">
                                        {{$item->name}}
                                        ({{$item->price}} * {{$item->qty}})
                                    </p>
                                    <p class="price">{{$item->price*$item->qty}}</p>
                                </div>
                                    @php($total=$total+($item->price*$item->qty))
                                @endforeach
                            </div>
                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">{{$total}}</p>
                                </div>
                                <div class="payable-price">
                                    <p class="value">Tax Amount(15%):</p>
                                    <p class="price">{{$tax = round((($total*15)/100)) }}</p>
                                </div>
                                <div class="payable-price">
                                    <p class="value">Shipping Amount:</p>
                                    <p class="price">{{$shipping = 100}}</p>
                                </div>
                            </div>
                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Total Payable:</p>
                                    <p class="price">{{$orderTotal = $total+$tax+$shipping}}</p>
                                </div>
                                <?php
                                    Session::put('order_total', $orderTotal);
                                    Session::put('tax_total', $tax);
                                    Session::put('shipping_total', $shipping);
                                ?>
                            </div>
                            <div class="price-table-btn button">
                                <a href="javascript:void(0)" class="btn btn-alt">Checkout</a>
                            </div>
                        </div>
                        <div class="checkout-sidebar-banner mt-30">
                            <a href="product-grids.html">
                                <img src="{{asset('/')}}website/assets/images/banner/banner.jpg" alt="#">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
