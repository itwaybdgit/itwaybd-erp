<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DistrictSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $districts = [
            ['district_name' => 'Dhaka'],
            ['district_name' => 'Rajshahi'],
            ['district_name' => 'Chattogram'],
            ['district_name' => 'Khulna'],
            ['district_name' => 'Barishal'],
            ['district_name' => 'Sylhet'],
            ['district_name' => 'Rangpur'],
            ['district_name' => 'Mymensingh'],
        ];
        foreach ($districts as $district) {
            $district['company_id'] = 1;
            District::create($district);
        }
    }
}
