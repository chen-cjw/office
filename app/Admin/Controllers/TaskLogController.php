<?php

namespace App\Admin\Controllers;

use App\Models\TaskLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '任务日志';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TaskLog());

        $grid->column('id', __('Id'));
        $grid->column('content', __('Content'));
        $grid->column('user_id', __('User id'));
        $grid->column('model_id', __('Model id'));
        $grid->column('model_type', __('Model type'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(TaskLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('content', __('Content'));
        $show->field('user_id', __('User id'));
        $show->field('model_id', __('Model id'));
        $show->field('model_type', __('Model type'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TaskLog());

        $form->text('content', __('Content'));
        $form->number('user_id', __('User id'));
        $form->text('model_id', __('Model id'));
        $form->text('model_type', __('Model type'));

        return $form;
    }
}
