<?php

namespace App\Admin\Controllers;

use App\Models\WechatPay;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class WechatPayController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new WechatPay());
        // 只展示已支付的订单，并且默认按支付时间倒序排序
        $grid->model()->whereNotNull('paid_at')->orderBy('paid_at', 'desc');

        $grid->column('id', __('Id'));
        $grid->column('user.nickname', __('用户昵称'));
        $grid->column('user.phone', __('用户手机号'));
        $grid->column('number', __('人数'));
        $grid->column('day', __('年'));
        $grid->column('body', __('通知标题'));
        $grid->column('detail', __('详细描述'));
        $grid->column('out_trade_no', __('商户订单号'));
        $grid->column('total_fee', __('支付金额/分'));
        $grid->column('status', __('支付状态'));
        $grid->status('支付状态')->display(function($value) {
            return WechatPay::$refundStatusMap[$value];
        });
        $grid->column('paid_at', __('支付时间'));
        $grid->column('payment_no', __('支付平台订单号'));
//        $grid->column('refund_status', __('Refund status'));
//        $grid->column('refund_no', __('Refund no'));
        $grid->column('closed', __('订单是否已关闭'));
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
        $show = new Show(WechatPay::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('number', __('Number'));
        $show->field('day', __('Day'));
        $show->field('body', __('Body'));
        $show->field('detail', __('Detail'));
        $show->field('out_trade_no', __('Out trade no'));
        $show->field('user_id', __('User id'));
        $show->field('total_fee', __('Total fee'));
        $show->field('status', __('Status'));
        $show->field('paid_at', __('Paid at'));
        $show->field('payment_no', __('Payment no'));
        $show->field('refund_status', __('Refund status'));
        $show->field('refund_no', __('Refund no'));
        $show->field('closed', __('Closed'));
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
        $form = new Form(new WechatPay());

        $form->number('number', __('Number'));
        $form->number('day', __('Day'));
        $form->text('body', __('Body'));
        $form->text('detail', __('Detail'));
        $form->text('out_trade_no', __('Out trade no'));
        $form->number('user_id', __('User id'));
        $form->decimal('total_fee', __('Total fee'));
        $form->text('status', __('Status'))->default('unpaid');
        $form->datetime('paid_at', __('Paid at'))->default(date('Y-m-d H:i:s'));
        $form->text('payment_no', __('Payment no'));
        $form->text('refund_status', __('Refund status'))->default('pending');
        $form->text('refund_no', __('Refund no'));
        $form->switch('closed', __('Closed'));

        return $form;
    }
}
