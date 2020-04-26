<?php

namespace App\Listeners;

use App\Events\Welfare;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class WelfareListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Welfare  $event
     * @return void
     */
    public function handle(Welfare $event)
    {
        $thisUser = auth('api')->user();
        if($thisUser->is_open == true) {
            if($thisUser->tasks()->where('status',Task::REFUND_END)->count() == $thisUser->sendInviteSet->requirement) {
                // todo 可能没有团队，没有团队就不加
                $addTime = Carbon::parse(User::findOrFail($thisUser->parent_id)->team->close_time)->addDays($thisUser->sendInviteSet->day);
                $teamMember = TeamMember::where('user_id',$thisUser->parent_id)->first();
                if($teamMember) {
                    Team::findOrFail($teamMember->team_id)->update(['close_time'=>$addTime]);
                }
            }
        }
        Log::info($thisUser);
    }
}
