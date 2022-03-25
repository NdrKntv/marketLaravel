<x-layout>
    <div class="w-50 m-auto px-5">
        <form method="POST" action="/create-account">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email"
                       name="email" placeholder="Your email" value="{{old('email')}}" required>
                @error('email')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password"
                       name="password" placeholder="Minimum 6" required>
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username"
                       name="name" placeholder="User name must be unique" value="{{old('name')}}" required>
                @error('name')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="shopCheck"
                name="shopCheck">
                <label class="form-check-label" for="shopCheck">Register as a store</label>
            </div>
            <button type="submit" class="btn btn-primary">Create account</button>
        </form>
    </div>
</x-layout>
