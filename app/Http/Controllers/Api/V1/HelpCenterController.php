<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\HelpCenter;
use App\Transformers\HelpCenterTransformer;

class HelpCenterController extends Controller
{

    public function show(HelpCenter $helpCenter)
    {
        return $this->response->item($helpCenter,new HelpCenterTransformer());
    }
}
