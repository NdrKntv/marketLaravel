<x-Layout>
    <article class="container">
        <section class="row justify-content-evenly">
            <div class="col-3">
                <div>
{{--                    {{dd($user)}}--}}
                    <span class="fw-bold" style="font-size: 25px">{{$user->name}}</span>
                    <img src="{{$user->role=='human'?asset('images/user-icon.png'):asset('images/store-icon.png')}}"
                         alt="icon" style="width: 10%">
                </div>
                <img src="{{$user->avatar?:asset('images/default-avatar.png')}}" alt="avatar" class="rounded">
                <p class="text-secondary">Registered {{$user->created_at->diffForHumans()}}</p>
            </div>
            <div class="col-8 d-flex flex-column">
                <div class="py-3 h-50 d-flex flex-wrap">
                    <h4 class="w-100">Latest comments for users products</h4>
                    @if($user->comments->count())
                        @foreach($user->comments as $comment)
                        <x-comment-color rating="{{$comment->rating}}">
                            a
                        </x-comment-color>
                        @endforeach
                    @else
                        <p>This user did not receive comments yet =(</p>
                    @endif
                </div>
                <div class="py-3 h-50">a</div>
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
                    {{$user->description->description}}
                </div>
            </section>
        @endif
    </article>
</x-Layout>
