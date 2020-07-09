<?php

use Illuminate\Database\Seeder;

class SendInviteSetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(\App\Models\SendInviteSet::class, 2)->create();
        \App\Models\SendInviteSet::create([
            'name' => '同事',
            'day' => 30,
            'requirement' => 10,
        ]);
        \App\Models\SendInviteSet::create([
            'name' => '老板',
            'day' => 30,
            'requirement' => 10,
        ]);
    }
}
