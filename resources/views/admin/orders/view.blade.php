@extends('layouts.admin')

@section('title','Customer Order Details')

@section('content')

<div class="row">
    <div class="col-md-12">

        @if (session('message'))
            <div class="alert alert-success mb-3">{{session('message')}}</div>
        @endif

        <div class="card">
            <div class="card-header">
                    <h4 class="text-primary">
                        <i class="fa fa-shopping-cart text-dark"></i> My Order Details
                        <a href="{{url('admin/orders')}}"class="btn btn-danger btn-sm m-1 float-end">Back</a>
                        <a href="{{url('admin/invoice/'.$order->id.'/generate')}}"class="btn btn-primary btn-sm m-1 float-end">Download Invoice</a>
                        <a href="{{url('admin/invoice/'.$order->id)}}" target="_blank" class="btn btn-warning m-1 btn-sm float-end">View Invoice</a>
                        <a href="{{url('admin/invoice/'.$order->id.'/mail')}}" class="btn btn-info m-1 btn-sm float-end">Send Invoice Mail</a>
                    </h4>
            </div>
            <div class="card-body">
                <div class="shadow bg-white p-3">
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Order Details</h5>
                            <hr>
                            <h6>Order Id : {{$order->id}}</h6>
                            <h6>Tracking Id/No : {{$order->tracking_no}}</h6>
                            <h6>Order Placement Date : {{$order->created_at->format('Y-m-d h:i A')}}</h6>
                            <h6>Payment Mode : {{$order->payment_mode}}</h6>
                            <h6 class="border p-2 text-success">
                                Order Status Message : <span class="">{{$order->status_message}}</span>
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <h5>User Details</h5>
                            <hr>
                            <h6>Full Name : {{$order->fullname}}</h6>
                            <h6>Email : {{$order->email}}</h6>
                            <h6>Phone : {{$order->phone}}</h6>
                            <h6>Address: {{$order->address}}</h6>
                            <h6>Zip Code : {{$order->pincode}}</h6>
                        </div>
                    </div>
                    <br>
                    <h5>Order Items</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Item Id</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($order->orderItems as $orderItem)
                                    <tr>
                                        <td width="10%">{{$orderItem->id}}</td>
                                        <td width="10%">
                                            @if ($orderItem->product->productImages)
                                            <img src="{{asset($orderItem->product->productImages[0]->image)}}" 
                                            style="width: 50px; height: 50px" alt="{{$orderItem->product->name}}">
                                            @else
                                            <img src="" 
                                            style="width: 50px; height: 50px" alt="">
                                            @endif
                                        </td>
                                        <td>
                                            {{$orderItem->product->name}}
                                            @if ($orderItem->productColor)
                                                @if ($orderItem->productColor->color)
                                                <span> - Color: {{$orderItem->productColor->color->name}}</span> 
                                                @endif                                      
                                            @endif
                                        </td>
                                        <td width="10%">₱{{$orderItem->price}}</td>
                                        <td width="10%">{{$orderItem->quantity}}</td>
                                        <td width="10%" class="fw-bold">₱{{$orderItem->quantity * $orderItem->price}}</td>
                                        @php
                                            $totalPrice += $orderItem->quantity * $orderItem->price;
                                        @endphp
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="fw-bold">Total Amount : </td>
                                    <td colspan="1" class="fw-bold">₱{{$totalPrice}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border mt-3">
            <div class="card-body">
                <h4>Order Process (Order Status Updates)</h4>
                <hr>
                <div class="row">
                    <div class="com-md-5">
                        <form action="{{url('admin/orders/'.$order->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <label>Update Your Order Status</label>
                            <div class="input-group">
                                <select name="order_status" class="form-select">
                                    <option value="">--Select Order Status--</option>
                                    <option value="In Progress" {{Request::get('status') == 'In Progress' ? 'selected':''}}>In Progress</option>
                                    <option value="Completed" {{Request::get('status') == 'Completed' ? 'selected':''}}>Completed</option>
                                    <option value="Pending" {{Request::get('status') == 'Pending' ? 'selected':''}}>Pending</option>
                                    <option value="Cancelled" {{Request::get('status') == 'Cancelled' ? 'selected':''}}>Cancelled</option>
                                    <option value="Out-for-Delivery" {{Request::get('status') == 'Out-for-Delivery' ? 'selected':''}}>Out for Delivery</option>
                                </select>
                                <button type="submit" class="btn btn-primary text-white">Update</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-7">
                        <br>
                            <h4 class="mt-3">Order Status: <span>{{$order->status_message}}</span></h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
 </div>


@endsection