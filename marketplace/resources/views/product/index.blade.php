<x-layout>
    <div class="container">
        <div class="border-bottom d-inline-block mb-2">
            {{Breadcrumbs::render('categories', $category)}}
        </div>
        <div class="row justify-content-center">
            <article class="col-3 p-3">
                <h4>Filters</h4>
                <div class="mt-3">
                    <form method="POST" action="" class="d-flex align-content-center flex-column">
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
                                @foreach($category->tags as $tag)
                                    <div class="bg-secondary px-1 rounded{{$loop->iteration>1?' mt-1':''}}">
                                        <input class="form-check-input" type="checkbox" id="tag{{$tag->id}}"
                                               name="tag{{$tag->id}}" value="{{old('tag'.$tag->id)}}">
                                        <label class="form-check-label" for="tag{{$tag->id}}">
                                            {{$tag->title}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-3">
                            <input class="form-check-input" type="checkbox" id="new" value="new">
                            <label class="form-check-label" for="new">Only new</label>
                            <input class="form-check-input" type="checkbox" id="available" value="available">
                            <label class="form-check-label" for="available">Only available now</label>
                        </div>
                        <div class="mt-3">
                            <label for="range" class="form-label">Enter your price limits</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="priceSwitch"
                                       id="flexSwitchCheckChecked" value="{{old('priceSwitch')}}">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Enter MIN price</label>
                            </div>
                            <input type="range" name="priceRange" class="form-range" min="1" max="1000" id="range"
                                   oninput="this.form.priceInt.value=this.value">
                            <input type="number" placeholder="Price limit" name="priceInt" value="{{old('priceInt')}}"
                                   oninput="this.form.priceRange.value=this.value">
                        </div>
                        <div class="mt-3">
                            <select class="form-select form-select-sm" aria-label=".form-select-sm" name="sortBy">
                                <option selected>Show latest</option>
                                <option value="1">Show most popular</option>
                                <option value="2">Show cheapest</option>
                                <option value="3">Show most expensive</option>
                            </select>
                        </div>
                        <div class="m-auto mt-3">
                            <button class="btn btn-secondary" type="submit">Show results</button>
                        </div>
                    </form>
                </div>
            </article>
            <article class="col-9 d-flex flex-wrap justify-content-evenly start-0">
                @if($products->count())
                    @foreach($products as $product)
                        <div class="card mb-3" style="width: 16rem;">
                            <a href="{{request()->url().'/'.$product->slug}}"><img src="images/default-product.jpg"
                                                                                   class="card-img-top" alt="..."></a>
                            <div class="card-body">
                                <h5 class="card-title">{{Str::words($product->title, 5, $end='...')}}</h5>
                                <p class="d-inline-block fw-bold">{{$product->price}}$</p>
                                <span class="badge rounded-pill bg-secondary mx-2">{{$product->in_stock}}</span>
                                @if($product->newness==0)
                                    <span class="badge rounded-pill bg-secondary">Used</span>
                                @endif
                                <p class="card-text">{{Str::words($product->description, 9, $end='...')}}</p>
                                <div class="rounded mb-2">
                                    @foreach($product->tags as $tag)
                                        <a href="{{request()->url().'/'.$tag->slug}}"
                                           class="d-inline-block bg-secondary p-1 rounded text-white mb-1 text-decoration-none">{{$tag->title}}</a>
                                    @endforeach
                                </div>
                                <div>
                                    <a href="{{request()->url().'/'.$product->slug}}" class="btn btn-secondary">More
                                        details</a>
                                    @auth
                                        <form method="POST" action="/favorites/{{$product->id}}" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary" style="margin-left: 4px">
                                                <img src="{{asset('images/empty-star.png')}}" alt="Favorites"
                                                     style="height: 20px; width: 20px">
                                            </button>
                                        </form>
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
