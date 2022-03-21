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
    <header class="container">
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
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div class="col-3 nav-item">
                <a href="#" class="nav-link"></a>
                <a href="#" class="nav-link"></a>
                <a href="#" class="nav-link"></a>
            </div>

        </nav>
    </header>
    <main>
        {{$slot}}
    </main>
    <footer class="bg-secondary mt-3" style="height: 100px">

    </footer>
</div>
</body>
<script src="js/app.js"></script>
</html>

