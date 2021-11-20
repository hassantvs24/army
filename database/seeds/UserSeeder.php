<?php

use App\User;
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
        $table = new User();
        $table->id = 1;
        $table->name = 'Admin';
        $table->email = 'admin@admin.com';
        $table->password = bcrypt(12345678);
        $table->user_type = 'Super Admin';
        $table->business_id = 1;
        $table->save();
    }
}
