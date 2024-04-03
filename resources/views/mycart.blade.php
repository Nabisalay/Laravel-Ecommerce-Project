<x-appLayout.header>
    @php
        $total = 0;
    @endphp
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Cart</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Warranty</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody id="cartTablebody">
                        @foreach ($cartProducts as $item)
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
                                                class="btn btn-sm btn-minus rounded-circle bg-light border update-quantity"
                                                data-id="{{ $item->id }}" data-price="{{ $item->price }}"
                                                data-action="minus" {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input id="" type="text" readonly
                                            class="form-control form-control-sm text-center border-0 cart-quantity"
                                            value="{{ $item->quantity }}">
                                        <div class="input-group-btn">
                                            <button
                                                class="btn btn-sm btn-plus rounded-circle bg-light border update-quantity"
                                                data-id="{{ $item->id }}" data-price="{{ $item->price }}"
                                                data-action="plus">
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
                                <td>
                                    <form action="{{ route('delete.cart.item', ['id' => $item->id]) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md rounded-circle bg-light border mt-4">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                            <h5 class="mb-0 ps-4 me-4">Total</h5>
                            <p id="total-Price" class="mb-0 pe-4">$ {{ $total }}</p>
                        </div>

                        <a href="{{ route('placeOrder') }}"
                            class="btn border-secondary rounded-pill px-4 py-3
                            text-primary text-uppercase mb-4 ms-4">
                            Place Order
                        </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

</x-appLayout.header>
