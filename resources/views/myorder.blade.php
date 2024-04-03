<x-appLayout.header>

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Ordered</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Ordered</li>
        </ol>
    </div>
    @if (session()->has('success'))
        <div class="container d-flex justify-content-center align-items-center pt-5">
            <h1 class="text-primary">{{ session('success') }}</h1>
        </div>
    @endif
    <!-- Single Page Header End -->
    @if (session()->has('orderDeleted'))
        <div class="container d-flex justify-content-center align-items-center pt-5">
            <h1 class="text-primary">{{ session('orderDeleted') }}</h1>
        </div>
        @endif
    @if (session()->has('noProducts'))
        <div class="container d-flex justify-content-center align-items-center pt-5">
            <h1 class="text-primary">{{ session('noProducts') }}</h1>
        </div>
    @else
        <!-- Cart Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Product</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Delivery</th>
                                <th scope="col">Dispatched</th>
                                <th scope="col">Date</th>
                                <th scope="col">Cancel</th>
                                <th scope="col">Details</th>
                                <th scope="col">Completed</th>
                            </tr>
                        </thead>
                        <tbody id="orderedProducts">
                            @foreach ($orderItems as $item)
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <p class="">{{ $item->order_id }}</p>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $item->prodImg) }}" class="img-fluid me-5 "
                                                style="width: 80px; height: 80px;" alt="order product img">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 mt-4">$ {{ $item->total }}</p>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->payment_done)
                                            <div class="mb-0 mt-4">
                                                <img src="{{ asset('storage/images/images.png') }}"
                                                    style="width: 40px; height: 40px;" alt="">
                                            </div>
                                        @else
                                            <p class="mb-0 mt-4">{{ $item->payment_method }}</p>
                                            @if (!$item->payment_done && $item->payment_method !== 'Cash On Delivery')
                                                <div>
                                                    <form action="{{ route('payment', ['id' => $item->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn btn-primary text-white">pay</button>
                                                    </form>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">{{ $item->delivery_type ? 'Premium' : 'Standard' }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">{{ $item->has_dispatched ? 'Yes' : 'Not yet' }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 ">{{ $item->created_at }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 total-price">
                                        <form action="{{ route('order.delete', ['id' => $item->id]) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel this order? It will not be restorable')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Cancel</button>
                                        </form>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 total-price">
                                            <a href="{{ route('order.details', ['id' => $item->id]) }}"
                                                class="btn btn-primary">View</a>
                                        </p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 ">
                                            {{ $item->has_completed ? 'Yes' : 'Not yet' }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Cart Page End -->

    @endif
</x-appLayout.header>
