<?php

use App\Business;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $table = new Business();
        $table->id = 1;
        $table->name = 'Infinity Flame Soft';
        $table->contact = '01675870047';
        $table->contact_alternate = '01558654525';
        $table->address = 'Rongmohol Tower, Bondor Bazar, Sylhet';
        $table->website = 'www.infinityflamesoft.com';
        $table->proprietor = 'Nazmul Hossain';
        $table->logo = 'logo.png';
        $table->software_key = 'START';
        $table->save();
    }
}
