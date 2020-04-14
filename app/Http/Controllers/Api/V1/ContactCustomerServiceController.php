<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ContactCustomerService;
use App\Transformers\ContactCustomerServiceTransformer;

class ContactCustomerServiceController extends Controller
{
    public function show(ContactCustomerService $contactCustomerService)
    {
        return $this->response->item($contactCustomerService,new ContactCustomerServiceTransformer());
    }
}
