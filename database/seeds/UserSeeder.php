<?php

use App\User;
use Carbon\Carbon;
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
        //this is for root user creation
        $user = new User();
        $user->username = "raghu22";
        $user->first_name = "Raghunath";
        $user->last_name = "Bhattcharjee";

        $user->status = true;
        $user->user_type = User::ROOT_USER;

        $user->email = "raghu@gmail.com";
        $user->password = bcrypt('123456');
        $user->email_verified_at = Carbon::now();

        $user->save();
    }
}
