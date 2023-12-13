@extends('layouts.admin')

@section('title','My Orders')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Customer Orders</h3>
            </div>
            <div class="card-body">

                <form action="" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Filter by Date</label>
                            <input type="date" name="date" value="{{ Request::get('date') ?? date('Y-m-d')}}" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label>Filter by Status</label>
                            <select name="status" class="form-select">
                                <option value="">--Select All Status--</option>
                                <option value="In Progress" {{Request::get('status') == 'In Progress' ? 'selected':''}}>In Progress</option>
                                <option value="Completed" {{Request::get('status') == 'Completed' ? 'selected':''}}>Completed</option>
                                <option value="Pending" {{Request::get('status') == 'Pending' ? 'selected':''}}>Pending</option>
                                <option value="Cancelled" {{Request::get('status') == 'Cancelled' ? 'selected':''}}>Cancelled</option>
                                <option value="Out-for-Delivery" {{Request::get('status') == 'Out-for-Delivery' ? 'selected':''}}>Out for Delivery</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <br>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Tracking No</th>
                                    <th>Username</th>
                                    <th>Payment Mode</th>
                                    <th>Ordered Date</th>
                                    <th>Status Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->tracking_no}}</td>
                                        <td>{{$item->fullname}}</td>
                                        <td>{{$item->payment_mode}}</td>
                                        <td>{{$item->created_at->format('Y-m-d')}}</td>
                                        <td>{{$item->status_message}}</td>
                                        <td><a href="{{url('admin/orders/'.$item->id)}}"class="btn btn-primary btn-sm">View</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">You don't have any orders</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div>
                            {{$orders->links()}}
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>



@endsection