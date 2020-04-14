<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Task;
use Dingo\Api\Routing\Helpers;

class Controller extends BaseController
{
    use Helpers;
    //
    public function storeSave($model)
    {
        $imageBool = request()->hasFile('images');
        $images = request()->file('images');
        $uploadImage = $model->uploadImages($imageBool,$images);
//        $model->user()->associate($this->user);
        $model->images = json_encode($uploadImage);
        $model->save();

        return $this->response->created();
    }
}
