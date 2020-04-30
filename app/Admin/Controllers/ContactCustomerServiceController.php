<?php

namespace App\Admin\Controllers;

use App\Models\ContactCustomerService;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class ContactCustomerServiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '联系客服';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ContactCustomerService());

        $grid->column('id', __('Id'));
        $grid->column('content', __('Content'))->display(function ($content) {
            return Str::limit($content, $limit = 500, $end = '...');
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
        $show = new Show(ContactCustomerService::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('content', __('Content'))->unescape();
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
        $form = new Form(new ContactCustomerService());

        $form->UEditor('content', __('Content'));

        return $form;
    }
}
