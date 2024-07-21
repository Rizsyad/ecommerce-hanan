@extends('template.template_dashboard')

@section('title', 'Lists Carousel Image')

@section('head')

@endsection

@section('content-back')
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">List Carousel Image</h5>
        <small class="text-muted float-end">
          <a href="{{route('dashboard.carouselImage.create')}}" class="btn btn-success">Add Carousel Image</a>
        </small>
      </div>
      <div class="card-body">
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            @foreach ($carouselImage as $image)
                <div class="col">
                    <div class="card h-100">
                        <img class="card-img-top" src="{{ asset('storage/' . $image->image) }}" alt="Card image cap">
                        <div class="card-body">
                            <form action="{{ route('dashboard.carouselImage.destroy', $image->id) }}" method="POST" enctype="multipart/form-data">
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
