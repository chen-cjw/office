<?php

namespace App\Admin\Controllers;

use App\Models\SendInviteSet;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('avatar', __('Avatar'))->image('','35','35');
        //$grid->column('unionid', __('Unionid'));
        //$grid->column('wx_openid', __('Wx openid'));
        $grid->column('ml_openid', __('Ml openid'));
        $grid->column('phone', __('Phone'));
        $grid->column('nickname', __('Nickname'));
        $grid->column('sex', __('Sex'))->display(function ($sex) {
            return $sex == 1 ? '男' : '女';
        });
        $grid->column('send_invite_set_id', __('邀请老板/同事'))->display(function ($send_invite_set_id) {
            return $send_invite_set_id==1 ? '同事' : '老板';
        });;
        $grid->column('parent_id', __('Parent id'))->display(function ($parent_id) {
            return $parent_id==0 ? '暂无' : $parent_id;
        });
        $grid->column('is_open', __('Is open'))->display(function ($open) {
            return $open == 1 ? '是' : '否';
        });
        $grid->column('status', __('Status'))->display(function ($statusColumn) {
            return User::$status[$statusColumn];
        });
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('unionid', __('Unionid')); // 多方唯一标识
        $show->field('wx_openid', __('Wx openid'));
        $show->field('ml_openid', __('Ml openid'));
        $show->field('phone', __('Phone'));
        $show->field('avatar', __('Avatar'))->image();
        $show->field('nickname', __('Nickname'));
        $show->field('sex', __('Sex'));
        $show->field('send_invite_set_id', __('Send invite set id'));
        $show->field('parent_id', __('Parent id'));
        $show->field('is_open', __('Is open'));
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
        $form = new Form(new User());

        $form->text('unionid', __('Unionid'));
        $form->text('wx_openid', __('Wx openid'));
        $form->text('ml_openid', __('Ml openid'));
        $form->mobile('phone', __('Phone'));
        $form->image('avatar', __('Avatar'));
        $form->text('nickname', __('Nickname'));
        $form->switch('sex', __('Sex'));
        $form->select('send_invite_set_id', __('Send invite set id'))->options(SendInviteSet::pluck('name','id'));
        //$form->number('parent_id', __('Parent id'));
        $form->switch('is_open', __('Is open'));
        $form->select('status', __('Status'))->default('wait')->options([
            'administrator'=>'超级管理员',
            'admin'=>'管理员',
            'member'=>'成员',
            'freeze'=>'冻结账号',
            'wait'=>'等待审核',
        ]);

        return $form;
    }
}
