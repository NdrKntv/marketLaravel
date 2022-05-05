<x-Layout>
    <section class="container w-75">
        <h4>Add new product in {{$category->title}} category</h4>
        <form method="POST" action="/{{$category->slug}}/products" enctype="multipart/form-data">
            @csrf
            <div class="mt-3 w-50">
                <label for="title" class="form-label">Title</label>
                <input class="form-control" type="text" name="title" id="title" value="{{old('title')}}"
                       placeholder="Product title" required>
                @error('title')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 w-25">
                <label for="price" class="form-label">Price $</label>
                <input class="form-control" type="number" name="price" id="price" value="{{old('price')}}"
                       placeholder="$" required>
                @error('price')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 w-75">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"
                          placeholder="Product description" required
                >{{old('description')}}</textarea>
                @error('description')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 w-75 d-flex flex-wrap gap-2">
                <div class="w-100">You can select up to 4 tags</div>
                @foreach($tags as $tag)
                    <div class="px-1 rounded" style="border: 1px solid #6c757d">
                        <input type="checkbox" name="tags[]" value="{{$tag->id}}" id="{{$tag->id}}"
                            {{!in_array($tag->id, old('tags')??array())?:'checked'}}>
                        <label for="{{$tag->id}}">#{{$tag->title}}</label>
                    </div>
                @endforeach
            </div>
            @error('tags')
            <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="mt-3">
                <label for="image" class="form-label">Images (max: 8)</label>
                <input type="file" id="image" name="image[]" multiple="multiple">
                @error('image')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3">
                <label for="in_stock" class="form-label">Product availability</label>
                <select name="in_stock" id="in_stock">
                    <option value="available" {{old("in_stock")!='available'?:'selected'}}>available</option>
                    <option value="coming soon" {{old("in_stock")!='coming soon'?:'selected'}}>coming soon</option>
                    <option value="on order" {{old("in_stock")!='on order'?:'selected'}}>on order</option>
                </select>
            </div>
            <div class="mt-1">
                <label for="used" class="form-label">Used</label>
                <input type="checkbox" name="newness" id="used" value="0" {{old('newness')!=='0'?:'checked'}}>
            </div>
            <div class="mt-2">
                <label for="inactive" class="form-label">Inactive</label>
                <input type="checkbox" name="active" id="inactive" value="0" {{old('active')!=='0'?:'checked'}}>
            </div>
            <input type="hidden" name="category_id" value="{{$category->id}}">
            <button type="submit" class="mt-3 btn-secondary btn">Create new product</button>
        </form>
    </section>
</x-Layout>
