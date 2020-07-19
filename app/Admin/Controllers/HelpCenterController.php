<?php

namespace App\Admin\Controllers;

use App\Models\HelpCenter;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class HelpCenterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '帮助我们';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HelpCenter());

        $grid->column('id', __('Id'))->sortable();
        $grid->column('content', __('Content'))->display(function ($content) {
            return Str::limit($content, $limit = 500, $end = '...');
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'))->sortable();

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
        $show = new Show(HelpCenter::findOrFail($id));

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
        $form = new Form(new HelpCenter());
        $form->UEditor('content', __('Content'));

        return $form;
    }
}
