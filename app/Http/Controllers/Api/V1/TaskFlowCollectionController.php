<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\TaskFlowCollection;
use App\Transformers\TaskFlowCollectionTransformer;
use Illuminate\Http\Request;

class TaskFlowCollectionController extends Controller
{
    public function index()
    {
        return $this->response->paginator($this->user->taskFlowCollections()->paginate(),new TaskFlowCollectionTransformer());
    }

    public function show($id)
    {
        return $this->response->item($this->user->taskFlowCollections()->where('id',$id)->firstOrFail(),new TaskFlowCollectionTransformer());
    }
}
