<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>


<header class="flex justify-between items-center">
    <nav class="w-full bg-blue-300 h-16">
        <div class="w-1/5 h-full"></div>
    </nav>
</header>
<div>
    {{$slot}}
</div>
<footer class="">

</footer>

</body>
<script src="//unpkg.com/alpinejs" defer></script>
</html>

