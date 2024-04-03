<?php

namespace App\Http\Controllers;

use App\Models\AddToCartModel;
use App\Models\OrderDetailModel;
use App\Models\OrderIdModel;
use App\Models\OrderModel;
use App\Models\UserDetailModel;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Redis;

class HandleUserOrderController extends Controller
{
    //
    public function addToCart(Request $request)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            // Flash message for login requirement
            session()->flash('loginRequiredFirst', 'Please Login First');
            return redirect()->route('login');
        }

        // Validation rules for the product_id
        $request->validate([
            'product_id' => 'required',
        ]);

        // Extracting product_id and user's email
        $productId = $request->product_id;
        $email = Auth::user()->email;

        // Determining the destination based on the previous URL
        $url = url()->previous();
        $destiny = Str::contains($url, 'shop') ? 'shop' : 'home';

        // Check if the product already exists in the cart
        if (AddToCartModel::where('email', $email)->where('productId', $productId)->exists()) {
            // Flash message for existing product in the cart
            session()->flash('productExists', 'Product already exists in the cart. Please check your cart.');
            return redirect()->route($destiny);
        }

        // Create a new entry in the cart
        AddToCartModel::create([
            'email' => $email,
            'productId' => $productId,
            'quantity' => 1,
        ]);

        // Flash message for successful addition to cart
        session()->flash('AddedToCart', 'Product has been successfully added to the cart.');

        // Redirect to the appropriate destination
        return redirect()->route($destiny);
    }

    public function showCartProducts()
    {
        // Get the user's email
        $email = Auth::user()->email;

        // Retrieve cart products from the database
        $cartProducts = DB::table('user_cart as c')
            ->select('c.id', 'c.quantity', 'p.description', 'p.price', 'p.warrenty', 'p.prodImg')
            ->join('products as p', 'c.productId', '=', 'p.prodId')
            ->where('c.email', $email)
            ->where('c.isActive', 1)
            ->get();

        // Check if cart has products
        if ($cartProducts->count() > 0) {
            // Render the 'mycart' view with cartProducts data
            return view('mycart', ['cartProducts' => $cartProducts]);
        } else {
            // If cart is empty, redirect to the shop with a flash message
            session()->flash('emptyCart', 'Your Cart is empty please first add products in it');
            return redirect()->route('shop');
        }
    }


    public function updateProductQuantity(Request $request)
    {
        // Validate the form data
        $request->validate([
            'action' => ['required', 'string'],
            'id' => ['required'],
        ]);

        // Get the user's email
        $email = Auth::user()->email;

        // Check weather to decrease or increase the quanity  
        if ($request->action !== 'minus') {
            DB::table('user_cart')
                ->where('id', $request->id)
                ->where('email', $email)
                ->increment('quantity');
        } else {
            DB::table('user_cart')
                ->where('id', $request->id)
                ->where('email', $email)
                ->where('quantity', '>', 0)
                ->decrement('quantity');
        }

        // Return a success response 
        return response()->json(['success' => true]);
    }


    public function deleteCartItem($id)
    {
        // Find the item and delete it
        AddToCartModel::find($id)->delete();

        // go back to the page
        return redirect()->back();
    }

    public function viewCheckOut(): View
    {
        // Get the user's email
        $email = Auth::user()->email;

        // Retrieve user details based on email
        $userDetail = UserDetailModel::where('email', $email)->first();

        // Retrieve all the product in cart
        $productsToOrder = DB::table('user_cart as c')
            ->select('c.id', 'c.productId', 'c.quantity', 'p.description', 'p.price', 'p.warrenty', 'p.prodImg')
            ->join('products as p', 'c.productId', '=', 'p.prodId')
            ->where('c.email', $email)
            ->where('c.isActive', 1)
            ->where('c.quantity', '>', 0)
            ->get();

        // Check if there are products in the cart
        if ($productsToOrder->count() > 0) {
            // Render the 'checkout' view with user details and products to order
            return view('checkout', [
                'user' => $userDetail,
                'productsToOrder' => $productsToOrder
            ]);
        } else {
            // If no products to order, redirect to 'mycart' with a flash message
            session()->flash('emptyOrder', 'First add products to cart to place an order');
            return view('checkout');
        }
    }


    public function placeOrder(Request $request)
    {
        // Validate form data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'st_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:5'],
            'number' => ['required', 'string', 'max:11'],
            'shipping' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'max:255'],
            'final_amount' => ['required', 'string', 'max:255'],
            'product_id' => ['required', 'string', 'max:255'],
        ]);

        // Get authenticate user's email
        $email = Auth::user()->email;

        // Check if user's details is already available or not
        $userDetail = UserDetailModel::updateOrCreate(
            ['email' => $email], // Conditions to match existing user by email
            [ // Data to insert or update
                'name' => $request->name,
                'email' => $email,
                'st_address' => $request->st_address,
                'city' => $request->city,
                'country' => $request->country,
                'zip_code' => $request->zip_code,
                'number' => $request->number,
            ]
        );

        // Get current max id 
        $preId = OrderIdModel::max('order_id');
        // Generate the new id 
        $orderId = str_pad($preId + 1, 8, '0', STR_PAD_LEFT);

        OrderIdModel::create([
            'order_id' => $orderId,
        ]);
        // Generate the order number
        $orderNumber = $request->shipping . $orderId . $request->product_id;

        // Store order info in the database 
        OrderModel::create([
            'order_id' => $orderId,
            'email' => $email,
            'payment_method' => $request->payment_method,
            'order_number' => $orderNumber,
            'total' => $request->final_amount,
            'delivery_type' => $request->shipping,
        ]);


        // Get all the products that user has ordered 
        $cartProducts = DB::table('user_cart as c')
            ->select('c.productId', 'c.quantity', 'p.price')
            ->join('products as p', 'c.productId', '=', 'p.prodId')
            ->where('c.email', $email)
            ->where('c.isActive', 1)
            ->get();

        // Create a array for bulk insert     
        $orderedProducts = [];
        // generate a time step
        $timestamp = Carbon::now();

        // Store the order details in the array
        foreach ($cartProducts as $item) {
            $data = (array)[
                'order_number' => $orderNumber,
                'product_id' => $item->productId,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->quantity * $item->price,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
            // push each indiviual order item in the array
            $orderedProducts[] = $data;
        }

        // make a bulk insert of all ordered item
        OrderDetailModel::insert($orderedProducts);

        // delete the product from the cart that has been ordereds
        AddToCartModel::where('email', $email)->delete();

        // Generate a success message to show 
        session()->flash('orderPlaced', '“ Thanks for shopping with us ”');

        // Redirect user back to the application 
        return redirect()->back();
    }

    public function myOrder(): View
    {
        $email = Auth::user()->email;
        $orderItems = DB::table('orders as o')
            ->select('o.*', 'p.prodImg')
            ->where('email', $email)
            ->join('products as p', DB::raw('RIGHT(o.order_number, 7)'), '=', "p.prodId")
            ->orderByDesc('o.id')
            ->get();
        if ($orderItems->isEmpty()) {
            session()->flash('noProducts', 'You haven\'t order anything yet frist make a order');
        }
        return view('myorder', ['orderItems' => $orderItems]);
    }

    public function orderDetails($id)
    {
        $orderId = OrderModel::where('id', $id)->value('order_number');
        $orderDetail = DB::table('order_details as o')
            ->select('o.*', 'p.description', 'p.warrenty', 'p.prodImg')
            ->join('products as p', 'o.product_id', '=', 'p.prodId')
            ->where('o.order_number', $orderId)
            ->get();
        // dd($orderDetail);
        return view('orderdetails', ['orderDetail' => $orderDetail]);
    }

    public function cancelSingleOrderItem(Request $request)
    {
        $request->validate([
            'id' => ['required', 'integer'],
        ]);
        $item = OrderDetailModel::find($request->id);
        $order_number = $item->order_number;
        $itemPrice = $item->total;
        $paymentDone = OrderModel::where('order_number', $order_number)->value('payment_done');
        $deliveryDone = OrderModel::where('order_number', $order_number)->value('has_dispatched');
        $count = OrderDetailModel::where('order_number', $order_number)->count();
        if ($paymentDone || $deliveryDone) {
            session()->flash('cancellationFailed', 'We\'re sorry, but you can\'t cancel the order once it\'s processed. Please contact the admin for further information.');
            return redirect()->back();
        } elseif ($item->delete()) {
            if ($count <= 1) {
                OrderModel::where('order_number', $order_number)
                    ->delete();
                return redirect()->route('myorder');
            } else {
                OrderModel::where('order_number', $order_number)
                    ->decrement('total', $itemPrice);
            }
            return redirect()->back();
        }
    }

    public function orderEdit($id)
    {
        $order = OrderModel::where('id', $id);
        $orderId = $order->value('order_number');
        $deliveryType = $order->value('delivery_type');
        $paymentStatus = $order->value('payment_done');
        $deliveryStatus = $order->value('has_dispatched');
        $orderDetail = DB::table('order_details as o')
            ->select('o.*', 'p.description', 'p.warrenty', 'p.prodImg')
            ->join('products as p', 'o.product_id', '=', 'p.prodId')
            ->where('o.order_number', $orderId)
            ->get();
        // dd($orderDetail);
        return view('orderedit', [
            'orderDetail' => $orderDetail,
            'deliveryType' => $deliveryType,
            'paymentStatus' => $paymentStatus,
            'deliveryStatus' => $deliveryStatus,
        ]);
    }

    public function updateOrderQuantity(Request $request)
    {
        // Validate the form data
        $request->validate([
            'action' => ['required', 'string'],
            'id' => ['required'],
        ]);

        // Get the user's email
        $email = Auth::user()->email;
        $orderItem = DB::table('order_details')->where('id', $request->id);

        $price = $orderItem
            ->value('price');
        // Check weather to decrease or increase the quanity 

        if ($request->action !== 'minus') {
            $orderItem->increment('quantity');
            $orderItem->increment('total', $price);
            OrderModel::where('order_number', $orderItem->value('order_number'))
                ->increment('total', $price);
        } else {
            $orderItem->decrement('quantity');
            $orderItem->decrement('total', $price);
            OrderModel::where('order_number', $orderItem->value('order_number'))
                ->decrement('total', $price);
        }

        // Return a success response 
        return response()->json(['success' => true]);
    }

    public function updateShipping($id)
    {
        $orderId = OrderDetailModel::where('id', $id)->value('order_number');
        // $orderId = $orderDetail->order_number;
        // dd($orderId);
        $order = OrderModel::where('order_number', $orderId);
        // dd($order->value('payment_done'));   
        if ($order->value('payment_done') || $order->value('has_dispatched')) {
            session()->flash('shippingChanged', 'We\'re sorry, but you can\'t change the shipping once it\'s processed. Please contact the admin for further information.');
            return redirect()->back();
        } elseif ($order->value('delivery_type')) {
            $order->decrement('delivery_type');
            $order->decrement('total', 10);
            session()->flash('shippingChanged', 'Your shipping has been change to standard successfully');
        } else {
            $order->increment('delivery_type');
            $order->increment('total', 10);
            session()->flash('shippingChanged', 'Your shipping has been change to Premium successfully');
        }
        return redirect()->back();
    }

    public function deleteOrder($id)
    {
        $order = OrderModel::find($id);
        $orderId = $order->order_number;
        if ($order->payment_done || $order->has_dispatched) {
            session()->flash('orderDeleted', 'We\'re sorry, but you can\'t cancel the order once it\'s processed. Please contact the admin for further information.');
        } else {
            OrderDetailModel::where('order_number', $orderId)->delete();
            $order->delete();
            session()->flash('orderDeleted', 'Your order has been successfully cancle');
        }
        // dd($orderId);
        return redirect()->back();
    }
}
