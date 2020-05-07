<?php
namespace App\Transformers;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\WechatPay;
use League\Fractal\TransformerAbstract;

class WechatPayTransformer extends TransformerAbstract
{

    public function transform(WechatPay $wechatPay)
    {
        return [
            'id' => $wechatPay->id,
            'number' => $wechatPay->number,//人数
            'day' => $wechatPay->day,//天数
            'body' => $wechatPay->body,//描述==通知标题
            'detail' => $wechatPay->detail,//详细描述
            'out_trade_no' => $wechatPay->out_trade_no,//商户订单号
            'total_fee' => $wechatPay->total_fee,//支付金额/分
            'status' => $wechatPay->status,//支付状态[unpaid未支付,paid已支付,close关闭,delete删除,paid_fail支付失败]
            'paid_at' => $wechatPay->paid_at,//支付时间
            'created_at' => $wechatPay->created_at->toDateTimeString(),
            'updated_at' => $wechatPay->updated_at->toDateTimeString(),
        ];
    }

    public function includeUser(Team $team)
    {
        return $this->item($team->user,new UserTransformer());
    }

    public function includeMembers(Team $team)
    {
        return $this->collection($team->members,new TeamMemberTransformer());
    }



}