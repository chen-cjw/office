<?php

function array_get($array, $key, $default = null)
{
    if (is_null($key)) {
        return $array;
    }

    if (isset($array[$key])) {
        return $array[$key];
    }

//    foreach (explode(‘.‘, $key) as $segment) {
    foreach (explode('.', $key) as $segment) {
        if (! is_array($array) || ! array_key_exists($segment, $array)) {
            return value($default);
        }

        $array = $array[$segment];
    }
    return $array;
}

// 订单支付成功通知 1
function order_wePay_success_notification($receiver,$payment_no,$paid_at,$total_fee,$body,$remark)
{
    $data = [
        'template_id' => config('app.order_wePay_success_notification'), // 所需下发的订阅模板id
        'touser' => $receiver,     // 接收者（用户）的 openid
        'page' => '/pages/task/task',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
        'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
            'character_string1' => [ //订单编号
                'value' => $payment_no,
            ],
            'time2' => [ // 支付时间
                'value' => $paid_at,
            ],
            'amount8' => [ // 支付金额
                'value' => $total_fee,
            ],
            'thing4' => [ // 商品名称
                'value' => $body,
            ],
            'thing6' => [ // 备注
                'value' => $remark,
            ],
        ],
    ];
    $app = app('wechat.mini_program');
    $res = $app->subscribe_message->send($data);
    if (!empty($res['errcode'])) {
        throw new \Dingo\Api\Exception\ResourceException($res['errcode'].','.$res['errmsg']);
    }
}

// 服务到期提醒 2
function service_due($receiver,$service_name,$due_time,$tip)
{
    $data = [
        'template_id' => config('app.service_due'), // 所需下发的订阅模板id
        'touser' => $receiver,     // 接收者（用户）的 openid
        'page' => '/pages/task/task',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
        'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
            'thing1' => [ // 服务名称
                'value' => $service_name,
            ],
            'date2' => [ // 到期时间
                'value' => $due_time,
            ],
            'thing3' => [ // 温馨提示
                'value' => $tip,
            ],
        ],
    ];
    $app = app('wechat.mini_program');
    $res = $app->subscribe_message->send($data);
    if (!empty($res['errcode'])) {
        throw new \Dingo\Api\Exception\ResourceException($res['errcode'].','.$res['errmsg']);
    }
}

// 新评论回复通知 3
function new_comment_reply($receiver,$replying_person,$time,$content,$remark)
{
    $data = [
        'template_id' => config('app.new_comment_reply'), // 所需下发的订阅模板id
        'touser' => $receiver,     // 接收者（用户）的 openid
        'page' => '/pages/task/task',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
        'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
            'thing1' => [ // 回复人
                'value' => $replying_person,
            ],
            'time2' => [ // 回复时间
                'value' => $time,
            ],
            'thing4' => [ // 评论内容
                'value' => $content,
            ],
            'thing3' => [ // 备注
                'value' => $remark,
            ],
        ],
    ];
    $app = app('wechat.mini_program');
    $res = $app->subscribe_message->send($data);
    if (!empty($res['errcode'])) {
        throw new \Dingo\Api\Exception\ResourceException($res['errcode'].','.$res['errmsg']);
    }
}

// 新的协同提醒 4
function new_synergy($receiver,$title,$created_at,$close_time)
{
    $data = [
        'template_id' => config('app.new_synergy'), // 所需下发的订阅模板id
        'touser' => $receiver,     // 接收者（用户）的 openid
        'page' => '/pages/task/task',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
        'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
            'thing1' => [ // 协同标题
                'value' => $title,
            ],
            'time2' => [ // 发布时间
                'value' => $created_at,
            ],
            'time3' => [ // 到期时间
                'value' => $close_time,
            ],
        ],
    ];
    $app = app('wechat.mini_program');
    $res = $app->subscribe_message->send($data);
    if (!empty($res['errcode'])) {
        throw new \Dingo\Api\Exception\ResourceException($res['errcode'].','.$res['errmsg']);
    }
}

// 新用户加入通知 5
function new_user_add($receiver,$name,$phone,$update_time)
{
    $data = [
        'template_id' => config('app.new_user_add'), // 所需下发的订阅模板id
        'touser' => $receiver,     // 接收者（用户）的 openid
        'page' => '/pages/task/task',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
        'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
            'thing1' => [ // 姓名
                'value' => $name,
            ],
            'phone_number2' => [ // 联系方式
                'value' => $phone,
            ],
            'time3' => [ // 加入时间
                'value' => $update_time,
            ],
        ],
    ];
    $app = app('wechat.mini_program');
    $res = $app->subscribe_message->send($data);
    if (!empty($res['errcode'])) {
        throw new \Dingo\Api\Exception\ResourceException($res['errcode'].','.$res['errmsg']);
    }
}
