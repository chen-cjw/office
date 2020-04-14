<?php
namespace App\Transformers;
use App\Models\HelpCenter;
use League\Fractal\TransformerAbstract;

class HelpCenterTransformer extends TransformerAbstract
{

    public function transform(HelpCenter $helpCenter)
    {
        return [
            'id' => $helpCenter->id,
            'content' => $helpCenter->content,
            'created_at' => $helpCenter->created_at->toDateTimeString(),
            'updated_at' => $helpCenter->updated_at->toDateTimeString(),
        ];
    }
}