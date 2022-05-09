<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ProductImagesService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class ProductController extends Controller
{
    public function index($cSlug)
    {
        $category = Category::where('slug', $cSlug)->select(['id', 'title', 'slug'])->first();
        $categoryTags = $category->tags();

        $activeToggle = fn() => (request('user') == auth()->id() && request('inactive')) ? ['active', '<', 3] : ['active', '=', 1];

        $products = $category->products()->with('tags', 'image')->where([$activeToggle()])->tagFilter($categoryTags)
            ->filter(request(['search', 'new', 'available', 'user']));

        $maxPrice = $products->max('price');
        $minPrice = $products->min('price');

        return view('product.index', ['category' => $category, 'categoryTags' => $categoryTags, 'prices' => [$maxPrice, $minPrice],
            'products' => $products->filter(request(['minPrice', 'priceLimit']))->orderType(request('sortBy'))
                ->paginate(9)->withQueryString()]);
    }

    public function show($pSlug)
    {
        $product = Product::where('slug', $pSlug)
            ->get(['id', 'category_id', 'user_id', 'slug', 'title', 'price', 'description', 'in_stock', 'newness', 'created_at'])
            ->firstOrFail();

        return view('product.show', ['product' => $product]);
    }

    public function create($cSlug)
    {
        $category = Category::where('slug', $cSlug)->select(['id', 'slug', 'title'])->first();
        $tags = $category->tags();
        return view('product.create', ['category' => $category, 'tags' => $tags]);
    }

    public function store($cSlug, StoreProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            try {
                $product = Product::create($request->except('tags', 'image'));

                $product->tags()->sync($request->get('tags'));

                $imageService = new ProductImagesService($product, $request);
                $imageService->upload();
            } catch (\Exception $exception) {
                !isset($imageService) || $imageService->deleteFromStorage(true, true);
                throw ValidationException::withMessages(['title' => 'Something goes wrong, try again later =(']);
            }
        });

        return redirect('/' . $cSlug . '/products')->with('success', 'Product stored');
    }

    public function edit(Product $product)
    {
        $this->authorize('updateDelete', $product);

        return view('product.edit', ['product' => $product, 'tags' => $product->category->tags()]);
    }

    public function update(Product $product, UpdateProductRequest $request)
    {
        $this->authorize('updateDelete', $product);

        $imageService = new ProductImagesService($product, $request);
        DB::transaction(function () use ($product, $request, $imageService) {
            try {
                $product->tags()->sync($request->get('tags'));

                $product->update($request->safe(['title', 'price', 'description', 'in_stock', 'newness', 'active']));

                $imageService->deleteFromDB();
                $imageService->mainImage();
                $imageService->upload();
            } catch (\Exception $exception) {
                $imageService->deleteFromStorage(false, true);
                throw ValidationException::withMessages(['title' => 'Something goes wrong, try again later =(']);
//                throw ValidationException::withMessages(['title' => $exception->getMessage()]);
            }
        });
        $imageService->deleteFromStorage();

        return redirect('/products/' . $product->slug . '/edit')->with('success', 'Product edited');
    }

    public function destroy(Product $product)
    {
        $this->authorize('updateDelete', $product);

        $product->delete();
        (new ProductImagesService($product))->deleteFromStorage(true);

        return back()->with('success', 'Product deleted');
    }
}
