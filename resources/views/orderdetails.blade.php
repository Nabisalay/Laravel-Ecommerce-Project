<x-appLayout.header>
    @php
        $i = 1;
    @endphp
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Ordered</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Pages</a></li>
            <li class="breadcrumb-item active text-white">Ordered</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">

                @if (session()->has('cancellationFailed'))
                <div class="container d-flex justify-content-center align-items-center pt-5">
                    <h1 class="text-primary">{{ session('cancellationFailed') }}</h1>
                </div>
                @endif
                <div class="d-flex">
                    <a href="{{ route('myorder') }}" class="btn btn-success"> <b>←</b> Go back</a>
                </div>
                <table class="table">
                    <thead>
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


</x-appLayout.header>
