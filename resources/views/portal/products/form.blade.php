@extends('layouts.portal.app')

@section('title', $product->id ? 'Edit Product' : 'Add Product')

@section('content')
<div class="container">
    <h4>{{ $product->id ? 'Edit Product' : 'Add Product' }}</h4>

    <form 
        id="productForm"
        action="{{ $product->id ? route('dashboard.products.update', $product->id) : route('dashboard.products.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
    >
        @csrf
        @if($product->id)
            @method('PUT')
        @endif

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $product->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Slug --}}
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" 
                   value="{{ old('slug', $product->slug) }}" required>
            @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" 
                   value="{{ old('price', $product->price) }}" required>
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Sale Price --}}
        <div class="mb-3">
            <label class="form-label">Sale Price</label>
            <input type="number" step="0.01" name="sale_price" class="form-control" 
                   value="{{ old('sale_price', $product->sale_price) }}">
        </div>

        {{-- Stock --}}
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" 
                   value="{{ old('stock', $product->stock) }}" required>
        </div>

        {{-- SKU --}}
        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" 
                   value="{{ old('sku', $product->sku) }}" required>
            @error('sku') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Thumbnail --}}
        <div class="mb-3">
            <label class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control">
            
            @if($product->thumbnail)
                <img src="{{ asset('storage/'.$product->thumbnail) }}" 
                     width="120" class="mt-2">
            @endif
        </div>

        {{-- Status --}}
        <div class="form-check mb-2">
            <input type="checkbox" name="is_active" value="1" 
                class="form-check-input"
                {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_featured" value="1" 
                class="form-check-input"
                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label">Featured</label>
        </div>

        <button type="submit" class="btn btn-success">
            {{ $product->id ? 'Update Product' : 'Add Product' }}
        </button>
        <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">Cancel</a>

    </form>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function() {

    $.validator.addMethod("lessThanPrice", function(value, element) {
        let price = parseFloat($("input[name='price']").val());
        let salePrice = parseFloat(value);
        if (!value || isNaN(price)) return true;
        return salePrice < price;
    }, "Sale price must be less than regular price");

    $("#productForm").validate({

        ignore: [],

        errorElement: 'div',
        errorClass: 'invalid-feedback',

        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },

        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },

        errorPlacement: function(error, element) {
            // Bootstrap 5: div.invalid-feedback should follow the input
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.hasClass('form-check-input')) {
                // For checkbox/radio
                error.insertAfter(element.closest('.form-check'));
            } else {
                error.insertAfter(element);
            }
        },

        rules: {
            category_id: "required",
            name: { required: true, minlength: 3 },
            price: { required: true, number: true, min: 0 },
            sale_price: { number: true, min: 0, lessThanPrice: true },
            stock: { required: true, digits: true, min: 0 },
            sku: { required: true, minlength: 3 }
        },

        messages: {
            category_id: "Please select a category",
            name: { required: "Product name is required", minlength: "Name must be at least 3 characters" },
            price: { required: "Price is required", number: "Enter valid price", min: "Price cannot be negative" },
            sale_price: { number: "Enter valid sale price", min: "Sale price cannot be negative" },
            stock: { required: "Stock is required", digits: "Stock must be a number", min: "Stock cannot be negative" },
            sku: { required: "SKU is required", minlength: "SKU must be at least 3 characters" }
        }

    });

});

</script>
@endpush
