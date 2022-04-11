<x-Layout>
    <div class="w-50 m-auto px-5">
        <form method="POST" action="/login">
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
                       name="password" placeholder="Your password" required>
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <input type="hidden" name="redirectLink" value="{{$_SERVER['HTTP_REFERER']??''}}">
            <button type="submit" class="btn btn-primary">Log in</button>
        </form>
    </div>
</x-Layout>
