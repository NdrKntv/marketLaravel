<x-layout script="product/show">
    <div class="container">
        <div class="border-bottom d-inline-block mb-2">
            {{Breadcrumbs::render('product', $product->category, $product)}}
        </div>
        <section class="row justify-content-evenly">
            <div class="col-5">
                @if($product->images->count())
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
                            @foreach($product->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$image->image_name)}}"/>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                    <div thumbsSlider="" class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach($product->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{asset('storage/'.$image->image_name)}}"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div>
                        <img src="{{asset('images/default-product.jpg')}}" alt="product image" class="w-75">
                    </div>
                @endif
            </div>
            <div class="col-6">
                <h1>{{$product->title}}</h1>
                <div>
                    @foreach($product->tags as $tag)
                        <a href="{{route('products', $product->category->slug).'?'.$tag->slug.'=on'}}"
                           style="border: 1px solid #6c757d"
                           class="d-inline-block px-1 text-secondary rounded mb-1 text-decoration-none">#{{$tag->title}}</a>
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
                <p class="d-inline-block mx-5">Seller: <a
                        href="/user{{$product->user->id}}">{{$product->user->name}}</a></p>
                <p class="d-inline-block">Stored: {{$product->created_at->diffForHumans()}}</p>
                @auth
                    <div>
                        <button type="submit" id="{{$product->id}}"
                                class="btn btn-secondary favorites-toggle add"
                                style="margin-left: 4px">
                            <img src="{{asset('images/empty-star.png')}}" alt="Favorites"
                                 style="height: 20px; width: 20px">
                        </button>
                        <a href="#" class="btn btn-secondary" style="margin-left: 10px">Buy</a>
                    </div>
                @endauth
            </div>
            <article class="col-7">
                <span style="font-size: 20px">Comments</span>
                @guest
                    <div>
                        <span>You must authorise to leave comments: </span>
                        <a href="/login">Log In</a>
                        <span> or </span>
                        <a href="/create-account">Create Account</a>
                    </div>
                @else
                    @can('createComment', $product)
                        <form method="POST" action="/{{$product->id}}/comment">
                            @csrf
                            <textarea name="body" placeholder="Write something about this product" rows="3"
                                      cols="33"></textarea>
                            <div class="p-1">
                                <input class="form-check-input" type="radio" name="rate" id="likeRadio" value="like">
                                <label class="form-check-label" for="likeRadio">Like</label>
                                <input class="form-check-input" type="radio" name="rate" id="normRadio" checked
                                       value="normal">
                                <label class="form-check-label" for="normRadio">Normal</label>
                                <input class="form-check-input" type="radio" name="rate" id="dislikeRadio"
                                       value="dislike">
                                <label class="form-check-label" for="dislikeRadio">Dislike</label>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-secondary">Submit</button>
                            </div>
                        </form>
                    @endcan
                @endguest
                @if($product->comments->count()==0)
                    <div style="font-size: 25px; font-weight: bold">No comments yet =(</div>
                @endif
                @foreach($product->comments as $comment)
                    <x-comment-color rating="{{$comment->rating}}" class="p-2 mt-3">
                        @can('updateDelete', $comment)
                            <div class="position-absolute" style="margin-left: 150px;">
                                <form method="post" action="/comment/{{$comment->id}}" style="width: 30px">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="bg-danger">D</button>
                                </form>
                                <div class="dropdown">
                                    <button class="bg-warning dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" data-bs-auto-close="outside">U
                                    </button>
                                    <form method="post"
                                          class="bg-light p-1 rounded-1 dropdown-menu"
                                          action="/comment/{{$comment->id}}">
                                        @csrf
                                        @method('patch')
                                        <textarea name="body" placeholder="Write something about this product" rows="3"
                                                  cols="33">{{$comment->body}}</textarea>
                                        <div class="p-1">
                                            <input class="form-check-input" type="radio" name="rate" id="1likeRadio"
                                                   value="like" {{$comment->rating!='like'?:'checked'}}>
                                            <label class="form-check-label" for="1likeRadio">Like</label>
                                            <input class="form-check-input" type="radio" name="rate" id="1normRadio"
                                                   value="normal" {{$comment->rating!='normal'?:'checked'}}>
                                            <label class="form-check-label" for="1normRadio">Normal</label>
                                            <input class="form-check-input" type="radio" name="rate" id="1dislikeRadio"
                                                   value="dislike" {{$comment->rating!='dislike'?:'checked'}}>
                                            <label class="form-check-label" for="1dislikeRadio">Dislike</label>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-secondary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endcan
                        <div class="d-flex justify-content-between">
                            <div>
                                <img
                                    src="{{asset($comment->user->avatar?'storage/'.$comment->user->avatar:'images/default-avatar.png')}}"
                                    alt="user_avatar"
                                    style="height: 50px; width: 50px;">
                                <a href="/user{{$comment->user->id}}"
                                   style="color: black; text-decoration: none; vertical-align: top">{{$comment->user->name}}</a>
                            </div>
                            <img id="rating-img" src="{{asset('images/'.$comment->rating.'.png')}}"
                                 alt="{{$comment->rating}}" style="height: 30px; width: 30px">
                            <span>Published {{$comment->created_at->diffForHumans()}}</span>
                        </div>
                        <div>{{$comment->body}}</div>
                    </x-comment-color>
                @endforeach
            </article>
        </section>
    </div>
</x-layout>
