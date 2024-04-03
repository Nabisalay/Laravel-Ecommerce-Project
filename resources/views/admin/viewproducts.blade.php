<x-layout.admin>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">
                <h2>All Products </h2>
                @if (session()->has('productUpdated'))
                    <p class="text-success">{{ session('productUpdated') }} </p>
                @endif
                @if (session()->has('productDeleted'))
                    <p class="text-success">{{ session('productDeleted') }} </p>
                @endif
                <table class="table table-warning">
                    <thead class="bg-warning p-2 text-dark bg-opacity-10" style="opacity: 75%;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Warranty</th>
                            <th scope="col">Image</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->warrenty }}</td>
                                <td><img src="{{ asset('storage/' . $product->prodImg) }}" alt="Product Image"
                                        height='70px' width='70px'></td>
                                <td><a href="{{ route('update.product', ['id' => $product->id]) }}"
                                        class="btn btn-primary">Edit</a></td>
                                <td>
                                    <form action="{{ route('delete.product', ['id' => $product->id]) }}" method="POST"
                                        onsubmit="confirm('are you sure you want to delete the user')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Delete</button>
                                </td>
                                </form>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                {{ $products->links() }}


            </div>

        </div>

    </div>
</x-layout.admin>
