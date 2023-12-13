@extends('layouts.admin')

@section('content')

@if (session('message'))
    <div class="alert alert-success">
        <h6>{{ session('message') }}</h6>
    </div>
@endif

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="me-md-3 me-xl-5">
            @if(session('message'))
                <h2>{{ session('message') }}</h2>
            @endif
            <p class="mb-md-0">Swiftcart Analytics.</p>
            <hr>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="card card-body bg-primary text-white mb-3" style="border-radius:10px;">
                    <label>Total Orders</label>
                    <h1>{{ $totalOrder }}</h1>
                    <a href="{{ url('admin/orders') }}" class="text-white">View</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-body bg-danger text-white mb-3" style="border-radius:10px;">
                    <label>Today Orders</label>
                    <h1>{{ $todayOrder }}</h1>
                    <a href="{{ url('admin/orders') }}" class="text-white">View</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-body bg-success text-white mb-3" style="border-radius:10px;">
                    <label>This Month Orders</label>
                    <h1>{{ $thisMonthOrder }}</h1>
                    <a href="{{ url('admin/orders') }}" class="text-white">View</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-body bg-warning text-white mb-3" style="border-radius:10px;">
                    <label>Year Orders</label>
                    <h1>{{ $thisYearOrder }}</h1>
                    <a href="{{ url('admin/orders') }}" class="text-white">View</a>
                </div>
            </div>
            <hr>
            <div class="col-md-3">
              <div class="card card-body bg-success text-white mb-3" style="border-radius:10px;">
                  <label>Total Products</label>
                  <h1>{{ $totalProducts }}</h1>
                  <a href="{{ url('admin/products') }}" class="text-white">View</a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card card-body bg-primary text-white mb-3" style="border-radius:10px;">
                  <label>Total Categories</label>
                  <h1>{{ $totalCategories }}</h1>
                  <a href="{{ url('admin/category') }}" class="text-white" style="border-radius:10px;">View</a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card card-body bg-danger text-white mb-3" style="border-radius:10px;">
                  <label>Total Brands</label>
                  <h1>{{ $totalBrands }}</h1>
                  <a href="{{ url('admin/brands') }}" class="text-white">View</a>
              </div>
            </div>
            <hr>
            <div class="col-md-3">
              <div class="card card-body bg-danger text-white mb-3" style="border-radius:10px;">
                  <label>No. of Admin</label>
                  <h1>{{ $totalAdmins }}</h1>
                  <a href="{{ url('admin/users') }}" class="text-white">View</a>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card card-body bg-warning text-white mb-3" style="border-radius:10px;">
                  <label>No. of Users</label>
                  <h1>{{ $totalUsers }}</h1>
                  <a href="{{ url('admin/users') }}" class="text-white">View</a>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
