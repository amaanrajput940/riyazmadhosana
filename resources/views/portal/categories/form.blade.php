@extends('layouts.portal.app')
@section('title', $category->id ? 'Edit Category' : 'Add Category')

@section('content')
<div class="container">
    <h4>{{ $category->id ? 'Edit Category' : 'Add Category' }}</h4>

    <form id="categoryForm" action="{{ $category->id ? route('dashboard.categories.update', $category->id) : route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($category->id)
            @method('PUT')
        @endif

        {{-- Parent Category --}}
        <div class="mb-3">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
            @error('name') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
            @if($category->image)
                <img src="{{ asset('storage/'.$category->image) }}" width="80" class="mt-2">
            @endif
            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        {{-- Status --}}
        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        {{-- Sort Order --}}
        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}">
        </div>

        <button type="submit" class="btn btn-success">{{ $category->id ? 'Update' : 'Add' }}</button>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $("#categoryForm").validate({
        errorClass: "invalid-feedback",
        errorElement: "div",
        highlight: function(el){ $(el).addClass('is-invalid'); },
        unhighlight: function(el){ $(el).removeClass('is-invalid').addClass('is-valid'); },
        errorPlacement: function(error, el){ error.insertAfter(el); },
        rules: {
            name: { required: true, minlength: 3 },
            parent_id: { digits: true },
            image: { extension: "jpg|jpeg|png|gif" }
        },
        messages: {
            name: { required: "Category name is required", minlength: "Minimum 3 characters" },
            parent_id: { digits: "Parent ID must be a number" },
            image: { extension: "Only jpg, jpeg, png, gif allowed" }
        }
    });
});
</script>
@endpush
