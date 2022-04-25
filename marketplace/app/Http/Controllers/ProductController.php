<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
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

    public function store()
    {
        request()->validate([
            'tags' => 'array|nullable|max:4',
            'tags.*' => 'integer|nullable|distinct',
            'image' => 'array|nullable|max:7',
            'image.*' => 'image|nullable|distinct'
        ]);
        $productAttributes = request()->validate([
            'title' => 'string|required|max:50',
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
                foreach (request()->file('image') ?? array() as $k => $image) {
                    $imagePath = $image->store('productImages/' . $product->id);
                    $product->images()->create(['main_image' => $k == 0 ?: 0, 'image_name' => $imagePath]);
                }
                $product->tags()->sync(request('tags'));
            } catch (\Exception $exception) {
                throw ValidationException::withMessages(['title' => 'Something goes wrong, try again later =(']);
//                throw ValidationException::withMessages(['title' => $exception->getMessage()]);
            }
        });

        return redirect('/' . request('category_slug') . '/products')->with('success', 'Product stored');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
