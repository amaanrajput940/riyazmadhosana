@extends('layouts.portal.app')

@section('title','Products')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Products List</h4>
    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary">
        Add Product
    </a>
</div>

<table class="table table-bordered" id="productTable">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock</th>
            <th width="120">Action</th>
        </tr>
    </thead>
</table>

@endsection

@push('scripts')



<script>
$(document).ready(function () {

    $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dashboard.products.index') }}",
        pageLength: 10,
        order: [[0, 'desc']]
    });

});
</script>

@endpush
