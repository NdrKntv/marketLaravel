<x-layout>
    <section class="d-flex flex-column">
        @foreach($categories as $category)
        <a href="/{{$category->slug}}" class="card bg-light text-black mt-3">
            <img class="card-img" src="/storage/category_images/{{$category->image}}" alt="Card image" style="height: 270px;
             object-fit: cover; filter: blur(3px)">
            <div class="card-img-overlay" style="text-shadow: 0px 0px 3px #FFFFFF;">
                <h2 class="card-title">{{$category->title}}</h2>
                <p class="card-text">{{$category->description}}</p>
            </div>
        </a>
        @endforeach
    </section>
</x-layout>
