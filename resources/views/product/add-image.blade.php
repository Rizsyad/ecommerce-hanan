@extends('template.template_dashboard')

@section('title', 'Add Images')

@section('head')

@endsection

@section('content-back')
<div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Add Product {{$product->name_product}}</h5>
          <small class="text-muted float-end">
            <a href="{{route('dashboard.product.index')}}" class="btn btn-primary">Back</a>
          </small>
        </div>
        <div class="card-body">
          <form action="{{route('dashboard.product.store-image', $product->slug)}}" method="POST" enctype="multipart/form-data">
            @csrf
           
            <div class="mb-3">
              <label class="form-label" for="image">Image</label>
              <input type="file" class="form-control" id="image" name="image">
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
