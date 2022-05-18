<x-layout script="product/index">
    <div class="container">
        <div class="border-bottom d-inline-block mb-2">
            {{Breadcrumbs::render('products', $category)}}
        </div>
        <div class="row justify-content-center">
            <article class="col-3 p-3">
                <h4>Filters</h4>
                <div class="mt-3">
                    <form method="GET" action="" class="d-flex align-content-center flex-column">
                        <div class="mt-3 dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                Tags
                            </button>
                            <div class="dropdown-menu">
                                @foreach($categoryTags as $tag)
                                    <label class="dropdown-item">
                                        <input class="form-check-input" type="checkbox" id="tag{{$tag->id}}"
                                               name="{{$tag->slug}}" {{request($tag->slug)?'checked':''}}> {{$tag->title}}
                                    </label>
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
                                    <form method="post" action="/products/{{$product->slug}}"
                                          style="margin-bottom: 0; width: 30px">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-danger">D</button>
                                    </form>
                                    <button class="bg-warning">
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
</x-layout>
