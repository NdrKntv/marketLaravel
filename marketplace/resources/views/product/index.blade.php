<meta name="csrf-token" content="{{ csrf_token() }}">
<x-Layout>
    <div class="container">
        <div class="border-bottom d-inline-block mb-2">
            {{Breadcrumbs::render('products', $category)}}
        </div>
        <div class="row justify-content-center">
            <article class="col-3 p-3">
                <h4>Filters</h4>
                <div class="mt-3">
                    <form method="GET" action="" class="d-flex align-content-center flex-column">
                        <div class="mt-3" x-data="{ open: false }">
                            <button @click="open=!open" class="btn btn-secondary dropdown-toggle" type="button">
                                Tags
                            </button>
                            <div x-show="open" @click.outside="open = false" style="position: absolute;
    z-index: 1000;
    display: none;
    min-width: 10rem;
    padding: 0.2rem 0.2rem;
    margin: 0;
    font-size: 0.9rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;">
                                @foreach($categoryTags as $tag)
                                    <div class="bg-secondary px-1 rounded{{$loop->iteration>1?' mt-1':''}}">
                                        <input class="form-check-input" type="checkbox" id="tag{{$tag->id}}"
                                               name="{{$tag->slug}}" {{request($tag->slug)?'checked':''}}>
                                        <label class="form-check-label" for="tag{{$tag->id}}">
                                            {{$tag->title}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-3">
                            <input class="form-check-input" type="checkbox" id="new"
                                   name="new" {{request('new')?'checked':''}}>
                            <label class="form-check-label" for="new">Only new</label>
                            <input class="form-check-input" type="checkbox" id="available"
                                   name="available" {{request('available')?'checked':''}}>
                            <label class="form-check-label" for="available">Only available now</label>
                        </div>
                        <div class="mt-3">
                            <label for="range" class="form-label">Enter your price limits</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="minPrice"
                                       id="flexSwitchCheckChecked" {{request('minPrice')?'checked':''}}>
                                <label class="form-check-label" for="flexSwitchCheckChecked">Enter MIN price</label>
                            </div>
                            <input type="range" class="form-range" min="{{$prices[1]}}"
                                   max="{{$prices[0]}}" id="range" value="{{request('priceLimit')??'0'}}">
                            <span>Price limit: </span>
                            <span id="rangeInt">no price limits</span>
                            <script>
                                let limit = document.getElementById('range');
                                let min = document.getElementById('range').min;
                                let span = document.getElementById('rangeInt');
                                if (limit.value !== min) {
                                    limit.setAttribute('name', 'priceLimit')
                                    span.textContent = limit.value;
                                }
                                limit.addEventListener('change', function (e) {
                                    span.textContent = e.target.value;
                                    limit.setAttribute('name', 'priceLimit');
                                })
                            </script>
                        </div>
                        <div class="mt-3">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm" name="sortBy">
                                <option value="id-DESC" {{request('sortBy')!='id-DESC'?:'selected'}}>
                                    Show latest
                                </option>
                                <option value="rating-DESC" {{request('sortBy')!='rating-DESC'?:'selected'}}>Show most
                                    popular
                                </option>
                                <option value="price-ASC" {{request('sortBy')!='price-ASC'?:'selected'}}>Show cheapest
                                </option>
                                <option value="price-DESC" {{request('sortBy')!='price-DESC'?:'selected'}}>Show most
                                    expensive
                                </option>
                            </select>
                        </div>
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{request('search')}}">
                        @endif
                        @if(request('user'))
                            <input type="hidden" name="user" value="{{request('user')}}">
                        @endif
                        <div class="m-auto mt-3">
                            <button class="btn btn-secondary" type="submit">Show results</button>
                        </div>
                    </form>
                </div>
            </article>
            <article class="col-9 d-flex flex-wrap justify-content-evenly start-0">
                @auth()
                    <div class="w-100 mb-2 d-flex justify-content-center" style="max-height: 50px">
                        <div class="p-1 rounded d-flex gap-5" style="border: 1px dashed #6c757d;">
                            <a href="products/create" class="btn btn-secondary">Add product <b>+</b></a>
                            <a href="?user={{auth()->id()}}&inactive=1" class="btn btn-secondary">My ALL products</a>
                            <a href="?user={{auth()->id()}}" class="btn btn-secondary">My ACTIVE products</a>
                        </div>
                    </div>
                @endauth
                @if($products->count())
                    @foreach($products as $product)
                        <div class="card mb-3" style="width: 16rem; {{$product->active==1?:'background: #dd6470d4'}}">
                            @can('updateDelete', $product)
                                <div class="position-absolute">
                                    <form method="post" action="/products/{{$product->slug}}" style="width: 30px">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-danger">D</button>
                                    </form>
                                    <button class="bg-light">
                                        <a href="/products/{{$product->slug}}/edit"
                                           class="text-black text-decoration-none">U</a>
                                    </button>
                                </div>
                            @endcan
                            <a href="/{{'products/'.$product->slug}}"><img
                                    src="{{asset(isset($product->image->image_name)?'storage/'.$product->image->image_name:'images/default-product.jpg')}}"
                                    class="card-img-top" alt="..."></a>
                            <div class="card-body">
                                <h5 class="card-title"
                                    style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%">
                                    {{$product->title}}</h5>
                                <p class="d-inline-block fw-bold">{{$product->price}}$</p>
                                <span class="badge rounded-pill bg-secondary mx-2">{{$product->in_stock}}</span>
                                @if($product->newness==0)
                                    <span class="badge rounded-pill bg-secondary">Used</span>
                                @endif
                                @if($product->active==0)
                                    <span class="badge rounded-pill bg-danger">Inactive</span>
                                @endif
                                <p class="card-text">{{Str::words($product->description, 9, $end='...')}}</p>
                                <div class="mb-2">
                                    @foreach($product->tags as $tag)
                                        <a href="{{request()->url().'?'.$tag->slug.'=on'}}"
                                           style="border: 1px solid #6c757d"
                                           class="d-inline-block px-1 rounded mb-1 text-decoration-none text-secondary">#{{$tag->title}}</a>
                                    @endforeach
                                </div>
                                <div>
                                    <a href="/{{'products/'.$product->slug}}" class="btn btn-secondary">More
                                        details</a>
                                    @auth
                                        {{--                                        @if(auth()->user()->favorites->contains($product->id))--}}
                                        {{--                                            <form method="POST" action="/favorites/{{$product->id}}"--}}
                                        {{--                                                  class="d-inline-block favorites-form" id="{{$product->id}}">--}}
                                        {{--                                                @csrf--}}
                                        {{--                                                @method('DELETE')--}}
                                        {{--                                                <button type="submit" class="btn btn-secondary"--}}
                                        {{--                                                        style="margin-left: 4px">--}}
                                        {{--                                                    <img src="{{asset('images/filled-star.png')}}" alt="Favorites"--}}
                                        {{--                                                         style="height: 20px; width: 20px">--}}
                                        {{--                                                </button>--}}
                                        {{--                                            </form>--}}
                                        {{--                                        @else--}}
                                        <button type="submit" id="{{$product->id}}"
                                                class="btn btn-secondary favorites-toggle add"
                                                style="margin-left: 4px">
                                            <img src="{{asset('images/empty-star.png')}}" alt="Favorites"
                                                 style="height: 20px; width: 20px">
                                        </button>
                                        {{--                                        @endif--}}
                                        <a href="#" class="btn btn-secondary" style="margin-left: 4px">Buy</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="font-weight: bold; font-size: 20px; padding-top: 3rem">No products )=</p>
                @endif
            </article>
            <nav class="d-flex justify-content-center pt-3">{{$products->links()}}</nav>
        </div>
    </div>
</x-Layout>
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
<script>
    function ajaxRequest() {
        if (!$('#favorites-list').length) {
            return
        }
        $.ajax({
            url: "http://127.0.0.1:8000/favorites",
            method: 'GET',
            success: function (favoritesObj) {
                let favoritesIds = []
                for (let i in favoritesObj) {
                    favoritesIds.push(favoritesObj[i].id)
                }
                let products = $(".favorites-toggle");
                products.each(function () {
                    if (favoritesIds.some(v => v == this.id)) {
                        $(this).children("img").attr("src", function (index, current) {
                            return current.replace('empty', 'filled')
                        })
                        $(this).removeClass('add')
                    }
                })
                // BUTTON
                products.off()
                products.click(function () {
                    let id = this.id
                    let token = $("meta[name='csrf-token']").attr("content");
                    let method
                    method = $(this).hasClass('add') ? 'POST' : 'DELETE'
                    if (method === 'DELETE') {
                        $(this).children("img").attr("src", function (index, current) {
                            return current.replace('filled', 'empty')
                        })
                        $(this).addClass('add')
                    }
                    $.ajax({
                        url: "http://127.0.0.1:8000/favorites/" + id,
                        type: method,
                        data: {
                            "_token": token,
                        },
                        success: function () {
                            console.log("it Works " + method);
                            ajaxRequest()
                        },
                    })
                })
            },
            error: function (error) {
                console.log(error)
            },
        })
    }

    $(document).ready(ajaxRequest());
</script>
