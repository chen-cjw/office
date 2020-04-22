<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Task;
use App\Models\TeamMember;
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
        return $model;

        return $this->response->created();
    }

    // 邀请成员
    public function teamMember($user,$team)
    {
        $teamMember = new TeamMember();
        $teamMember->user()->associate($user);
        $teamMember->team()->associate($team);
        $teamMember->save();
    }

    // 发送模版消息
    public function template_message($openid,$template_id,$data)
    {
        $app = app('wechat.official_account');
        $app->template_message->send([
            'touser' => $openid,
            'template_id' => $template_id,
            //'url' => 'https://easywechat.org',
            'data' => $data,
        ]);
        return $app;
    }
}
