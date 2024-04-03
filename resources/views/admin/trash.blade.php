<x-layout.admin>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9 table-responsive">
                @if (session()->has('restoreItem'))
                    <h4 class="text-success">{{ session('restoreItem') }}</h4>
                @endif
                <h2 class="mb-0">Trash Orders</h2>
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
                            <th scope="col">Restore</th>
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
                                        <p class="mb-0 mt-4 ">Not yet</p>
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
                                    <form action="{{ route('dashboard.order.restore', ['id' => $order->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to restore the order')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success">Restore</button>
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
