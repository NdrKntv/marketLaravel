<x-layout>
    <div class="container">
        <div class="row justify-content-center">
            <article class="col-3 p-3">
                <h4>Filters</h4>
                <div class="mt-3">

                    <form method="POST" action="" class="d-flex align-content-center flex-column">
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
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{$product->title}}</h5>
                                <p class="fw-bold">{{$product->price}}$</p>
                                <p class="card-text">{{$product->description}}</p>
                                <a href="#" class="btn btn-primary">More details</a>
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
