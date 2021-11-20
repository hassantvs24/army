<?php

use App\Brand;
use App\Customer;
use App\Expense;
use App\ExpenseCategory;
use App\Product;
use App\ProductCategory;
use App\Supplier;
use App\Units;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OldDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$old_table = DB::connection('mysql2')->table('product_brand')->get();

        //$old_table = DB::connection('mysql2')->table('product_category')->get();

        //$old_table = DB::connection('mysql2')->table('products')->get();

        //$old_table = DB::connection('mysql2')->table('customers')->get();

        //$old_table = DB::connection('mysql2')->table('suppliers')->get();

        //$old_table = DB::connection('mysql2')->table('expense')->get();

        /*foreach ($old_table as $row){
            $table = new ExpenseCategory();
            $table->id = $row->expenseID;
            $table->code = mt_rand(1000, 999999);
            $table->name = $row->name;
            $table->business_id = 1;
            $table->users_id = 1;
            $table->save();
        }*/

        /*foreach ($old_table as $row){
            $table = new Supplier();
            $table->id = $row->supplierID;
            $table->code = mt_rand();
            $table->name = $row->name;
            $table->address = $row->address;
            $table->email = $row->email;
            $table->contact = Str::limit($row->contact, 15, '');
            $table->description = $row->description;
            $table->supplier_categories_id = 1;
            $table->warehouses_id = 1;
            $table->business_id = 1;
            $table->users_id = 1;
            $table->save();
        }*/

        /*foreach ($old_table as $row){
            $table = new Customer();
            $table->id = $row->customerID;
            $table->code = mt_rand();
            $table->name = $row->name;
            $table->address = $row->address;
            $table->email = $row->email;
            $table->contact = Str::limit($row->contact, 15, '');
            $table->description = $row->description;
            $table->agent_id = 1;
            $table->zones_id = 1;
            $table->upa_zillas_id = 1;
            $table->zillas_id = 1;
            $table->divisions_id = 5;
            $table->customer_categories_id = 1;
            $table->warehouses_id = 1;
            $table->business_id = 1;
            $table->users_id = 1;
            $table->save();
        }*/

        /*foreach ($old_table as $row){
            $units = Units::where('name', $row->unit)->first();
            $table = new Product();
            $table->id = $row->productID;
            $table->sku = mt_rand();
            $table->name = $row->name;
            $table->sell_price = $row->defaultSellPrice;
            $table->purchase_price = $row->defaultBuyPrice;
            $table->alert_quantity = $row->defaultBuyPrice;
            $table->product_categories_id = $row->productCategoryID;
            $table->brands_id = $row->productBrandID;
            $table->description = $row->description;
            $table->units_id = $units->id;
            $table->business_id = 1;
            $table->users_id = 1;
            $table->save();
        }*/

        /*foreach ($old_table as $row){
            $table = new ProductCategory();
            $table->id = $row->productCategoryID;
            $table->code = mt_rand(1000, 999999);
            $table->name = $row->name;
            $table->business_id = 1;
            $table->users_id = 1;
            $table->save();
        }*/



        /*foreach ($old_table as $row){
            $table = new Brand();
            $table->id = $row->productBrandID;
            $table->name = $row->name;
            $table->business_id = 1;
            $table->users_id = 1;
            $table->save();
        }*/



    }
}
