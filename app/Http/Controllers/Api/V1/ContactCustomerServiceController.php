<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ContactCustomerService;
use App\Transformers\ContactCustomerServiceTransformer;

class ContactCustomerServiceController extends Controller
{
    public function index()
    {
        return $this->response->paginator(ContactCustomerService::orderBy('updated_at','desc')->paginate(),new ContactCustomerServiceTransformer());
    }
    /**
     * 联系客服
     **/
    public function show($id)
    {
        return $this->response->item(ContactCustomerService::findOrFail($id),new ContactCustomerServiceTransformer());
    }
}
