<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $company =  Company::create([
            'logo' => '',
            'favicon' => '',
            'invoice_logo' => '',
            'company_name' => 'ITWAYBD',
            'website' => 'itwaybd.com',
            'phone' => '+8801854125454',
            'email' => 'info@itwaybd.com',
            'url' => 'url',
            'apikey' => 'apikey',
            'secretkey' => 'secretkey',
            'address' => 'Uttara',
            'created_by' => '1',
            'updated_by' => '1',
        ]);

        $user = new User();
        $user->name = "ISP";
        $user->email = "info@itwaybd.com";
        $user->username = "crm";
        $user->company_id = $company->id;
        $user->is_admin = 1;
        $user->roll_id = 1;
        $user->password = Hash::make('12345678');
        $user->save();
    }
}
