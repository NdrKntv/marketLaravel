<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ProductImagesService
{
    private $product;
    private $request;
    private $deletedArr = [];
    private $deleteIfFail = [];

    public function __construct($product, $request = null)
    {
        $this->product = $product;
        $this->request = $request;
    }

    public function deleteFromDB()
    {
        foreach ($this->request->deleted()->get() as $img) {
            $this->deletedArr[] = $img->image_name;
        }

        $this->request->deleted()->delete();
    }

    public function deleteFromStorage($deleteDirectory = false, $updateRollback = false)
    {
        if ($deleteDirectory) {
            Storage::deleteDirectory('productImages/' . $this->product->id);
        } else {
            Storage::delete($updateRollback ? $this->deleteIfFail : $this->deletedArr);
            count(Storage::files('productImages/' . $this->product->id)) ?:
                Storage::deleteDirectory('productImages/' . $this->product->id);
        }
    }

    public function mainImage()
    {
        if ($newMainImage = $this->request->get('main_image')) {
            $mainImage = Image::where([['product_id', $this->product->id], ['main_image', 1]])->select('id')->first();
            if (!$mainImage || $mainImage->id != $newMainImage) {
                !$mainImage || $mainImage->update(['main_image' => 0]);
                Image::where('id', $newMainImage)->update(['main_image' => 1]);
            }
        }
    }

    public function upload()
    {
        if ($images = $this->request->file('image')) {
            $mainImg = $this->product->image()->exists() ? 0 : 1;
            foreach ($images as $image) {
                $imagePath = $image->store('productImages/' . $this->product->id);
                $this->deleteIfFail[] = $imagePath;
                $this->product->images()->create(['main_image' => $mainImg, 'image_name' => $imagePath]);
                $mainImg = 0;
            }
        }
    }
}
