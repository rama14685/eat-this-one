<?php

namespace App\Http\Controllers;

use App\Models\AddOn;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'addons' => ['nullable', 'array'],
            'addons.*.id' => ['required', 'integer', 'exists:add_ons,id'],
            'addons.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($validated): Order {
            $order = Order::create([
                'order_number' => 'ETO-'.now()->format('Ymd').'-'.strtoupper(Str::random(5)),
                'customer_name' => $validated['name'],
                'customer_phone' => $validated['phone'],
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
                'ordered_at' => now(),
            ]);

            $products = Product::whereIn('id', collect($validated['items'])->pluck('id'))
                ->where('is_active', true)
                ->get()
                ->keyBy('id');

            foreach ($validated['items'] as $item) {
                $product = $products->get($item['id']);

                abort_if(! $product || $item['quantity'] > $product->stock, 422, 'Stok produk tidak mencukupi.');

                $order->items()->create([
                    'item_name' => $product->name,
                    'item_type' => 'product',
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                ]);
            }

            $addons = AddOn::whereIn('id', collect($validated['addons'] ?? [])->pluck('id'))
                ->where('is_active', true)
                ->get()
                ->keyBy('id');

            foreach ($validated['addons'] ?? [] as $item) {
                $addon = $addons->get($item['id']);

                abort_if(! $addon, 422, 'Add-on tidak tersedia.');

                $order->items()->create([
                    'item_name' => $addon->name,
                    'item_type' => 'addon',
                    'quantity' => $item['quantity'],
                    'unit_price' => $addon->price,
                ]);
            }

            return $order->load('items');
        });

        $message = "Halo Eat This One,\nSaya ingin memesan {$order->order_number}:\n\n";
        foreach ($order->items as $item) {
            $message .= "- {$item->item_name} ({$item->quantity}x) = Rp ".number_format($item->unit_price * $item->quantity, 0, ',', '.')."\n";
        }
        $message .= "\n*Total Bayar: Rp ".number_format($order->total, 0, ',', '.')."*\n\nNama: {$order->customer_name}\nNo WA: {$order->customer_phone}";

        return response()->json([
            'order_number' => $order->order_number,
            'whatsapp_url' => 'https://wa.me/6282311681167?text='.urlencode($message),
        ]);
    }

    public function print(Order $order)
    {
        return view('orders.print', ['order' => $order->load('items')]);
    }

    public function printSummary(Request $request)
    {
        $period = $request->validate([
            'period' => ['required', Rule::in(['day', 'week', 'month'])],
        ])['period'];

        [$start, $end, $label] = match ($period) {
            'day' => [now()->startOfDay(), now()->endOfDay(), 'Hari ini'],
            'week' => [now()->startOfWeek(), now()->endOfWeek(), 'Minggu ini'],
            'month' => [now()->startOfMonth(), now()->endOfMonth(), 'Bulan ini'],
        };

        $orders = Order::query()
            ->with('items')
            ->whereBetween('ordered_at', [$start, $end])
            ->latest('ordered_at')
            ->get();

        return view('orders.print-summary', compact('orders', 'label', 'start', 'end'));
    }
}
