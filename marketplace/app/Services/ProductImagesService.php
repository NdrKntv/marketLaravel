<?php

namespace App\Services;

class ProductImagesService
{
//    private $product;
//    private $request;
    static $deleteIfFail = [];

//    public function __construct($product, $request)
//    {
//        $this->product = $product;
//        $this->request = $request;
//    }

    static function upload($request, $product)
    {
        if ($images = $request->file('image')) {
            foreach ($images as $image) {
                $imagePath = $image->store('productImages/' . $product->id);
                self::$deleteIfFail[] = $imagePath;
                $product->images()->create(['main_image' => 0, 'image_name' => $imagePath]);
            }
            $product->images()->where('main_image', 1)->existsOr(fn() => $product->images()->first()->update(['main_image' => 1]));
        }
    }

    static function rollbackDelete()
    {
        dd(self::$deleteIfFail);
    }
}
