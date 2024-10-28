<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_Item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('customer', 'orderItems.pizza')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'fk_customer_id' => 'required|exists:customers,pk_id',
            'total_price' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.pizza_id' => 'required|exists:pizzas,pk_id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric',
        ]);

        // Creating the order and associating it with the customer
        $order = Order::create([
            'fk_customer_id' => $request->fk_customer_id,
            'total_price' => $request->total_price,
        ]);

        // Creating each order item and associating it with the order
        foreach ($request->order_items as $item) {
            Order_Item::create([
                'fk_order_id' => $order->pk_id,
                'fk_pizza_id' => $item['pizza_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json($order->load('orderItems.pizza'), 201);
    }

    public function show($customerId)
    {
        // Retrieve the customer with their orders, order items, and associated pizzas
        $customerOrders = Order::with(['orderItems.pizza'])
            ->where('fk_customer_id', $customerId)
            ->get();

        // Return the orders for the given customer along with their items and pizzas
            return response()->json($customerOrders);
    }


    public function update(Request $request, Order $order)
    {
        $request->validate([
            'fk_customer_id' => 'required|exists:customers,pk_id',
            'total_price' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.pizza_id' => 'required|exists:pizzas,pk_id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric',
        ]);

        $order->update($request->only(['fk_customer_id', 'total_price']));

        // Delete all existing order items for this order
        $order->orderItems()->delete();

        // Create new order items from the request
        foreach ($request->order_items as $item) {
            Order_Item::create([
                'fk_order_id' => $order->pk_id,
                'fk_pizza_id' => $item['pizza_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return response()->json($order->load('orderItems.pizza'), 201);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->noContent();
    }
}
