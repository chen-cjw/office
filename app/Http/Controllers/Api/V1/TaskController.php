<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * 我的任务(首页)
     * 条件（按截止时间排序 | 创建时间排序 | 查看已完成任务 | 查看我创建的任务）
     **/

    public function index()
    {
        
    }

    // 创建子任务(发布任务) 无父任务(创建给你让你，去完成的)
    public function store()
    {
        
    }
    //
    public function show($id)
    {
        
    }

}
