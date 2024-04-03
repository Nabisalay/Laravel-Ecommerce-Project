<x-layout.admin>
    <div class="container">


        <form class="user" action="{{ route('add.category') }}" method="POST">
            @csrf
            <h3>Add Category</h3>
            @if (session()->has('categoryAdded'))
                <p class="text-success">{{ session('categoryAdded') }} </p>
            @endif
            <div class="form-group row">
                <div class="col-sm-9 mb-3 mb-sm-0">
                    <input type="text" name="category_name" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Category Name">
                    @error('category_name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Add Category
                    </button>
                </div>
            </div>
        </form>
        <hr class="font-weight-bold">
        <form class="user" action="{{ route('add.product') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3>Add Product</h3>
            @if (session()->has('productAdded'))
                <p class="text-success">{{ session('productAdded') }} </p>
            @endif
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Category</label>
                    <select class="form-control " aria-label="Default select example" name="category" required>
                        <option selected disabled value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->cid }}">{{ $category->cname }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="">Product Description</label>
                    <input type="text" class="form-control " id="" placeholder="Enter Product Description"
                        name="description" required>
                    @error('description')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Price</label>
                    <input type="text" class="form-control " id="" placeholder="Enter Product Price"
                        name="price" required>
                    @error('price')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <label for="">Product Warranty</label>
                    <input type="text" class="form-control " id="" placeholder="Enter Product Warranty"
                        name="warranty" required>
                    @error('warranty')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="">Warranty Duration</label>
                    <select class="form-control " aria-label="Default select example" name="Warranty_type" required>
                        <option selected disabled value="">Select Time Period</option>
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
            </div>
            <input type="submit" value="Add Product" class="btn btn-primary btn-user btn-block" name="addProduct">

        </form>

    </div>
</x-layout.admin>
