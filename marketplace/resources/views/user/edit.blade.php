<x-Layout>
    <section class="container w-50">
        <h4>Edit profile</h4>
        <form method="POST" action="/user{{$user->id}}" class=" container w-75">
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
                <label for="avatar" class="form-label">Avatar</label>
                <input class="form-control" id="avatar" type="file" name="avatar"
                       value="{{old('avatar', $user->avatar)}}">
                @error('avatar')
                <p class="text-danger">{{$message}}</p>
                @enderror
                <div><input type="checkbox" name="deleteAvatar">Delete avatar</div>
            </div>
            @if($description)
                <div class="mt-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" name="description" id="description" rows="3"
                              placeholder="Store description"
                    >{{old('description', $description->description)}}</textarea>
                    @error('description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="website" class="form-label">Website</label>
                    <input class="form-control" type="text" name="website" id="website"
                           value="{{old('website', $description->website)}}"
                           placeholder="Your website">
                    @error('website')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input class="form-control" type="text" name="instagram" id="instagram"
                           value="{{old('instagram', $description->instagram)}}"
                           placeholder="Your instagram">
                    @error('instagram')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label for="facebook" class="form-label">Facebook</label>
                    <input class="form-control" type="text" name="facebook" id="facebook"
                           value="{{old('facebook', $description->facebook)}}"
                           placeholder="Your facebook">
                    @error('facebook')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
            @endif
            <button type="submit" class="mt-3 btn-secondary btn">Edit changes</button>
        </form>
    </section>
</x-Layout>
