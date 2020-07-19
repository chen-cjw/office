<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\HelpCenter;
use App\Transformers\HelpCenterTransformer;

class HelpCenterController extends Controller
{
    public function index()
    {
        return $this->response->paginator(HelpCenter::orderBy('updated_at','desc')->paginate(),new HelpCenterTransformer());
    }
    /**
     * 帮助我们
     **/
    public function show($id)
    {
        return $this->response->item(HelpCenter::findOrFail($id),new HelpCenterTransformer());
    }
}
