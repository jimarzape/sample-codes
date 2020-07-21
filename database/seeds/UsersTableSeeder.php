<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = DB::table('users')->count();
        if($count == 0)
        {
            DB::table('users')->insert([
                'name' => "Sample Admin",
                'email' => 'admin@sample.com',
                'password' => bcrypt('password123'),
            ]); 
        }
    }
}
