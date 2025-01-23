<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem; 
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function history()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.history', compact('orders'));
    }

    public function create(Request $request)
    {
        $menuItem = Menu::findOrFail($request->menu_id);
        return view('orders.create', compact('menuItem'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'required|integer|min=1',
        ]);

        $user = Auth::user();

        $order = Order::create([
            'user_id' => $user->id,
            'status' => 'new',
            'total_amount' => 0, 
        ]);

        $menu = Menu::find($request->menu_id);
        $orderItem = new OrderItem([
            'menu_id' => $menu->id,
            'quantity' => $request->quantity,
            'price' => $menu->price,
        ]);
        $order->items()->save($orderItem);

        // Update total amount
        $order->total_amount = $orderItem->price * $orderItem->quantity;
        $order->save();

        return redirect()->route('orders.history')->with('success', 'Order has been placed.');
    }

    public function storeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Koszyk jest pusty!');
        }

        $total = 0;
        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'new',
            'total_price' => $total // Zmień total_amount na total_price
        ]);

        foreach ($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('orders.history')->with('success', 'Zamówienie zostało złożone pomyślnie!');
    }
}
