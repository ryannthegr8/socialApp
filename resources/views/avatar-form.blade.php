<x-layout>
    <div class="container container--narrow py-md-5">
        <h2 class="text-center mb-3">Upload a new avatar</h2>
        <form action="/manage-avatar" method="POST" enctype="multipart/form-data"{{--Without enctype, laravel will not see that you have attached a file--}}>
            @csrf
            <div class="mb-3">
                <input type="file" name="avatar" required{{--required = client side validation--}}>
                {{-- server side validation --}}
                @error('avatar')
                    <p class="alert small alert-danger shadow-sm">{{$message}}</p>
                @enderror
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</x-layout>
