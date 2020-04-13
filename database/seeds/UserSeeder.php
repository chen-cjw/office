<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'openid'=>'123123123123',
            'nickname'=>'nickname',
            'sex'=>'sex',
            'language'=>'zh',
            'city'=>'chain',
            'province'=>'jiangsu',
            'country'=>'xuxi',
            'avatar'=>'https://dss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=2471723103,4261647594&fm=26&gp=0.jpg',
//            'unionid'=>'unionid'
        ]);
    }
}
