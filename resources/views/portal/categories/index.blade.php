@extends('layouts.portal.app')
@section('title', 'Categories')

@section('content')
<div class="container">
    <h4>Categories</h4>
    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary mb-3">Add Category</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Parent</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Image</th>
                <th>Status</th>
                <th>Sort Order</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->parent?->name ?? '-' }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>
                    @if($category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" width="50">
                    @endif
                </td>
                <td>{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                <td>{{ $category->sort_order }}</td>
                <td>
                    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
</div>
@endsection
