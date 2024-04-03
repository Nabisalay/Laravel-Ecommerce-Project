<x-layout.admin>
    <div class="container">


        <form class="user" action="{{ route('update.user', ['id' => $user['id']]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="text" name="name" value="{{ $user['name'] }}" class="form-control form-control-user"
                    id="exampleFirstName" placeholder="First Name">
                @error('name')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">
                Update
            </button>

        </form>

    </div>
</x-layout.admin>
