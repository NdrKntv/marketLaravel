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
{{--        <a href="#" class="card bg-light text-black mt-3">--}}
{{--            <img class="card-img" src="/images/bags_category_bg.jpg" alt="Card image" style="height: 270px;--}}
{{--            object-fit: cover; filter: blur(3px)">--}}
{{--            <div class="card-img-overlay" style="text-shadow: 0px 0px 3px #FFFFFF;">--}}
{{--                <h2 class="card-title">Bags</h2>--}}
{{--                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab alias amet cum--}}
{{--                    debitis dignissimos, dolores ea eius excepturi id, impedit in inventore, itaque iusto magnam nam--}}
{{--                    natus nesciunt obcaecati praesentium quae quaerat quia quo sint suscipit tenetur velit veniam. At--}}
{{--                    consectetur consequuntur cum dicta dignissimos distinctio dolorem eligendi enim eos esse--}}
{{--                    exercitationem harum, ipsum itaque magni minima mollitia nihil perferendis quis quisquam quo quos--}}
{{--                    reprehenderit rerum, sequi similique vel vero voluptas! Accusamus alias aliquid assumenda atque,--}}
{{--                    debitis dolore facilis, in incidunt itaque magni minus necessitatibus nemo nulla odio omnis tempora,--}}
{{--                    tenetur vitae. Ab consequuntur ex, iure perspiciatis provident totam!</p>--}}
{{--            </div>--}}
{{--        </a>--}}
    </section>
</x-layout>
