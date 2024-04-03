<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Stripe;

class StripePaymentController extends Controller
{
    //Get all the product and prices
    public function checkOut($id)
    {
        $order = OrderModel::find($id);
        $orderId = $order->order_number;
        $email = $order->email;
        // Get the ordered products 
        $products = DB::table('order_details as o')
            ->select('o.*', 'p.description')
            ->join('products as p', 'o.product_id', '=', 'p.prodId')
            ->where('o.order_number', $orderId)
            ->get();
        // Prepare shipping cost     
        $shipingCost = $order->delivery_type > 0 ? 15 : 5;
        $shipingType = $order->delivery_type > 0 ? 'Premium' : 'Standard';
        $shippingLineItem = [
            'price_data' => [
                'product_data' => [
                    'name' => 'Shipping Type: ' . $shipingType,
                ],
                'unit_amount' => 100 * $shipingCost,
                'currency' => 'USD',
            ],
            'quantity' => 1,
        ];
        // Store all the ordered products in an array 
        $lineItems = [];
        foreach ($products as $item) {
            $lineItems[] = [
                'price_data' => [
                    'product_data' => [
                        'name' => $item->description,
                    ],
                    'unit_amount' => 100 * $item->price,
                    'currency' => 'USD',
                ],
                'quantity' => $item->quantity,
            ];
        }
        // Merge the shipping array
        array_push($lineItems, $shippingLineItem);

        // Prepare a new stripe object 
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        // Route to redirect on the success response
        $redirectUrl = route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}';

        // prepare a response 
        $response = $stripe->checkout->sessions->create([
            'success_url' => $redirectUrl,
            'customer_email' => $email,
            'payment_method_types' => ['link', 'card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'allow_promotion_codes' => true,
            'metadata' => [
                'order_id' => $orderId,
            ],
        ]);

        return redirect($response['url']);
    }

    public function stripeCheckOutSuccess(Request $request)
    {
        // Create a stripe object
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        // Retrieve response from stripe
        $response = $stripe->checkout->sessions->retrieve($request->session_id);

        // Get the order id 
        $orderId = $response->metadata->order_id;
        // Update Payment Status 
        if ($response->payment_status === 'paid') {
            OrderModel::where('order_number', $orderId)->increment('payment_done');
        }
        // Redirect user to the application with the success message 
        return redirect()->route('myorder')
            ->with('success', 'Payment Has Been Made Successfully');
    }
}
