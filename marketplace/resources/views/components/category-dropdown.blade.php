<div x-data="{ open: false }">
    <div class="dropdown">
        <button @click="open=!open" class="btn btn-secondary dropdown-toggle" type="button"
                id="dropdownMenuButton">
            {{$currentCategory->title??'Categories list'}}
        </button>
        <div x-show="open" @click.outside="open = false" style="position: absolute;
    z-index: 1000;
    display: none;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0;
    font-size: 0.9rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;">
            @foreach($categories as $category)
                <a class="dropdown-item" href="/{{$category->slug}}/products"
                   style="{{isset($currentCategory)&&$currentCategory->id==$category->id?'background: #6c757d':''}}"
                >{{$category->title}}</a>
            @endforeach
        </div>
    </div>
</div>
