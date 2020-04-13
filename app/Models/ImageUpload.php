<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getImagesAttribute()
    {
        return json_decode($this->attributes['images']);
    }
    public function uploadImages($imageBool,$image)
    {
        $imgs = [];
        if ($imageBool){
            foreach ($image as $file){
                //将图片存储到了 ../storage/app/public/product/ 路径下
                $path = $file->store('public/product');
                $path = str_replace('public','',$path);
                $imgs[]= asset('storage/'.$path);
            }
            return $imgs;
        }else{
            return response()->json([
                'info'=>'没有图片'
            ]);
        }
        //处理多图上传并返回数组
    }
}
