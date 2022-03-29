<x-layout>
    <div class="container">
        <div class="border-bottom d-inline-block mb-2">
            {{Breadcrumbs::render('product', $product->category, $product)}}
        </div>
    </div>
</x-layout>
