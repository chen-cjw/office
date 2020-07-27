<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $app = app('wechat.mini_program');
        return $app->subscribe_message->getTemplates();
    }
}
