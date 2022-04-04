<x-Layout>
    <div class="container">
        <div class="border-bottom d-inline-block mb-2">
            {{Breadcrumbs::render('product', $product->category, $product)}}
        </div>
        <section class="row justify-content-evenly">
            <div class="col-5">
                <style>
                    .swiper {
                        width: 100%;
                        height: 100%;
                    }

                    .swiper-slide {
                        text-align: center;
                        font-size: 18px;
                        background: #fff;

                        /* Center slide text vertically */
                        display: -webkit-box;
                        display: -ms-flexbox;
                        display: -webkit-flex;
                        display: flex;
                        -webkit-box-pack: center;
                        -ms-flex-pack: center;
                        -webkit-justify-content: center;
                        justify-content: center;
                        -webkit-box-align: center;
                        -ms-flex-align: center;
                        -webkit-align-items: center;
                        align-items: center;
                    }

                    .swiper-slide img {
                        display: block;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }

                    .swiper {
                        width: 100%;
                        height: 300px;
                        margin-left: auto;
                        margin-right: auto;
                    }

                    .swiper-slide {
                        background-size: cover;
                        background-position: center;
                    }

                    .mySwiper2 {
                        height: 80%;
                        width: 100%;
                    }

                    .mySwiper {
                        height: 20%;
                        box-sizing: border-box;
                        padding: 10px 0;
                    }

                    .mySwiper .swiper-slide {
                        width: 25%;
                        height: 100%;
                        opacity: 0.4;
                    }

                    .mySwiper .swiper-slide-thumb-active {
                        opacity: 1;
                    }

                    .swiper-slide img {
                        display: block;
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                </style>
                <div
                    style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff"
                    class="swiper mySwiper2"
                >
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="https://swiperjs.com/demos/images/nature-1.jpg"/>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://swiperjs.com/demos/images/nature-2.jpg"/>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://swiperjs.com/demos/images/nature-3.jpg"/>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://swiperjs.com/demos/images/nature-4.jpg"/>
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div thumbsSlider="" class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="https://swiperjs.com/demos/images/nature-1.jpg"/>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://swiperjs.com/demos/images/nature-2.jpg"/>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://swiperjs.com/demos/images/nature-3.jpg"/>
                        </div>
                        <div class="swiper-slide">
                            <img src="https://swiperjs.com/demos/images/nature-4.jpg"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <h1>{{$product->title}}</h1>
                <div class="rounded mb-2">
                    @foreach($product->tags as $tag)
                        <a href="{{route('products', $product->category->slug).'?'.$tag->slug.'=on'}}"
                           class="d-inline-block bg-secondary p-1 rounded text-white mb-1 text-decoration-none">{{$tag->title}}</a>
                    @endforeach
                </div>
                <h4 class="mt-4 mb-4">{{$product->description}}</h4>
                <div class="mb-4">
                    <span class="badge rounded-pill bg-secondary mx-2">{{$product->in_stock}}</span>
                    @if($product->newness==0)
                        <span class="badge rounded-pill bg-secondary">Used</span>
                    @endif
                </div>
                <p class="d-inline-block fw-bold">{{$product->price}}$</p>
                <p class="d-inline-block mx-5">Seller: <a href="">{{$product->user->name}}</a></p>
                <p class="d-inline-block">Stored: {{$product->created_at->diffForHumans()}}</p>
                @auth
                    <div>
                        @if(auth()->user()->favorites->contains($product->id))
                            <form method="POST" action="/favorites/{{$product->id}}"
                                  class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary"
                                        style="margin-left: 4px">
                                    <img src="{{asset('images/filled-star.png')}}" alt="Favorites"
                                         style="height: 20px; width: 20px">
                                </button>
                            </form>
                        @else
                            <form method="POST" action="/favorites/{{$product->id}}" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-secondary" style="margin-left: 4px">
                                    <img src="{{asset('images/empty-star.png')}}" alt="Favorites"
                                         style="height: 20px; width: 20px">
                                </button>
                            </form>
                        @endif
                        <a href="#" class="btn btn-secondary" style="margin-left: 10px">Buy</a>
                    </div>
                @endauth
            </div>
            <article class="col-7">
                <span style="font-size: 20px">Comments</span>
                @if($product->comments->count()==0)
                    <div style="font-size: 25px; font-weight: bold">No comments yet =(</div>
                @endif
                @foreach($product->comments as $comment)
                    <div id="comment-div" class="p-2 mt-3 rounded"
                         @switch($comment->rating)
                         @case('dislike')
                         style="background: #ff00005e"
                         @break
                         @case('like')
                         style="background: #1bff005e"
                         @break
                         @default
                         style="background: #ffff005e"
                        @endswitch
                    >
                        <div class="d-flex justify-content-between">
                            <div>
                                <img src="{{$comment->user->avatar?:asset('images/default-avatar.png')}}"
                                     alt="user_avatar"
                                     style="height: 50px; width: 50px">
                                <a href=""
                                   style="color: black; text-decoration: none; vertical-align: top">{{$comment->user->name}}</a>
                            </div>
                            <img id="rating-img" src="{{asset('images/'.$comment->rating.'.png')}}"
                                 alt="{{$comment->rating}}" style="height: 30px; width: 30px">
                            <span>Published {{$comment->created_at->diffForHumans()}}</span>
                        </div>
                        <div>{{$comment->body}}</div>
                    </div>
                @endforeach
            </article>
        </section>

    </div>
</x-Layout>
