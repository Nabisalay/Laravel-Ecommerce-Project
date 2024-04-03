<x-appLayout.header>
    @if (session()->has('emptyCart'))
        <script>
            alert("{{ session('emptyCart') }}")
        </script>
    @endif
    @if (session()->has('productExists'))
        <script>
            alert("{{ session('productExists') }}")
        </script>
    @endif
    @if (session()->has('AddedToCart'))
        <script>
            alert("{{ session('AddedToCart') }}")
        </script>
    @endif
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>

    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">Arts The Stationary Shop</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            @error('search_query')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <form action="{{ route('shop.search') }}" method="POST">
                                <div class="input-group w-100 mx-auto d-flex">
                                    @csrf
                                    <input type="search" name="search_query" id="searchInput" class="form-control p-3"
                                        placeholder="keywords" aria-describedby="search-icon-1">
                                    <button type="submit" class="input-group-text p-3">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-6 check-div"></div>
                        <!-- Category Dropdown -->

                        <div class="col-xl-3">
                            <form action="{{ route('shop.search.bycategory') }}" method="POST">
                                @csrf
                                <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                    <label for="fruits">Select Category:</label>
                                    <div>
                                        <select id="category" name="search_by_category"
                                            class="border-0 form-select-sm bg-light me-3">
                                            <option selected value="All">All</option>
                                            @isset($categories)
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->cid }}">{{ $category->cname }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                        <button type="submit" class="btn btn-primary">fetch</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="container pb-5 text-center">
                        <h1 class="text-primary">Our Products</h1>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div id="product-conductor" class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        @if (session()->has('noRecordFound'))
                                            <h2>{{ session('noRecordFound') }}</h2>
                                            {{ session()->forget('noRecordFound') }}
                                        @else
                                            @foreach ($products as $product)
                                                <div class="col-md-6 col-lg-4 col-xl-3">
                                                    <div class="rounded position-relative fruite-item">
                                                        <div class="fruite-img" style="height: 250px; ">
                                                            <img src="{{ asset('storage/' . $product->prodImg) }}"
                                                                class="img-fluid w-100 rounded-top" alt="">
                                                        </div>
                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                            style="top: 10px; left: 10px;">Stationary</div>
                                                        <div
                                                            class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                            <h4>{{ $product->description }}</h4>
                                                            <p><b>Warrenty:{{ $product->warrenty }}</b></p>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark fs-5 fw-bold mb-0"><b>Price:</b>
                                                                    ${{ $product->price }}</p>
                                                                <form action="{{ route('shop.addtocart') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden"
                                                                        value="{{ $product->prodId }}"
                                                                        name="product_id">
                                                                    <button type="submit"
                                                                        class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart"
                                                                        data-prodid="">
                                                                        <i
                                                                            class="fa fa-shopping-bag me-2 text-primary"></i>
                                                                        Add to cart
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
</x-appLayout.header>
