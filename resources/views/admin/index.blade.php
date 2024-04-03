<x-layout.admin>
    <div class="container">
        @if (session()->has('userfound'))
            {{ session()->forget('userfound') }}
            <table class="table table-warning">
                <thead class="bg-warning p-2 text-dark bg-opacity-10" style="opacity: 75%;">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Verified</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->email_verified_at }}</td>
                            <td><a href="{{ route('update.user', ['id' => $user->id]) }}"
                                    class="btn btn-success">Update</a></td>
                            <td><a href="" class="btn btn-danger">Delete</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @elseif(session()->has('productfound'))
            {{ session()->forget('productfound') }}
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
        @elseif(session()->has('categoryfound'))
            {{ session()->forget('categoryfound') }}
            <table class="table table-warning">
                <thead class="bg-warning p-2 text-dark bg-opacity-10" style="opacity: 75%;">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Number of Products</th>
                        <th scope="col">Status</th>
                        <th scope="col">Change Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->cid }}</th>
                            <td>{{ $category->cname }}</td>
                            <td>{{ $category->product_count }} </td>
                            <td>{{ $category->is_active ? 'Active' : 'Deactive' }} </td>
                            <td>
                                <form
                                    action="{{ route('update.category', ['id' => $category->cid, 'status' => $category->is_active ? 0 : 1]) }}"
                                    method="POST"
                                    @if ($category->is_active) onsubmit="return confirm('If you deactivate the category, it will also deactivate all the products associated with it')" @endif>
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="btn {{ $category->is_active ? 'btn-danger' : 'btn-primary' }}">{{ $category->is_active ? 'Deactivate' : 'Activate' }}</a>
                            </td>
                            </form>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        @elseif(session()->has('noRecordFound'))
            <h3>{{ session('noRecordFound') }}</h3>
            {{ session()->forget('noRecordFound') }}
        @endif
    </div>
</x-layout.admin>
