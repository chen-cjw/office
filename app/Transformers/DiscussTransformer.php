<?php
namespace App\Transformers;
use App\Models\ContactCustomerService;
use App\Models\Discuss;
use App\Models\HelpCenter;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class DiscussTransformer extends TransformerAbstract
{

    public function transform(Discuss $discuss)
    {
        return [
            'id' => $discuss->id,
            'content' => $discuss->content,
            'images' => $discuss->images,
            'reply' => $discuss->comment_user_id?$this->nickname($discuss->reply_user_id).'回复'.$this->nickname($discuss->comment_user_id):$this->nickname($discuss->reply_user_id),
            'created_at' => $discuss->created_at->toDateTimeString(),
            'updated_at' => $discuss->updated_at->toDateTimeString(),
        ];
    }

    public function nickname($user_id)
    {
        return User::where('id',$user_id)->value('nickname');
    }
}