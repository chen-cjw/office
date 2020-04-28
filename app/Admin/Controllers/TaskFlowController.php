<?php

namespace App\Admin\Controllers;

use App\Models\TaskFlow;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskFlowController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '流程步骤';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TaskFlow());

        $grid->column('id', __('Id'));
        $grid->column('step_name', __('Step name'));
        $grid->column('user_id', __('User id'));
        $grid->column('task_flow_collection_id', __('Task flow collection id'));
        $grid->column('status', __('Status'));
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
        $show = new Show(TaskFlow::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('step_name', __('Step name'));
        $show->field('user_id', __('User id'));
        $show->field('task_flow_collection_id', __('Task flow collection id'));
        $show->field('status', __('Status'));
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
        $form = new Form(new TaskFlow());

        $form->text('step_name', __('Step name'));
        $form->number('user_id', __('User id'));
        $form->number('task_flow_collection_id', __('Task flow collection id'));
        $form->text('status', __('Status'));

        return $form;
    }
}
