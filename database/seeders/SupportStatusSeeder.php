<?php

namespace Database\Seeders;

use App\Models\SupportStatus;
use Illuminate\Database\Seeder;

class SupportStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = [
            [
                'name' => 'Pending',
                'order_id' => 0,
            ],
            [
                'name' => 'Working',
                'order_id' => 0,
            ],

        ];
        SupportStatus::insert($insert);
    }
}
