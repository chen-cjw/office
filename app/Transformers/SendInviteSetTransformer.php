<?php
namespace App\Transformers;
use App\Models\SendInviteSet;
use App\Models\Task;
use League\Fractal\TransformerAbstract;

class SendInviteSetTransformer extends TransformerAbstract
{
    public function transform(SendInviteSet $sendInviteSet)
    {
        // ['name','day','requirement'];
        return [
            'id' => $sendInviteSet->id,
            'name' => $sendInviteSet->name,
            'day' => $sendInviteSet->day,
            'requirement' => $sendInviteSet->requirement,
            'created_at' => $sendInviteSet->created_at->toDateTimeString(),
            'updated_at' => $sendInviteSet->updated_at->toDateTimeString(),
        ];
    }

}