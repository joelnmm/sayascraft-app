@extends('layouts.admin-base')
@section('content')
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8"><h2>Users <b>List</b></h2></div>
                        <div style="height: 10px;"></div>
                        <div class="col-sm-8">
                            <a href="{{ route('admin.products.create')}}" class="btn btn-success">Add New User</a>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->utype}}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <a href="#" class="view" title="View" data-toggle="tooltip"><i class="material-icons">&#xE417;</i></a>
                                    <a href="{{ url('/admin/edit-product', ['id'=> $user->id]) }}" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    <a href="{{ url('/admin/destroy-product', ['id'=> $user->id]) }}" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="clearfix st">
                    {{$users->links()}}
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection