<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::role('customer')->get();
        $products = Product::all();

        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'cash_on_delivery'];
        $paymentStatuses = ['pending', 'paid', 'failed'];
        $shippingMethods = ['standard', 'express', 'overnight'];

        // Create 50 orders
        for ($i = 1; $i <= 50; $i++) {
            $customer = $customers->random();
            $orderDate = now()->subDays(rand(1, 90));

            // Determine order status
            $status = $statuses[array_rand($statuses)];
            $paymentStatus = $status === 'completed' ? 'paid' : $paymentStatuses[array_rand($paymentStatuses)];

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'user_id' => $customer->id,
                'customer_email' => $customer->email,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,

                // Shipping address
                'shipping_name' => $customer->name,
                'shipping_email' => $customer->email,
                'shipping_phone' => $customer->phone,
                'shipping_address_line1' => fake()->streetAddress(),
                'shipping_city' => fake()->city(),
                'shipping_state' => fake()->stateAbbr(),
                'shipping_country' => 'USA',
                'shipping_zip_code' => fake()->postcode(),

                // Billing (same as shipping)
                'billing_same_as_shipping' => true,

                // Order details
                'subtotal' => 0, // Will be calculated
                'shipping_cost' => rand(0, 50),
                'tax_amount' => 0, // Will be calculated
                'discount_amount' => rand(0, 50),
                'total_amount' => 0, // Will be calculated

                // Payment
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => $paymentStatus,
                'paid_at' => $paymentStatus === 'paid' ? $orderDate->addHours(rand(1, 24)) : null,

                // Shipping
                'shipping_method' => $shippingMethods[array_rand($shippingMethods)],
                'shipping_weight' => rand(1, 10) * 0.5,
                'tracking_number' => $status === 'completed' ? 'TRK' . strtoupper(Str::random(10)) : null,
                'carrier' => $status === 'completed' ? ['UPS', 'FedEx', 'DHL'][array_rand([0, 1, 2])] : null,

                // Status
                'status' => $status,
                'processing_at' => $status === 'processing' || $status === 'completed' ? $orderDate->addHours(rand(2, 48)) : null,
                'shipped_at' => $status === 'completed' ? $orderDate->addHours(rand(72, 168)) : null,
                'delivered_at' => $status === 'completed' ? $orderDate->addHours(rand(96, 240)) : null,
                'cancelled_at' => $status === 'cancelled' ? $orderDate->addHours(rand(1, 24)) : null,

                // Notes
                'customer_note' => rand(0, 1) ? fake()->sentence() : null,
                'admin_note' => $status === 'cancelled' ? 'Customer requested cancellation' : null,
                'cancellation_reason' => $status === 'cancelled' ? ['Changed mind', 'Found better price', 'Too expensive'][array_rand([0, 1, 2])] : null,

                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            // Add order items
            $subtotal = 0;
            $itemsCount = rand(1, 5);

            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $unitPrice = $product->price;
                $totalPrice = $quantity * $unitPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'product_image' => $product->featured_image,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'discount_amount' => 0,
                    'tax_amount' => $totalPrice * 0.1, // 10% tax
                    'attributes' => null,
                ]);

                $subtotal += $totalPrice;

                // Update product sales data
                if ($status === 'completed' && $paymentStatus === 'paid') {
                    $product->increment('total_sold', $quantity);
                    $product->increment('total_revenue', $totalPrice);
                    if ($product->track_quantity) {
                        $product->decrement('quantity', $quantity);
                    }
                }
            }

            // Calculate taxes and totals
            $taxAmount = $subtotal * 0.1; // 10% tax
            $totalAmount = $subtotal + $order->shipping_cost + $taxAmount - $order->discount_amount;

            // Update order with calculated amounts
            $order->update([
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
            ]);
        }
    }
}
