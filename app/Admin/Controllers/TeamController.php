<?php

namespace App\Admin\Controllers;

use App\Models\Team;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeamController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '团队管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Team());

        $grid->column('id', __('Id'));
        $grid->column('name', __('团队名称'));
        $grid->column('user.nickname', __('创建人'));
        $grid->column('number_count', __('Number count'));
        $grid->column('close_time', __('Close time'));
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
        $show = new Show(Team::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('团队名称'));
        $show->field('user_id', __('创建人'));
        $show->field('number_count', __('Number count'));
        $show->field('close_time', __('Close time'));
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
        $form = new Form(new Team());

        $form->text('name', __('团队名称'));
        $form->number('user_id', __('创建人'));
        $form->number('number_count', __('Number count'));
        $form->datetime('close_time', __('Close time'))->default(date('Y-m-d H:i:s'));

        return $form;
    }
}
