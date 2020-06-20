## horizon 可视化页面地址 horizon/dashboard

## Laravel Framework 6.18.2
## 项目部署
- php artisan key:generate
- php artisan jwt:secret
- 配置数据库
- php artisan migrate 
- php artisan db:seed

## https://packagist.org/ 依赖包
- 跨源资源共享 composer require fruitcake/laravel-cors  | 全局
- 样式输出统一 liyu/dingo-serializer-switch
## jwt 
- composer require tymon/jwt-auth
- php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
- php artisan jwt:secret



## 个人中心 Versions: CURRENT
URL
https://documenter.getpostman.com/view/11004805/Szf53916


## 任务流程 Versions: CURRENT
URL
https://documenter.getpostman.com/view/11004805/Szf539Ji


## 创建任务 Versions: CURRENT
URL
https://documenter.getpostman.com/view/11004805/Szf539Jj


## 团队 Versions: CURRENT
URL
https://documenter.getpostman.com/view/11004805/Szf539Jm

## 评论 Versions: CURRENT
URL
https://documenter.getpostman.com/view/11004805/Szf539Jo

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## 支付流程
- 参数链接: https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_1
1、扫码支付
	根据商品信息生成二维码 -> 贴到某个位置 -> 用户扫码 -> wechat -> notify (openid+商品信息) -> 下单 + 创建微信订单 -> 返回给微信 prepay_id -> 付款
2、其他支付
	网站下单 -> 创建微信订单 -> 微信 prepay_id -> 呼起支付(JSSDK,APP) -> 付款 -> notify

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## 
##1.使用redis,安装官方推荐扩展包(predis/predis )
- composer require predis/predis

##2.修改.env配置

- QUEUE_CONNECTION=redis

##3.config/database.php
//可修改options.prefix 区分不同项目redis前缀
 'redis' => [

        'client' => env('REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'predis'),
            'prefix' => Str::slug(env('APP_NAME', 'laravel'), '_').'_database_',
        ],

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ],

        'cache' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_CACHE_DB', 1),
        ],

    ],
##4.创建队列任务


- php artisan make:job CloseWechatPay

##5.修改队列任务逻辑

 protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order,$delay)
    {
        $this->order = $order;
        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($delay);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 判断对应的订单是否已经被支付
        // 如果已经支付则不需要关闭订单，直接退出
        if ($this->order->is_pay != 0) {
            return;
        }
        // 通过事务执行 sql
        \DB::transaction(function() {
            // 将订单的 closed 字段标记为 true，即关闭订单
            $this->order->update(['is_pay' => 3,'remark'=>'订单关闭']);
        });
    }
    
##6.调用队列任务

            $order = Order::create($data);
            $this->dispatch(new CloseWechatPay($order,30*60));
##7.ubuntu 安装守护进程

- sudo apt-get install supervisor

##8.在/etc/supervisor/conf.d目录下创建 队列任务配置文件

- touch closeWechatPay.conf

##9.修改配置文件

[program:closeWechatPay]
process_name=%(program_name)s_%(process_num)02d
command=/usr/local/php72/bin/php(php根目录) /data/wwwroot/xyk.topyee.top/ZujiPHP(项目根目录)/artisan queue:work  --tries=3
autostart=true
autorestart=true
user=root
numprocs=8
redirect_stderr=true
stdout_logfile=/var/log/supervisor/laravel-queue.log


##10.启动supervisor

- sudo supervisorctl reread
- sudo supervisorctl update
- sudo supervisorctl start closeWechatPay:*

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License
1、我邀请了某个老板加入，那他创建团队以后有没有免费的团队使用人数和使用的期限
2、我现在是老板，我加入了某个团队，那我还可以去创建自己的团队吗
3、一个人可以创建多个团队吗，一个人可以可以参加多个团队吗

1、每个人只能参加一个团队，
2、参加了团队就不可以去创建团队，
3、每个用户只可以创建一个团队，只要是冻结了某个人的账号，这个用户就依旧不可以参加别人的团队，除非删除了他
数据库名：office_com

用户：office_com

密码：kHPEjecwpCPpEKAD