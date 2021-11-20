<?php

use App\AccountBook;
use App\Discount;
use App\Shipment;
use App\User;
use App\VetTex;
use App\Warehouse;
use App\Zone;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PreInstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
            'id' => 1,
            'name' => 'Super Admin'
        ]);


        $warehouse = new Warehouse();
        $warehouse->id = 1;
        $warehouse->name = 'Infinity Flame Soft';
        $warehouse->contact = '01675870047';
        $warehouse->contact_alternate = '01558654525';
        $warehouse->address = 'Rongmohol Tower, Bondor Bazar, Sylhet';
        $warehouse->website = 'www.infinityflamesoft.com';
        $warehouse->proprietor = 'Nazmul Hossain';
        $warehouse->logo = 'logo.png';
        $warehouse->business_id = 1;
        $warehouse->users_id = 1;
        $warehouse->save();

        $ac_book = new AccountBook();
        $ac_book->id = 1;
        $ac_book->name = 'General Accounts';
        $ac_book->account_number = '00';
        $ac_book->description = 'Default Account';
        $ac_book->business_id = 1;
        $ac_book->users_id = 1;
        $ac_book->save();


        $user = User::find(1);
        $user->warehouses_id = 1;
        $user->account_books_id = 1;
        $user->save();

        $user->assignRole(1);

        $vet = new VetTex();
        $vet->id = 1;
        $vet->name = 'General';
        $vet->amount = 0;
        $vet->business_id = 1;
        $vet->users_id = 1;
        $vet->save();

        $discount = new Discount();
        $discount->id = 1;
        $discount->name = 'General';
        $discount->amount = 0;
        $discount->warehouses_id = 1;
        $discount->business_id = 1;
        $discount->users_id = 1;
        $discount->save();

        $shipment = new Shipment();
        $shipment->id = 1;
        $shipment->name = 'Normal';
        $shipment->business_id = 1;
        $shipment->users_id = 1;
        $shipment->save();

        $zone = new Zone();
        $zone->id = 1;
        $zone->name = 'Common';
        $zone->business_id = 1;
        $zone->users_id = 1;
        $zone->save();


    }
}
