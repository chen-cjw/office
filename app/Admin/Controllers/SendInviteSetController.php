<?php

namespace App\Admin\Controllers;

use App\Models\SendInviteSet;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SendInviteSetController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '配置(邀请老板和同事)';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SendInviteSet());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('day', __('Day'));
        $grid->column('requirement', __('Requirement'));
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
        $show = new Show(SendInviteSet::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('day', __('Day'));
        $show->field('requirement', __('Requirement'));
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
        $form = new Form(new SendInviteSet());

        $form->text('name', __('Name'));
        $form->number('day', __('Day'));
        $form->number('requirement', __('Requirement'));

        return $form;
    }
}
