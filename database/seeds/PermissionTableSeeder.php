<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = array(
            'Business Setup',

            'Sales List',
            'Sales Invoice',
            'Sales Create',
            'Sales Edit',
            'Sales Delete',

            'Quotations List',
            'Draft List',
            'Pending List',
            'Order List',

            'Purchase List',
            'Purchase Invoice',
            'Purchase Create',
            'Purchase Edit',
            'Purchase Delete',

            'Product List',
            'Product Create',
            'Product Edit',
            'Product Delete',

            'Stock Adjustment List',
            'Stock Adjustment Create',
            'Stock Adjustment Edit',
            'Stock Adjustment Delete',

            'Product Category List',
            'Product Category Create',
            'Product Category Edit',
            'Product Category Delete',

            'Product Units List',
            'Product Units Create',
            'Product Units Edit',
            'Product Units Delete',

            'Product Company List',
            'Product Company Create',
            'Product Company Edit',
            'Product Company Delete',
            'Product Transaction',

            'Product Brand List',
            'Product Brand Create',
            'Product Brand Edit',
            'Product Brand Delete',

            'Customer List',
            'Customer Transaction',
            'Customer Payment',
            'Customer Create',
            'Customer Edit',
            'Customer Delete',

            'Agent List',
            'Agent Create',
            'Agent Edit',
            'Agent Delete',

            'District List',
            'District Create',
            'District Edit',
            'District Delete',

            'SubDistrict List',
            'SubDistrict Create',
            'SubDistrict Edit',
            'SubDistrict Delete',

            'Customer Category List',
            'Customer Category Create',
            'Customer Category Edit',
            'Customer Category Delete',

            'Supplier List',
            'Supplier Transaction',
            'Supplier Payment',
            'Supplier Create',
            'Supplier Edit',
            'Supplier Delete',

            'Supplier Category List',
            'Supplier Category Create',
            'Supplier Category Edit',
            'Supplier Category Delete',

            'Accounts List',
            'Accounts Transaction',
            'Accounts Create',
            'Accounts Edit',
            'Accounts Delete',

            'Transaction Create',
            'Transaction Edit',

            'Balance Sheet View',
            'Trial Balance View',
            'Cash Flow View',

            'Reports Generate',

            'Expense List',
            'Expense Create',
            'Expense Edit',
            'Expense Delete',

            'Expense Category List',
            'Expense Category Create',
            'Expense Category Edit',
            'Expense Category Delete',

            'Role List',
            'Role Create',
            'Role Edit',
            'Role Delete',
            'Role Permission',

            'User List',
            'User Create',
            'User Edit',
            'User Delete',

            'Warehouse List',
            'Warehouse Create',
            'Warehouse Edit',
            'Warehouse Delete',

            'Discount List',
            'Discount Create',
            'Discount Edit',
            'Discount Delete',

            'Vat List',
            'Vat Create',
            'Vat Edit',
            'Vat Delete',

            'Shipment List',
            'Shipment Create',
            'Shipment Edit',
            'Shipment Delete',

            'Zone List',
            'Zone Create',
            'Zone Edit',
            'Zone Delete'
        );


        //Role::create(['name' => 'Super Admin']); //Create Super Admin By default

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
