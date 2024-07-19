@extends('template.template_dashboard')

@section('title', 'Lists Categories')

@section('head')

@endsection

@section('content-back')
    <div class="card">
        <h5 class="card-header">
            <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary">Add Categories</a>
        </h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name Category</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($categories as $category)
                        <tr>
                            <td>
                                <span class="fw-medium">{{ $loop->iteration }}</span>
                            </td>
                            @if (!$category->image)
                            <td>
                                <img src="{{ asset('noimage.jpg') }}" style="width: 100px; height: 100px" alt="">
                            </td>
                            @else
                            <td>
                                    <img src="{{ asset('storage/' . $category->image) }}" style="width: 100px; height: 100px" alt="">
                                    
                                </td>
                            @endif
                            <td>{{ $category->name_category }}</td>

                            <td><span class=" bg-label-primary m-1 p-2">{{ $category->slug }}</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('dashboard.categories.edit', $category->slug) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('dashboard.categories.destroy', $category->slug) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this category?');">
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
