<?php

use App\Models\UserLog;
use Illuminate\Database\Seeder;

class UserLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(UserLog::class, 100000)->create();
    }
}
