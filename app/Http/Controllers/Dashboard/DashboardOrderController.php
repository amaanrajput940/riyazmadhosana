<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Ensure Order model imported
use App\Models\Product;
use App\Models\Category;
class DashboardOrderController extends Controller
{

 public function list(Request $request)
    {
        if ($request->ajax()) {

            $orders = Order::select([
                'id',
                'order_number',
                'first_name',
                'last_name',
                'total',
                'status',
                'payment_status',
                'created_at'
            ])->get();

            // $action = '';

          
            // Map for DataTables JSON
            $data = $orders->map(function($order) {

$action  = '<a href="'.route('dashboard.orders.view', $order->id).'" class="btn btn-sm btn-primary me-1">View</a>';

// Status update form
$action .= '<form action="'.route('dashboard.orders.updateStatus', $order->id).'" method="POST" class="d-inline me-1">';
$action .= csrf_field();
$action .= '<select name="status" onchange="this.form.submit()" class="form-select form-select-sm">';
$statuses = ['pending','confirmed','shipped','delivered','cancelled'];
foreach($statuses as $status) {
    $selected = $order->status == $status ? 'selected' : '';
    $action .= '<option value="'.$status.'" '.$selected.'>'.ucfirst($status).'</option>';
}
$action .= '</select>';
$action .= '</form>';

// Payment status update form
$action .= '<form action="'.route('dashboard.orders.updatePaymentStatus', $order->id).'" method="POST" class="d-inline">';
$action .= csrf_field();
$action .= '<select name="payment_status" onchange="this.form.submit()" class="form-select form-select-sm">';
$payment_statuses = ['pending','paid','failed'];
foreach($payment_statuses as $status) {
    $selected = $order->payment_status == $status ? 'selected' : '';
    $action .= '<option value="'.$status.'" '.$selected.'>'.ucfirst($status).'</option>';
}
$action .= '</select>';
$action .= '</form>';


                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->first_name . ' ' . $order->last_name,
                    'total' => '$' . number_format($order->total, 2),
                    'status' => $this->statusBadge($order->status),
                    'payment_status' => $this->paymentBadge($order->payment_status),
                    'created_at' => $order->created_at->format('d M, Y H:i'),
                    'action' => $action
                ];
            });

            return response()->json(['data' => $data]);
        }

        return view('portal.orders.index');
    }

    public function view(Order $order)
{
    return view('portal.orders.view', compact('order'));
}

    // Optional: Status badge HTML
    private function statusBadge($status)
    {
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
        ];

        return '<span class="badge bg-' . ($colors[$status] ?? 'secondary') . '">' . ucfirst($status) . '</span>';
    }

    private function paymentBadge($status)
    {
        $colors = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
        ];

        return '<span class="badge bg-' . ($colors[$status] ?? 'secondary') . '">' . ucfirst($status) . '</span>';
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order->payment_status = $request->payment_status;
        $order->save();

        return redirect()->back()->with('success', 'Payment status updated successfully!');
    }
}