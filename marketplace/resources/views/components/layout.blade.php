<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<div class="container">
    <header class="container border-bottom">
        <nav class="navbar navbar-light bg-light justify-content-around row">
            <a class="navbar-brand col-1" href="/">Home</a>
            <div class="col-2">
                @if(!request()->routeIs('home'))
                    <x-category-dropdown/>
                @endif
            </div>
            <form class="form-inline col-4" method="GET" action="">
                @if(request()->routeIs('products'))
                    <input class="form-control mr-sm-2 w-75 d-inline-block" type="search" placeholder="Search"
                           aria-label="Search" name="search" value="{{request('search')??''}}">
                    @foreach($_GET as $k=>$v)
                        @if($k!=='search')
                            <input type="hidden" name="{{$k}}" value="{{$v}}">
                        @endif
                    @endforeach
                    <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
                @endif
            </form>
            <div class="col-4 nav-item d-flex justify-content-end px-0">
                @auth()
                    <div class="dropdown mx-4">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Favorites
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                {{$favorites->count()}}
                            </span>
                        </button>
                        <ul class="dropdown-menu" style="max-height: 350px; overflow-y: scroll"
                            aria-labelledby="dropdownMenuButton1">
                            @foreach($favorites as $fav)
                                <li>
                                    <a class="dropdown-item {{request()->is($fav->category->slug.'/'.$fav->slug)?'bg-secondary text-white':''}}"
                                       href="/{{$fav->category->slug.'/'.$fav->slug}}">
                                        <span>{{Str::words($fav->title, 3, $end='...')}}</span>
                                        <div>
                                            <span class="fw-bold">{{$fav->price}}$</span>
                                            <span>{{$fav->in_stock}}</span>
                                        </div>
                                        <div>From: {{$fav->category->title}}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            {{auth()->user()->name}}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="/user{{auth()->user()->id}}">My profile</a></li>
                            <li><a class="dropdown-item" href="/user{{auth()->user()->id}}/edit">Account settings</a>
                            </li>
                            <li>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="/create-account" class="nav-link d-inline-block link-secondary">Create Account</a>
                    <a href="/login" class="nav-link d-inline-block link-secondary">Log In</a>
                @endauth
            </div>

        </nav>
    </header>
    <main class="mt-3">
        {{$slot}}
    </main>
    <footer class="border-top mt-3 py-5">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled">Disabled</a>
            </li>
        </ul>
    </footer>
</div>
<x-success_flash/>
</body>
<script src="{{asset('js/app.js')}}"></script>
</html>

