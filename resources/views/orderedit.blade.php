<x-appLayout.header>
    @php
        $total = 0;
    @endphp
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Edit Order</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Edit Order</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <div class="d-flex">
                    <a href="{{ route('order.details', ['id' => request()->route('id')]) }}" class="btn btn-success">
                        <b>←</b> Go back</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Warranty</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody id="cartTablebody">
                        @foreach ($orderDetail as $item)
                            @php
                                $total += $item->price * $item->quantity;
                            @endphp
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->prodImg) }}" class="img-fluid me-5 "
                                            style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->description }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">$ {{ $item->price }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">{{ $item->warrenty }}</p>
                                </td>
                                <td>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button
                                                class="btn btn-sm btn-minus rounded-circle bg-light border update-order-quantity"
                                                data-id="{{ $item->id }}" data-price="{{ $item->price }}"
                                                data-action="minus" {{ $item->quantity <= 1 || $paymentStatus || $deliveryStatus ? 'disabled' : '' }}>
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input id="" type="text" readonly
                                            class="form-control form-control-sm text-center border-0 cart-quantity"
                                            value="{{ $item->quantity }}">
                                        <div class="input-group-btn">
                                            <button
                                                class="btn btn-sm btn-plus rounded-circle bg-light border update-order-quantity"
                                                data-id="{{ $item->id }}" data-price="{{ $item->price }}"
                                                data-action="plus" {{ $paymentStatus || $deliveryStatus ? 'disabled' : '' }}>
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total-price">
                                        $ {{ $item->price * $item->quantity }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (session()->has('shippingChanged'))
                <h1>{{ session('shippingChanged') }}</h1>
            @endif
            <div class="d-flex justify-content-end">
                <p class="mb-0  total-price">
                <form action="{{ route('order.edit.shipping', ['id' => $orderDetail[0]->id]) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to change shipping to {{ $deliveryType < 1 ? 'Premium' : 'Standard' }}?')">
                    @csrf
                    <button type="submit" class="btn btn-success text-white change-shipping">Change Shipping</button>
                </form>
                </p>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

</x-appLayout.header>
