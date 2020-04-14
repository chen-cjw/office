<?php
namespace App\Transformers;
use App\Models\ContactCustomerService;
use App\Models\HelpCenter;
use League\Fractal\TransformerAbstract;

class ContactCustomerServiceTransformer extends TransformerAbstract
{

    public function transform(ContactCustomerService $contactCustomerService)
    {
        return [
            'id' => $contactCustomerService->id,
            'content' => $contactCustomerService->content,
            'created_at' => $contactCustomerService->created_at->toDateTimeString(),
            'updated_at' => $contactCustomerService->updated_at->toDateTimeString(),
        ];
    }
}