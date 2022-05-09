<x-Layout>
    <div class="w-50 m-auto px-5">
        <form action="/reset-password" method="POST">
            @csrf
            <div class="w-75 mt-3">
                <label for="password" class="form-label">New password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="w-75 mt-3">
                <label for="password_confirmation" class="form-label">Confirm new password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control" required>
                @error('password_confirmation')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <input type="hidden" name="email" value="{{$_GET['email']}}">
            <input type="hidden" name="token" value="{{$token}}">
            <button type="submit" class="btn btn-primary mt-3">Reset password</button>
        </form>
    </div>
</x-Layout>
