<x-layout.admin>
    <div class="container">
        <form class="user" action="{{ route('update.product', ['id' => $item->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3>Add Product</h3>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="hidden" value="{{ $item->prodCode }}" name="product_code">
                    <label for="">Category</label>
                    <select class="form-control " aria-label="Default select example" name="category" required>
                        <option selected value="{{ $item->cid }}">{{ $item->cname }}</option>
                        @foreach ($categories as $category)
                            @if ($category->cname !== $item->cname)
                                <option value="{{ $category->cid }}">{{ $category->cname }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="">Product Description</label>
                    <input type="text" class="form-control " id="" value="{{ $item->description }}"
                        placeholder="Enter Product Description" name="description" required>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Price</label>
                    <input type="text" class="form-control " value="{{ $item->price }}" id=""
                        placeholder="Enter Product Price" name="price" required>
                    @error('price')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="">Product Warranty</label>
                    <input type="text" class="form-control " value="{{ $item->warrenty }}" id=""
                        placeholder="Enter Product Warranty" name="warranty" required>
                    @error('warranty')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Warranty Duration</label>
                    <select class="form-control " aria-label="Default select example" name="Warranty_type" required>
                        <option selected disabled value="">{{ $item->warrenty }}</option>
                        <option value="Day">Day</option>
                        <option value="Month">Month</option>
                        <option value="Year">Year</option>
                    </select>
                    @error('Warranty_type')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="">Product Image</label>
                    <input type="file" class="" id="" name="image" required>
                    @error('image')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="">Current Image</label>
                    <img src="{{ asset('storage/' . $item->prodImg) }}" alt="">
                </div>
            </div>
            <input type="submit" value="Add Product" class="btn btn-primary btn-user btn-block" name="addProduct">

        </form>
    </div>
</x-layout.admin>
