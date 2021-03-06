<?php

namespace App\Admin\Controllers;

use App\Models\TeamMember;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeamMemberController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '团队成员';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TeamMember());

        $grid->column('id', __('Id'));
        $grid->column('user.phone', __('团队成员'));
        $grid->column('team.name', __('所属团队'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        $grid->filter(function($filter){
            // 在这里添加字段过滤器
            $filter->scope('team')->whereHas('name', function ($query) {
                $query->whereNotNull('address');
            });
            $filter->where(function ($query) {

                $query->whereHas('team', function ($query) {
                    $query->where('name', $this->input);
                });

            }, '所属团队');
            $filter->equal('team_id', '团队ID');
        });
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
        $show = new Show(TeamMember::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('team_id', __('Team id'));
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
        $form = new Form(new TeamMember());

        $form->number('user_id', __('User id'));
        $form->number('team_id', __('Team id'));
        $form->text('status', __('Status'));

        return $form;
    }
}
