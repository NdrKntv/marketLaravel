<x-Layout>
    <section class="container w-75">
        <h4>Edit product {{$product->title}}</h4>
        <form method="POST" action="/products/{{$product->slug}}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mt-3 w-50">
                <label for="title" class="form-label">Title</label>
                <input class="form-control" type="text" name="title" id="title"
                       value="{{old('title')??$product->title}}"
                       placeholder="Product title" required>
                @error('title')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 w-25">
                <label for="price" class="form-label">Price $</label>
                <input class="form-control" type="number" name="price" id="price"
                       value="{{old('price')??$product->price}}"
                       placeholder="$" required>
                @error('price')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 w-75">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"
                          placeholder="Product description" required
                >{{old('description')??$product->description}}</textarea>
                @error('description')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 w-75 d-flex flex-wrap gap-2">
                <div class="w-100">You can select up to 4 tags</div>
                @foreach($tags as $tag)
                    <div class="px-1 rounded" style="border: 1px solid #6c757d">
                        <input type="checkbox" name="tags[]" value="{{$tag->id}}" id="{{$tag->id}}"
                            {{old('tags')?(!in_array($tag->id, old('tags'))?:'checked'):
                                          (!$product->tags->contains('id', $tag->id)?:'checked')}}>
                        <label for="{{$tag->id}}">#{{$tag->title}}</label>
                    </div>
                @endforeach
                @error('tags')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3 d-flex row-cols-lg-4 flex-wrap">
                <div class="w-100 px-1">Here you can delete images or chose main image</div>
                @foreach($product->images as $image)
                    <div style="height: 175px; padding: 5px">
                        <div class="h-100"
                             style="background: url({{asset('/storage/'.$image->image_name)}}), center, no-repeat; background-size: cover">
                            <div
                                class="h-50 bg-opacity-50 d-flex align-items-center justify-content-center">
                                <input type="radio" name="main_image" value="{{$image->id}}"
                                       id="main_image{{$loop->iteration}}"
                                    {{old('main_image')?(old('main_image')!=$image->id?:'checked'):(!$loop->first?:'checked')}}>
                                <label for="main_image{{$loop->iteration}}" class="fw-bold"
                                       style="text-shadow: 0px 0px 5px #FFFFFF">Main image</label>
                            </div>
                            <div class="h-50 bg-opacity-50 d-flex align-items-center justify-content-center">
                                <input type="checkbox" name="delete_image[]" value="{{$image->id}}"
                                       id="delete_image{{$loop->iteration}}"
                                    {{!old('delete_image')?:!in_array($image->id, old('delete_image'))?:'checked'}}>
                                <label for="delete_image{{$loop->iteration}}" class="fw-bold"
                                       style="text-shadow: 0px 0px 5px #FFFFFF">Delete image</label>
                            </div>
                        </div>
                    </div>
                @endforeach
                <script>
                    for (let i = 1; i <= 8; i++) {
                        let chBox = document.getElementById('delete_image' + i)
                        let radio = document.getElementById('main_image' + i)
                        if (!chBox) {
                            break
                        }
                        chBox.addEventListener('change',
                            function () {
                                radio.toggleAttribute('disabled')
                                radio.removeAttribute('checked')
                                chBox.parentElement.classList.toggle('bg-danger')
                            })
                        if (chBox.hasAttribute('checked')){
                            chBox.parentElement.classList.toggle('bg-danger')
                        }
                        radio.addEventListener('change', function () {
                            radio.parentElement.classList.toggle('bg-success')
                        })
                        if (radio.hasAttribute('checked')){
                            radio.parentElement.classList.toggle('bg-success')
                        }
                    }
                </script>
            </div>
            <div class="mt-1">
                <label for="image" class="form-label">Add images (max: 8, including already stored)</label>
                <input type="file" id="image" name="image[]" multiple="multiple">
                @error('image')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-3">
                <label for="in_stock" class="form-label">Product availability</label>
                <select name="in_stock" id="in_stock">
                    <option value="available" {{old("in_stock")??$product->in_stock!='available'?:'selected'}}>
                        available
                    </option>
                    <option value="coming soon" {{old("in_stock")??$product->in_stock!='coming soon'?:'selected'}}>
                        coming soon
                    </option>
                    <option value="on order" {{old("in_stock")??$product->in_stock!='on order'?:'selected'}}>on order
                    </option>
                </select>
            </div>
            <div class="mt-1">
                <label for="use d" class="form-label">Used</label>
                <input type="checkbox" name="newness" id="used"
                       value="0" {{$errors->isEmpty()?($product->newness!==0?:'checked'):(old('newness')!=='0'?:'checked')}}>
            </div>
            <div class="mt-2">
                <label for="inactive" class="form-label">Inactive</label>
                <input type="checkbox" name="active" id="inactive"
                       value="0" {{$errors->isEmpty()?($product->active!==0?:'checked'):(old('active')!=='0'?:'checked')}}>
            </div>
            <button type="submit" class="mt-3 btn-secondary btn">Update product</button>
        </form>
    </section>
</x-Layout>
