<x-layout.admin>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9 table-responsive">
                <div class="">
                    @if (session()->has('trashItem'))
                        <h4 class="text-success">{{ session('trashItem') }}</h4>
                    @endif
                    <form action="{{ route('dashboard.orders.filter') }}" method="POST">
                        @csrf
                        <label for="select">Search by filter</label>
                        <select class="form-select" name="filter_orders" id="searchOrdersByFilter">
                            <option selected disabled value="">search by filter</option>
                            <option value="payment_done">Paid</option>
                            <option value="has_completed">Completed</option>
                            <option value="has_dispatched">Dispatched</option>
                        </select>
                        <button type="submit" class="btn btn-success">Apply</button>
                    </form>
                    <h2 class="mb-0">All Order</h2>

                </div>
                @if (session()->has('dispatchStatus'))
                    <script>
                        alert('{{ session('dispatchStatus') }}')
                    </script>
                @endif
                <table class="table table-warning">
                    <thead class="bg-warning p-2 text-dark bg-opacity-10" style="opacity: 75%;">
                        <tr>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">User</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Payment</th>
                            <th scope="col">Delivery</th>
                            <th scope="col">Date</th>
                            <th scope="col">Dispatched</th>
                            <th scope="col">Completed</th>
                            <th scope="col">Details</th>
                            <th scope="col">cancel</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody class="order-items">
                        @foreach ($orders as $order)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 mt-4">{{ $order->order_id }}</p>
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $order->email }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">$ {{ $order->total }}</p>
                                </td>

                                <td class="text-center">
                                    @if ($order->payment_done)
                                        <div class="mb-0 mt-4">
                                            <img src="{{ asset('storage/images/images.png') }}"
                                                style="width: 30px; height: 30px;" alt="">
                                        </div>
                                    @else
                                        <p class="mb-0 mt-4">{{ $order->payment_method }}</p>
                                    @endif
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ $order->delivery_type ? 'Premium' : 'Standard' }}</p>
                                </td>

                                <td>
                                    <p class="mb-0 mt-4 ">{{ $order->created_at->format('m/d/Y') }}</p>
                                </td>
                                <td class="text-center">
                                    @if ($order->has_dispatched)
                                        <div class="mb-0 mt-4">
                                            <img src="{{ asset('storage/images/images.png') }}"
                                                style="width: 30px; height: 30px;" alt="">
                                        </div>
                                    @else
                                        <form action="{{ route('dashboard.order.dispatch', ['id' => $order->id]) }}"
                                            method="POST">
                                            @csrf
                                            <p class="mb-0 mt-4">
                                                <button type="submit" class="btn btn-primary">Dispatch</button>
                                            </p>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 ">
                                        {{ $order->has_completed ? 'Yes' : 'Not yet' }}
                                    </p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total-price">
                                        <a href="{{ route('dashboard.order.details', ['id' => $order->id]) }}"
                                            class="btn btn-primary">View</a>
                                    </p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total-price">
                                    <form action="{{ route('dashboard.order.cancel', ['id' => $order->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ $order->payment_done || $order->has_dispatched ? 'This order has been processed. Are you sure you want to cancel it?  Dont worry, you can restore it from the trash.' : 'Are you sure you want to cancel the order' }}')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger">Cancel</button>
                                    </form>
                                    </p>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                {{ $orders->links() }}


            </div>

        </div>

    </div>
</x-layout.admin>
