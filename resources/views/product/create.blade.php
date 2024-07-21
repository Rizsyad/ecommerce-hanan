@extends('template.template_dashboard')

@section('title', 'Create Product')

@section('head')

@endsection

@section('content-back')
<div class="row">
    <div class="col-xl">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Add Product</h5>
          <small class="text-muted float-end">
            <a href="{{route('dashboard.product.index')}}" class="btn btn-primary">Back</a>
          </small>
        </div>
        <div class="card-body">
          <form action="{{route('dashboard.product.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="name">Name Product</label>
              <input type="text" class="form-control" id="name" placeholder="Enter Name Product" name="name_product">
              @error('name_product') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="price">Price Product</label>
              <input type="number" min="1" class="form-control" id="price" value="1" name="price">
              @error('price') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="stock">Stock Product</label>
              <input type="number" min="1" value="1" class="form-control" id="stock"  name="stock">
              @error('stock') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="name">Short Desc Product</label>
              <textarea name="short_description" cols="30" rows="2" class="form-control"></textarea>
              @error('short_description') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="name">Desc Product</label>
              <textarea name="description" cols="30" rows="2" class="form-control"></textarea>
              @error('description') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="image">Image</label>
              <input type="file" class="form-control" id="image" name="image">
              @error('image') 
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="category">Category</label>
              <select id="category" class="form-control" name="category_id">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name_category}}</option>
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
