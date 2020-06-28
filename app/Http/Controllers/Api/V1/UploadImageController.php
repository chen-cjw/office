<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\UploadImageManyRequest;
use Illuminate\Http\Request;

class UploadImageController extends Controller
{
    public function store(UploadImageManyRequest $request)
    {
        $imageBool = request()->hasFile('images');
        if ($imageBool) {
            $images = request()->file('images');
            $path = $images->store('public/product');
            $path = str_replace('public','',$path);
            $imgs= asset('storage'.$path);
            return $imgs;
        }else {
            return response()->json([
                'info'=>'没有上传图片'
            ]);
        }
    }
}
