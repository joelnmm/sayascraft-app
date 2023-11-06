@extends('layouts.admin-base')
@section('content')
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Coupons <b>Details</b></h2></div>
                        <div style="height: 10px;"></div>
                        <div class="col-sm-8">
                            <a href="{{ route('admin.coupons.create')}}" class="btn btn-success">Add New Coupon</a>
                        </div>
                        <div class="col-sm-4">
                            <div class="search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="text" class="form-control" placeholder="Search&hellip;">
                            </div>
                        </div>
                    </div>
                </div>
                @if(Session::has('message'))
                    <div class="alert alert-success" role="alert"> {{Session::get('message')}} </div>
                @endif
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Id<i class="fa fa-sort"></i></th>
                            <th>Coupon Code</th>
                            <th>Coupon Type</th>
                            <th>Coupon Value</th>
                            <th>Minimun Cart value</th>
                            <th>Created at</th>
                            <th>Expiry Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$coupon->id}}</td>
                                <td>{{$coupon->code}}</td>
                                <td>{{$coupon->type}}</td>
                                @if($coupon->type == 'fixed')
                                    <td>${{$coupon->value}}</td>
                                @else
                                    <td>{{$coupon->value}}%</td>
                                @endif
                                <td>{{$coupon->cart_value}}</td>
                                <td>{{$coupon->created_at}}</td>
                                <td>{{$coupon->expiry_date}}</td>
                                <td>
                                    <a href="#" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                                    <a href="{{ url('/admin/edit-coupon', ['id'=> $coupon->id]) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a href="{{ url('/admin/destroy-coupon', ['id'=> $coupon->id]) }}" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix st">
                    {{$coupons->links()}}
                    <!-- <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                    <ul class="pagination">
                        <li class="page-item disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item active"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item"><a href="#" class="page-link">5</a></li>
                        <li class="page-item"><a href="#" class="page-link"><i class="fa fa-angle-double-right"></i></a></li>
                    </ul> -->
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection

