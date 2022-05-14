    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle dd-button" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
            {{$currentCategory->title??'Categories list'}}
        </button>
        <div class="dropdown-menu">
            @foreach($categories as $category)
                <a class="dropdown-item" href="/{{$category->slug}}/products"
                   style="{{isset($currentCategory)&&$currentCategory->slug==$category->slug?'background: #6c757d':''}}"
                >{{$category->title}}</a>
            @endforeach
        </div>
    </div>
