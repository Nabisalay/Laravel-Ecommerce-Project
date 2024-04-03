<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Climate\Order;

class AdminOrderManageController extends Controller
{
    //
    public function showOrders(): View
    {
        $orders = OrderModel::orderBy('id', 'desc')
            ->where('has_cancle', false)->paginate(10);
        return view('admin.orders', ['orders' => $orders]);
    }

    public function showTrashOrders(): View
    {
        $orders = OrderModel::orderBy('id', 'desc')
            ->where('has_cancle', true)->paginate(10);
        return view('admin.trash', ['orders' => $orders]);
    }

    public function ordersFilter(Request $request): View
    {
        $request->validate([
            'filter_orders' => ['required', 'string', 'max:255',],
        ]);
        $filter = $request->input('filter_orders');
        // dd($filter);
        $orders = OrderModel::where($filter, true)->paginate(10);
        return view('admin.orders', ['orders' => $orders]);
    }

    public function orderDispatch($id): RedirectResponse
    {

        $order = OrderModel::find($id);
        if ($order->payment_method !== 'Cash On Delivery') {
            if ($order->payment_done) {
                $order->increment('has_dispatched');
            } else {
                session()->flash('dispatchStatus', 'Payment has not been paid yet');
                return redirect()->back();
            }
        } else {
            $order->increment('has_dispatched');
        }
        session()->flash('dispatchStatus', 'Order has been dispatched successfully');
        return redirect()->back();
    }

    public function orderDetails($id): View
    {
        $orderId = OrderModel::where('id', $id)->value('order_number');
        $orderDetail = DB::table('order_details as o')
        ->select('o.*', 'p.description', 'p.warrenty', 'p.prodImg')
        ->join('products as p', 'o.product_id', '=', 'p.prodId')
        ->where('o.order_number', $orderId)
        ->get();
        return view('admin.orderdetails', ['orderDetail' => $orderDetail]);
    }

    public function trashOrder($id)
    {
        OrderModel::find($id)->increment('has_cancle');
        session()->flash('trashItem', 'Order has been successfully cancel. You can always restore it from the trash');
        return redirect()->back();
    }

    public function restoreOrder($id)
    {
        OrderModel::find($id)->decrement('has_cancle');
        session()->flash('restoreItem', 'Order has been successfully Restore.');
        return redirect()->back();
    }
}
