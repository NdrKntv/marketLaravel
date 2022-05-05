<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Services\ProductImagesService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

                $product->tags()->sync($request->get('tags') ?? []);

                foreach ($request->file('image') ?? [] as $k => $image) {
                    $imagePath = $image->store('productImages/' . $product->id);
                    $product->images()->create(['main_image' => $k == 0 ?: 0, 'image_name' => $imagePath]);
                }
            } catch (\Exception $exception) {
                !isset($product) || Storage::deleteDirectory('productImages/' . $product->id);
                throw ValidationException::withMessages(['title' => 'Something goes wrong, try again later =(']);
//                throw ValidationException::withMessages(['title' => $exception->getMessage()]);
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

        foreach ($request->deleted()->get() as $img) {
            $deletedArr[] = $img->image_name;
        }

        DB::transaction(function () use ($product, $request) {
            try {
                $product->tags()->sync($request->get('tags') ?? []);

                $product->update($request->safe(['title', 'price', 'description', 'in_stock', 'newness', 'active']));

                $request->deleted()->delete();

                if ($newMainImage = $request->get('main_image')) {
                    $mainImage = Image::where([['product_id', $product->id], ['main_image', 1]])->select('id')->first();
                    if (!$mainImage || $mainImage->id != $newMainImage) {
                        !$mainImage ?: $mainImage->update(['main_image' => 0]);
                        Image::where('id', $newMainImage)->update(['main_image' => 1]);
                    }
                }
                ProductImagesService::upload($request, $product);
//                foreach ($request->file('image') ?? [] as $image) {
//                    $imagePath = $image->store('productImages/' . $product->id);
//                    $deleteIfFail[] = $imagePath;
//                    $product->images()->create(['main_image' => 0, 'image_name' => $imagePath]);
//                }
            } catch (\Exception $exception) {
                !isset($deleteIfFail) || Storage::delete($deleteIfFail);
//                throw ValidationException::withMessages(['title' => 'Something goes wrong, try again later =(']);
                throw ValidationException::withMessages(['title' => $exception->getMessage()]);
            }
        });

        !isset($deletedArr) || Storage::delete($deletedArr);

        return redirect('/products/' . $product->slug . '/edit')->with('success', 'Product edited');
    }

    public function destroy(Product $product)
    {
        $this->authorize('updateDelete', $product);

        $product->delete();

        Storage::deleteDirectory('productImages/' . $product->id);

        return back()->with('success', 'Product deleted');
    }
}
