<?php

namespace App\Admin\Controllers;

use App\Models\Notice;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NoticeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '消息通知';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Notice());

        $grid->column('id', __('Id'));
        $grid->column('content', __('Content'));
        $grid->column('send_user_id', __('发送人'));
        $grid->column('to_user_id', __('接收人'));
        $grid->column('is_read', __('Is read'));

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
        $show = new Show(Notice::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('content', __('Content'));
        $show->field('is_read', __('Is read'));
        $show->field('send_user_id', __('Send user id'));
        $show->field('to_user_id', __('To user id'));
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
        $form = new Form(new Notice());

        $form->textarea('content', __('Content'));
        $form->switch('is_read', __('Is read'));
        $form->number('send_user_id', __('Send user id'));
        $form->number('to_user_id', __('To user id'));

        return $form;
    }
}
