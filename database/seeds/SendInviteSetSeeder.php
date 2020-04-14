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
        factory(\App\Models\SendInviteSet::class, 2)->create();

    }
}
