@extends('template.template_dashboard')

@section('title', 'Update Categories')

@section('head')

@endsection

@section('content-back')
<div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Update Categories: {{$category->name_category}}</h5>
          <small class="text-muted float-end">
            <a href="{{route('dashboard.categories.index')}}" class="btn btn-primary">Back</a>
          </small>
        </div>
        <div class="card-body">
          <form action="{{route('dashboard.categories.update', $category->slug)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label" for="name">Name Category</label>
              <input type="text" class="form-control" id="name" placeholder="Enter Name Category" name="name_category" value="{{$category->name_category}}">
              @error('name_category') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="image">Image Category</label>
              <input type="file" class="form-control" id="image" name="image" value="{{$category->image}}">
              @error('image') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
          
            <button type="submit" class="btn btn-primary">Send</button>
          </form>
        </div>
      </div>
    </div>
   
  </div>
@endsection
