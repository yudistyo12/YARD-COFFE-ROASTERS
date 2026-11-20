<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    private const TRANSITIONS = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['preparing', 'cancelled'],
        'preparing' => ['ready', 'cancelled'],
        'ready' => ['completed'],
        'completed' => [],
        'cancelled' => [],
    ];

    public function index(Request $request): View
    {
        $status = $request->query('status');
        $orders = Order::query()
            ->when($status && array_key_exists($status, Order::STATUSES), fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order): View
    {
        $order->load('items');

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
            'allowedStatuses' => self::TRANSITIONS[$order->status] ?? [],
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(array_keys(Order::STATUSES))],
        ]);
        $nextStatus = $validated['status'];

        DB::transaction(function () use ($order, $nextStatus) {
            $lockedOrder = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();

            if (! in_array($nextStatus, self::TRANSITIONS[$lockedOrder->status] ?? [], true)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'status' => 'Perubahan status pesanan ini tidak diperbolehkan.',
                ]);
            }

            if ($nextStatus === 'cancelled') {
                $lockedOrder->load('items');

                foreach ($lockedOrder->items as $item) {
                    if ($item->product_id) {
                        $item->product()->lockForUpdate()->first()?->increment('stock', $item->quantity);
                    }
                }
            }

            $lockedOrder->update(['status' => $nextStatus]);
        });

        return redirect()->route('admin.orders.show', $order)->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
