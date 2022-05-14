<x-layout>
    <div class="w-50 m-auto px-5">
        <form action="/forgot-password" method="POST">
            @csrf
            <div class="w-75">
                <label for="email" class="form-label">Your email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" required>
                @error('email')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3">Send reset password link</button>
        </form>
    </div>
</x-layout>
