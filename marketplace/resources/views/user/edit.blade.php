<x-Layout>
    <section class="container w-25">
        <h4>Edit profile</h4>
        <form method="POST" action="/user{{$user->id}}">
            @csrf
            @method('PATCH')
            <div class="mt-3">
                <label for="phone" class="form-label">Phone</label>
                <input class="form-control" type="text" name="phone" id="phone" value="{{old('phone', $user->phone)}}"
                       placeholder="Phone number">
                @error('phone')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3">
                <label for="password" class="form-label">Password</label>
                <input class="form-control" id="password" type="password" name="password" placeholder="New password">
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="mt-3">
                <label for="avatar" class="form-label">Avatar</label>
                <input class="form-control" id="avatar" type="file" name="avatar"
                       value="{{old('avatar', $user->avatar)}}">
                @error('avatar')
                <p class="text-danger">{{$message}}</p>
                @enderror
                <div><input type="checkbox" name="deleteAvatar">Delete avatar</div>
            </div>
            @if($description)
                {{$description->description}}
            @endif
            <button type="submit" class="mt-3 btn-secondary btn">Edit changes</button>
        </form>
    </section>
</x-Layout>
