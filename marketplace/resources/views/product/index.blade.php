<x-layout>
    <div class="container">
        <div class="row justify-content-center">
            <article class="col-3"></article>
            <article class="col-9 d-flex flex-wrap justify-content-evenly start-0">
                @if($products->count())
                    @foreach($products as $product)
                        <div class="card mb-3" style="width: 16rem;">
                            <img src="..." class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{$product->title}}</h5>
                                <p class="fw-bold">{{$product->price}}$</p>
                                <p class="card-text">{{$product->description}}</p>
                                <a href="#" class="btn btn-primary">Add to Favorites</a>
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
