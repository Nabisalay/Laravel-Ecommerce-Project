<x-appLayout.header>
    @php
        $total = 0;
    @endphp
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Checkout</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Checkout</li>
        </ol>
    </div>
    <!-- Single Page Header End -->
    @if (session()->has('orderPlaced'))
        <div class="container d-flex justify-content-center align-items-center pt-5">
            <h1 class="text-primary">{{ session('orderPlaced') }}</h1>
        </div>
    @elseif(session()->has('emptyOrder'))
        <div class="container d-flex justify-content-center align-items-center pt-5">
            <h1 class="text-primary">{{ session('emptyOrder') }}</h1>
        </div>
    @else
        <!-- Checkout Page Start -->
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">Billing details</h1>
                <form action="{{ route('place.order') }}" method="POST">
                    @csrf
                    <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-7">
                            {{-- <div class="row">
                            <div class="col-md-12 col-lg-6"> --}}
                            <div class="form-item ">
                                <label class="form-label my-3">Full Name<sup>*</sup></label>
                                <input type="text" name="name" value="{{ $user->name ?? '' }}"
                                    class="form-control" required>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-3">Last Name<sup>*</sup></label>
                                    <input type="text" value="" name="lname"class="form-control" required>
                                </div>
                            </div>
                        </div> --}}

                            <div class="form-item">
                                <label class="form-label my-3">Address <sup>*</sup></label>
                                <input type="text" name="st_address" value="{{ $user->st_address ?? '' }}"
                                    class="form-control" required>
                                @error('st_address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Town/City<sup>*</sup></label>
                                <input type="text" name="city" value="{{ $user->city ?? '' }}"
                                    class="form-control" required>
                                @error('city')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Country<sup>*</sup></label>
                                <input type="text" value="{{ $user->country ?? '' }}" name="country"
                                    class="form-control" required>
                                @error('country')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Postcode/Zip<sup>*</sup></label>
                                <input type="text" value="{{ $user->zip_code ?? '' }}" name="zip_code"
                                    class="form-control" required>
                                @error('zip_code')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Mobile<sup>*</sup></label>
                                <input type="tel" value="{{ $user->number ?? '' }}" name="number"
                                    class="form-control" required>
                                @error('number')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        <div class="col-md-12 col-lg-6 col-xl-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Products</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Warranty</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>

                                    <tbody id="cartTablebody">
                                        @foreach ($productsToOrder as $item)
                                            @php
                                                $total += $item->price * $item->quantity;
                                            @endphp
                                            <tr>
                                                <th scope="row">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/' . $item->prodImg) }}"
                                                            class="img-fluid me-5 " style="width: 80px; height: 80px;"
                                                            alt="image">
                                                    </div>
                                                </th>
                                                <td>
                                                    <p class="mb-0 mt-4">{{ $item->description }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4">{{ $item->price }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4">{{ $item->quantity }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4">{{ $item->warrenty }}</p>
                                                </td>
                                                <td>
                                                    <p class="mb-0 mt-4">{{ $item->price * $item->quantity }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th scope="row">
                                            </th>
                                            <td class="py-5">
                                                <p class="mb-0 text-dark text-uppercase py-3">SubTotal</p>
                                            </td>
                                            <td class="py-5"></td>
                                            <td class="py-5"></td>
                                            <td class="py-5">
                                                <div class="py-3 border-bottom border-top">

                                                    <p id="subTotal" class="mb-0 text-dark">
                                                        $ {{ $total }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <td class="py-5">
                                    <h3 class="mb-0 text-primary py-4">Shipping</h3>
                                </td>
                                <td colspan="3" class="py-5">
                                    <div class="form-check text-start">
                                        <input type="radio" class="form-check-input bg-primary border-0"
                                            id="Shipping-1" name="shipping" data-totalprice="" value="0"
                                            required>
                                        <label class="form-check-label" for="Shipping-1"><b> Standard Shipping:</b>
                                            Takes
                                            4
                                            to 5 business days</label>
                                        <p><b>Charges:</b> $5.0</p>
                                    </div>
                                    <div class="form-check text-start">
                                        <input type="radio" class="form-check-input bg-primary border-0"
                                            id="Shipping-2" name="shipping" value="1" required>
                                        <label class="form-check-label" for="Shipping-2"><b> Premium Shipping:</b>
                                            Takes 1
                                            to 2 business days</label>
                                        <p><b>Charges:</b> $15.0</p>
                                    </div>
                                </td>
                                @error('shipping')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <hr>
                            <div
                                class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0"
                                            id="Transfer-1" name="payment_method" value="Credit Card" required>
                                        <label class="form-check-label" for="Transfer-1">Credit Card Payment</label>
                                    </div>
                                    <p class="text-start text-dark">Make your payment directly into our bank account.
                                        Please use your Order ID as the payment reference. Your order will not be
                                        shipped
                                        until the funds have cleared in our account.</p>
                                </div>
                            </div>
                            <div
                                class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0"
                                            id="Payments-1" name="payment_method" value="Cheque Payment" required>
                                        <label class="form-check-label" for="Payments-1">Cheque Payment</label>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                <div class="col-12">
                                    <div class="form-check text-start my-3">
                                        <input type="radio" class="form-check-input bg-primary border-0"
                                            id="Delivery-1" name="payment_method" value="Cash On Delivery" required>
                                        <label class="form-check-label" for="Delivery-1">Cash On Delivery</label>
                                    </div>
                                </div>
                            </div>
                            @error('payment_method')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <div>
                                <td class="py-5">
                                    <input id="finalAmountinp" type="hidden" name="final_amount">
                                    <h3 class="mb-0 text-dark py-4">Total: <span id="finalAmount"></span> </h3>
                                    @error('final_amount')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </td>
                                <input type="hidden" name="product_id"
                                    value=" {{ $productsToOrder[0]->productId }} ">
                            </div>
                            <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                <button type="submit"
                                    class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Place
                                    Order</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <!-- Checkout Page End -->
</x-appLayout.header>
