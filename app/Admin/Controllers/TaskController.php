<?php

namespace App\Admin\Controllers;

use App\Models\Task;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TaskController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '任务管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Task());

        $grid->column('id', __('Id'));
        $grid->column('content', __('Content'));
        $grid->column('images', __('Images'));
        $grid->column('user_id', __('User id'));
        $grid->column('close_date', __('Close date'));
        $grid->column('task_flow', __('Task flow'));
        $grid->column('assignment_user_id', __('Assignment user id'));
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
        $show = new Show(Task::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('content', __('Content'));
        $show->field('images', __('Images'));
        $show->field('user_id', __('User id'));
        $show->field('close_date', __('Close date'));
        $show->field('task_flow', __('Task flow'));
        $show->field('assignment_user_id', __('Assignment user id'));
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
        $form = new Form(new Task());

        $form->textarea('content', __('Content'));
        $form->text('images', __('Images'));
        $form->number('user_id', __('User id'));
        $form->date('close_date', __('Close date'))->default(date('Y-m-d'));
        $form->text('task_flow', __('Task flow'));
        $form->text('assignment_user_id', __('Assignment user id'));
        $form->text('status', __('Status'));

        return $form;
    }
}
