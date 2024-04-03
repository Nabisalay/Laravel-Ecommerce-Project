<x-layout.admin>
    @php
        $i = 1;
    @endphp
    <!-- Cart Page Start -->
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9 table-responsive">
                <div class="d-flex">
                    <a href="{{ route('orders') }}" class="btn btn-success"> <b>←</b> Go back</a>
                </div>
                    <h2 class="mb-0">Order Details</h2>

                {{-- @if (session()->has('cancellationFailed'))
                    <div class="container d-flex justify-content-center align-items-center pt-5">
                        <h1 class="text-primary">{{ session('cancellationFailed') }}</h1>
                    </div>
                @endif
                <div class="d-flex">
                    <a href="{{ route('myorder') }}" class="btn btn-success"> <b>←</b> Go back</a>
                </div> --}}
                <table class="table table-warning">
                    <thead class="bg-warning p-2 text-dark bg-opacity-10" style="opacity: 75%;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Warranty</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Cancel</th>
                        </tr>
                    </thead>
                    <tbody id="orderedProducts">
                        @foreach ($orderDetail as $item)
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <p class="">{{ $i++ }}</p>
                                    </div>
                                </th>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->prodImg) }}" class="img-fluid me-5 "
                                            style="width: 80px; height: 80px;" alt="order product img">
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
                                    <p class="mb-0 mt-4">{{ $item->quantity }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 ">$ {{ $item->total }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total-price">
                                    <form action="{{ route('order.cancel.singleitem') }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to cancel this product from your order? It will not be restorable')">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        @error('id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <button type="submit" class="btn btn-danger">Cancel</button>
                                    </form>
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <p class="mb-0  total-price">
                        <a href="{{ route('order.edit', ['id' => request()->route('id')]) }}"
                            class="btn btn-success text-white">Edit</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->


</x-layout.admin>
