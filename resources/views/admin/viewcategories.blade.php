<x-layout.admin>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">
                <h2>All Products </h2>
                @if (session()->has('categoryUpdated'))
                    <p class="text-success">{{ session('categoryUpdated') }}</p>
                @endif
                <hr>
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

                {{ $categories->links() }}
                {{-- <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav> --}}

            </div>

        </div>

    </div>
</x-layout.admin>
