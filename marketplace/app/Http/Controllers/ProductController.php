<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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

    public function store()
    {
        request()->validate([
            'tags' => 'array|nullable|max:4',
            'tags.*' => 'integer|nullable|distinct',
            'image' => 'array|nullable|max:8',
            'image.*' => 'image|nullable|distinct'
        ]);
        $productAttributes = request()->validate([
            'title' => 'string|required|max:50|min:2',
            'price' => 'integer|required',
            'description' => 'string|required|max:1500',
            'in_stock' => 'string',
            'newness' => 'int|nullable',
            'active' => 'int|nullable'
        ]);
        $productAttributes += ['user_id' => auth()->id(), 'category_id' => request('category_id'), 'slug' => ''];

        DB::transaction(function () use ($productAttributes) {
            try {
                $product = Product::create($productAttributes);

                $product->tags()->sync(request('tags'));

                foreach (request()->file('image') ?? array() as $k => $image) {
                    $imagePath = $image->store('productImages/' . $product->id);
                    $product->images()->create(['main_image' => $k == 0 ?: 0, 'image_name' => $imagePath]);
                }
            } catch (\Exception $exception) {
                Storage::deleteDirectory('productImages/' . $product->id);

                throw ValidationException::withMessages(['title' => 'Something goes wrong, try again later =(']);
//                throw ValidationException::withMessages(['title' => $exception->getMessage()]);
            }
        });

        return redirect('/' . request('category_slug') . '/products')->with('success', 'Product stored');
    }

    public function edit(Product $product)
    {
        $this->authorize('updateDelete', $product);

        return view('product.edit', ['product' => $product, 'tags' => $product->category->tags()]);
    }

    public function update(Product $product)
    {
        $this->authorize('updateDelete', $product);

        $currentImages = $product->images();
        $deleted = $currentImages->whereIn('id', request('delete_image') ?? []);
        $imageLimit = 8 - $currentImages->count() + $deleted->count();
        ////////////!!!!!!!!1
        foreach ($deleted->get() as $img) {
           dd($img->image_name);
        }
        request()->validate([
            'main_image' => ['nullable', 'integer', 'exists:images,id,product_id,' . $product->id],
            'delete_image' => 'array|nullable',
            'delete_image.*' => ['nullable', 'integer', 'exists:images,id,product_id,' . $product->id],
            'tags' => 'array|nullable|max:4',
            'tags.*' => 'integer|nullable|distinct',
            'image' => 'array|nullable|max:' . $imageLimit,
            'image.*' => 'image|nullable|distinct'
        ]);
        $attributes = request()->validate([
            'title' => 'string|required|max:50|min:2',
            'price' => 'integer|required',
            'description' => 'string|required|max:1500',
            'in_stock' => 'string',
            'newness' => 'int|nullable',
            'active' => 'int|nullable'
        ]);

        DB::transaction(function () use ($attributes, $product, $currentImages, $deleted) {
            try {
                $product->tags()->sync(request('tags'));

                $deleted->delete();

                $attributes += ['slug' => '', 'newness'=>request('newness')??'1', 'active'=>request('active')??'1'];
                $product->update($attributes);

            } catch (\Exception $exception) {
//                throw ValidationException::withMessages(['title' => 'Something goes wrong, try again later =(']);
                throw ValidationException::withMessages(['title' => $exception->getMessage()]);
            }
        });
////!!!!!!!!!!!!!!!!!!!!!!!!!!11
        foreach ($deleted->get() as $img) {
            Storage::delete($img->image_name);
        }

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
