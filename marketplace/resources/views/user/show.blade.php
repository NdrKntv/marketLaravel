<x-Layout>
    <div class="container">
        <section class="row justify-content-evenly">
            <article class="col-3">
                <div>
                    <span class="fw-bold" style="font-size: 25px">{{$user->name}}</span>
                    <img src="{{$user->role=='human'?asset('images/user-icon.png'):asset('images/store-icon.png')}}"
                         alt="icon" style="width: 10%">
                </div>
                <img src="{{asset($user->avatar?'storage/'.$user->avatar:'images/default-avatar.png')}}"
                     alt="avatar" class="rounded mt-3" style="max-width: 255px">
                <p class="text-secondary mt-2">Registered {{$user->created_at->diffForHumans()}}</p>
                @if($user->phone)
                    <p class="fw-bold fs-5">Phone: {{$user->phone}}</p>
                @else
                    <p class="fw-bold fs-5">No phone number</p>
                @endif
            </article>
            <div class="col-8 d-flex flex-column">
                <article class="py-1 d-flex flex-column">
                    <h4 class="w-100">Latest comments for users products:</h4>
                    @if($user->comments->count())
                        <div class="d-flex flex-wrap row-cols-5 h-100">
                            @foreach($user->comments as $comment)
                                <div class="p-1">
                                    <x-comment-color rating="{{$comment->rating}}" class="h-100 w-100 p-1">
                                        <div class="text-secondary d-inline-block"
                                             style="width: 80%">{{$comment->created_at->diffForHumans()}}</div>
                                        <div style="width: 18%; float: right;"><img
                                                src="{{asset('images/'.$comment->rating.'.png')}}" alt="" class="w-100">
                                        </div>
                                        <div class="d-flex w-100">
                                            <span>To:</span>
                                            <a href="/{{$comment->product->category->slug.'/'.$comment->product->slug}}"
                                               style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; display: inline-block">
                                                {{$comment->product->title}}</a>
                                        </div>
                                    </x-comment-color>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>This user didn't receive comments yet =(</p>
                    @endif
                </article>
                <article class="py-1">
                    <h4 class="w-100">Latest users products:</h4>
                    @if($categories->count())
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @foreach($categories as $category)
                                <div class="accordion-item">
                                    <h5 class="accordion-header" id="flush-heading{{$category->id}}">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapse{{$category->id}}"
                                                aria-expanded="false" aria-controls="flush-collapse{{$category->id}}">
                                            {{$category->title}}
                                        </button>
                                    </h5>
                                    <div id="flush-collapse{{$category->id}}" class="accordion-collapse collapse"
                                         aria-labelledby="flush-heading{{$category->id}}"
                                         data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="d-flex row-cols-5" style="height: 150px">
                                                @foreach($products[$category->id] as $product)
                                                    <div class="p-1">
                                                        <a href="/{{$category->slug.'/'.$product->slug}}"
                                                           class="text-secondary text-decoration-none h-100 d-flex flex-column justify-content-around p-1"
                                                           style="border: 1px solid #6c757d;">
                                                            <h3 style="white-space: nowrap; overflow:hidden; text-overflow: ellipsis; max-width: 100%; font-size: 16px">
                                                                {{$product->title}}
                                                            </h3>
                                                            <span class="fw-bold">${{$product->price}}</span>
                                                            <div class="py-1" style="height: 45%; overflow-y: scroll">
                                                                @foreach($product->tags as $tag)
                                                                    <span>#{{$tag->title}}</span>
                                                                @endforeach
                                                            </div>
                                                            <div
                                                                class="align-self-end">{{$product->created_at->diffForHumans()}}</div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a href="/{{$category->slug}}?user={{$user->id}}">View all
                                                users {{$category->title}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>This user doesn't sell anything now =(</p>
                    @endif
                </article>
            </div>
        </section>
        @if($user->role=='shop')
            <section class="row justify-content-evenly">
                <div class="col-2">
                    <div class="fw-bold">Links</div>
                    @if($user->description->website)
                        <a href="{{$user->description->website}}" target="_blank"><img src="{{asset('images/web.png')}}"
                                                                                       alt="www"
                                                                                       style="height: 30px"></a>
                    @endif
                    @if($user->description->instagram)
                        <a href="{{$user->description->instagram}}" target="_blank"><img
                                src="{{asset('images/instagram.png')}}"
                                alt="inst" style="height: 30px"></a>
                    @endif
                    @if($user->description->facebook)
                        <a href="{{$user->description->facebook}}" target="_blank"><img
                                src="{{asset('images/facebook.png')}}" alt="fb"
                                style="height: 30px"></a>
                    @endif
                </div>
                <div class="col-8">
                    <h4>Description:</h4>
                    <p>{{$user->description->description}}</p>
                </div>
            </section>
        @endif
    </div>
</x-Layout>
