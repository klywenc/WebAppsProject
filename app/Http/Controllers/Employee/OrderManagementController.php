<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.menu'])
            ->whereIn('status', ['new', 'in_progress']) // To sprawia, że widzimy tylko nowe i w realizacji
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employee.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);
        
        // Po zmianie statusu na "delivered" lub "cancelled", zamówienie zniknie z listy
        // ponieważ nie będzie już spełniać warunku whereIn(['new', 'in_progress'])

        return redirect()->route('employee.orders.index')
            ->with('success', 'Status zamówienia został zaktualizowany.');
    }
}