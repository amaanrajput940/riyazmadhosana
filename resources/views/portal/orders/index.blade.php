@extends('layouts.portal.app')

@section('title','Orders')

@section('content')
<div class="container">
    <h4>Orders List</h4>

    <table id="ordersTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Order Number</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Placed On</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#ordersTable').DataTable({
        processing: true,
        serverSide: false, // since we are loading all orders via JSON manually
        ajax: '{{ route("dashboard.orders.list") }}',
        columns: [
            { data: 'id' },
            { data: 'order_number' },
            { data: 'customer_name' },
            { data: 'total' },
            { data: 'status', orderable: false, searchable: false },
            { data: 'payment_status', orderable: false, searchable: false },
            { data: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[0,'desc']]
    });
});
</script>
@endpush
