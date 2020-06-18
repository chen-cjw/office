<?php

namespace App\Jobs;

use App\Models\WechatPay;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CloseWechatPay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $wechatPay;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WechatPay $wechatPay,$delay)
    {
        $this->wechatPay = $wechatPay;
        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($delay);
    }

    // 定义这个任务类具体的执行逻辑
    // 当队列处理器从队列中取出任务时，会调用 handle() 方法
    public function handle()
    {
        // 判断对应的订单是否已经被支付
        // 如果已经支付则不需要关闭订单，直接退出
        if ($this->wechatPay->paid_at) {
            return;
        }
        // 通过事务执行 sql
        \DB::transaction(function() {
            // 将订单的 closed 字段标记为 true，即关闭订单
            $this->wechatPay->update(['closed' => true]);
        });
    }
}
