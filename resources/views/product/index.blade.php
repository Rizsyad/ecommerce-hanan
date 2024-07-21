@extends('template.template_dashboard')

@section('title', 'Lists Products')

@section('head')

@endsection

@section('content-back')
    <div class="card">
        <h5 class="card-header">
            <a href="{{ route('dashboard.product.create') }}" class="btn btn-primary">Add Product</a>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name Product</th>
                        <th>Slug</th>
                        <th>stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <span class="fw-medium">{{ $loop->iteration }}</span>
                            </td>
                            @if (!$product->image)
                            <td>
                                <img src="{{ asset('noimage.jpg') }}" style="width: 50px; height: 50px; border-radius: 100%" alt="">
                            </td>
                            @else
                            <td>
                                    <img src="{{ asset('storage/' . $product->image) }}" style="width: 50px; height: 50px; border-radius: 100%" alt="">
                                    
                                </td>
                            @endif
                            <td>{{ $product->name_product }}</td>

                            <td><span class=" bg-label-primary m-1 p-2">{{ $product->slug }}</span></td>
                            <td>
                                @if ($product->stock <= 10)
                                    <span class="bg-label-danger p-2">Product Stock Low (10)</span>
                                @else
                                    <span class="bg-label-success text-black p-2">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('dashboard.product.list-image', $product->slug) }}">
                                            <i class="bx bx-image-alt me-1"></i> Add Image
                                        </a>
                                        <a class="dropdown-item" href="{{ route('dashboard.product.edit', $product->slug) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('dashboard.product.destroy', $product->slug) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this product?');">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
