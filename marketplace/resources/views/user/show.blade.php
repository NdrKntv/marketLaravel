<x-Layout>
    <article class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <div>
                    <span class="fw-bold" style="font-size: 25px">{{$user->name}}</span>
                    <img src="{{$user->role=='human'?asset('images/user-icon.png'):asset('images/store-icon.png')}}"
                         alt="icon" style="width: 10%">
                </div>
                <img src="{{$user->avatar?:asset('images/default-avatar.png')}}" alt="avatar" class="rounded">
                <p class="text-secondary">Registered {{$user->created_at->diffForHumans()}}</p>
            </div>
            <div class="col-8">

            </div>
        </div>
    </article>
</x-Layout>
