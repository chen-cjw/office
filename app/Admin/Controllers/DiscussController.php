<?php

namespace App\Admin\Controllers;

use App\Models\Discuss;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DiscussController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '评论列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Discuss());

        $grid->column('id', __('Id'));
        $grid->column('content', __('Content'));
        $grid->column('images', __('Images'));
        $grid->column('task_id', __('Task id'));
        $grid->column('comment_user_id', __('Comment user id'));
        $grid->column('reply_user_id', __('Reply user id'));
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
        $show = new Show(Discuss::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('content', __('Content'));
        $show->field('images', __('Images'));
        $show->field('task_id', __('Task id'));
        $show->field('comment_user_id', __('Comment user id'));
        $show->field('reply_user_id', __('Reply user id'));
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
        $form = new Form(new Discuss());

        $form->textarea('content', __('Content'));
        $form->text('images', __('Images'));
        $form->number('task_id', __('Task id'));
        $form->number('comment_user_id', __('Comment user id'));
        $form->number('reply_user_id', __('Reply user id'));

        return $form;
    }
}
