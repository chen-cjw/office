<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\HelpCenter;
use App\Transformers\HelpCenterTransformer;

class HelpCenterController extends Controller
{
    /**
     * 帮助我们
     **/
    public function show(HelpCenter $helpCenter)
    {
        return $this->response->item($helpCenter,new HelpCenterTransformer());
    }
}
