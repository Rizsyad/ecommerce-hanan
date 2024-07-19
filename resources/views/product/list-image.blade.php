@extends('template.template_dashboard')

@section('title', 'Lists Products')

@section('head')

@endsection

@section('content-back')
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">List Images: {{$product->name_product}}</h5>
        <small class="text-muted float-end">
          <a href="{{route('dashboard.product.add-image', $product->slug)}}" class="btn btn-success">Add Images</a>
          <a href="{{route('dashboard.product.index')}}" class="btn btn-primary">Back</a>
        </small>
      </div>
      <div class="card-body">
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            @foreach ($images as $image)
                <div class="col">
                    <div class="card h-100">
                        <img class="card-img-top" src="{{ asset('storage/' . $image->image) }}" alt="Card image cap">
                        <div class="card-body">
                            <form action="{{ route('dashboard.product.delete-image', [$product->slug, $image->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">Delete Image</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
      </div>
    </div>
@endsection
