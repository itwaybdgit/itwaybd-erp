<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $businesses = [
            [
                'logo' => 'business/gmax.jpg',
                'invoice_logo' => 'business/gmax.jpg',
                'business_name' => 'Greenmax Technologies Ltd (Gmax)',
                'website' => 'http://gmaxbd.com/',
                'phone' => '01324741046',
                'email' => 'billing@gmaxbd.com',
                'address' => '4th Floor, 153/1, Shaheed Faruque Road, Jatrabari, Dhaka',
            ],
            [
                'logo' => 'business/skyview.jpg',
                'invoice_logo' => 'business/skyview.jpg',
                'business_name' => 'Skyview Online Ltd',
                'website' => 'https://skyviewonline.com/',
                'phone' => '09614 310 310',
                'email' => 'activation@skyviewonline.com',
                'address' => '2nd Floor, 153/1, Shaheed Faruque Road, Jatrabari, Dhaka',
            ],
            [
                'logo' => 'business/itel.jpg',
                'invoice_logo' => 'business/itel.jpg',
                'business_name' => 'Itel IIG Limited',
                'website' => 'https://iteliig.com/',
                'phone' => '01795206506',
                'email' => 'billing@iteliig.com',
                'address' => 'House # 04 (4th Floor), Road # 16 (Old 27), Dhanmondi, Dhaka-1209, Bangladesh',
            ]
        ];

        foreach ( $businesses as $business ) {
            Business::create($business);
        }
    }
}
