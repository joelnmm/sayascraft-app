@extends('layouts.admin-base')
@section('content')
<head>
    <link rel="stylesheet" type="text/css" href="/assets/css/form-bold.css"> 
</head>

<div class="formbold-main-wrapper" >
    <!-- Author: FormBold Team -->
    <!-- Learn More: https://formbold.com -->
    <div class="w-full">
        <div class="formbold-form-wrapper active">
        <div class="formbold-form-header">
            <h3>Create a category</h3>
            <button>
                <a href="{{ route('admin.categories')}}" class="btn btn-success">All Categories</a>
            </button>
        </div>
        <form action="{{url('admin/update-category')}}" method="POST" enctype="multipart/form-data" class="formbold-chatbox-form">
        @csrf
            <input type="text" name="id" id="id" value="{{$category->id}}" class="formbold-form-input" style="display:none;"/>            

            <div class="formbold-mb-5">
                <label for="type" class="formbold-form-label">Category Name</label>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="type" id="type" value="{{$category->type}}" class="formbold-form-input"/>
            </div>

            <div class="formbold-mb-5" >
                <label for="subtype" class="formbold-form-label">Subcategories</label>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="text" name="subtype" id="subtype" value="{{$category->subtype}}" class="formbold-form-input"/>
            </div>

            <div>
                <button class="formbold-btn w-full" type="submit">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection

