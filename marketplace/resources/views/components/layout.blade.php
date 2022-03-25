<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/app.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

<div class="container">
    <header class="container border-bottom">
        <nav class="navbar navbar-light bg-light justify-content-around row">
            <a class="navbar-brand col-1" href="/">Home</a>
            <div class="col-2" x-data="{ open: false }">
                <div class="dropdown">
                    <button @click="open=!open" class="btn btn-secondary dropdown-toggle" type="button"
                            id="dropdownMenuButton">
                        All categories
                    </button>
                    <div x-show="open" @click.outside="open = false" style="position: absolute;
    z-index: 1000;
    display: none;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0;
    font-size: 0.9rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <form class="form-inline col-4">
                <input class="form-control mr-sm-2 w-75 d-inline-block" type="search" placeholder="Search"
                       aria-label="Search">
                <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="col-4 nav-item d-flex justify-content-end px-0">

                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        fav
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        menu
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>

                <a href="#" class="nav-link d-inline-block link-secondary">Create Account</a>
                <a href="#" class="nav-link d-inline-block link-secondary">Log In</a>
            </div>

        </nav>
    </header>
    <main>
        {{$slot}}
    </main>
    <footer class="bg-secondary mt-3" style="height: 75px">

    </footer>
</div>
</body>
<script src="js/app.js"></script>
</html>

