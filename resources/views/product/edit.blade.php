@extends('template.template_dashboard')

@section('title', 'Update Product')

@section('head')

@endsection

@section('content-back')
<div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Update Product</h5>
          <small class="text-muted float-end">
            <a href="{{route('dashboard.product.index')}}" class="btn btn-primary">Back</a>
          </small>
        </div>
        <div class="card-body">
          <form action="{{route('dashboard.product.update', $product->slug)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label" for="name">Name Product</label>
              <input type="text" class="form-control" id="name" placeholder="Enter Name Product" name="name_product" value="{{$product->name_product}}">
              @error('name_product') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="price">Price Product</label>
              <input type="number" min="1" class="form-control" id="price" name="price" value="{{$product->price}}">
              @error('price') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="stock">Stock Product</label>
              <input type="number" min="1" class="form-control" id="stock" name="stock" value="{{$product->stock}}">
              @error('stock') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="name">Short Desc Product</label>
              <textarea name="short_description" id="" cols="30" rows="2" class="form-control">
                {{$product->short_description}}
              </textarea>
              @error('description') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="name">Description Product</label>
              <textarea name="description" id="" cols="30" rows="4" class="form-control">
                {{$product->description}}
              </textarea>
              @error('description') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="image">Image</label>
              <input type="file" class="form-control" id="image" name="image" value="{{$product->image}}">
              @error('image') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="category">Category</label>
              <select id="category" class="form-control" name="category_id">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}" @if($category->id == $product->category_id) selected @endif>{{$category->name_category}}</option>
                @endforeach
              </select>
              @error('category_id') 
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
