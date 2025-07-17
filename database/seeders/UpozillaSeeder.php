<?php

namespace Database\Seeders;

use App\Models\Upozilla;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class UpozillaSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $upazillas = [
            [ 'upozilla_name' => 'Mirpur' ],
            [ 'upozilla_name' => 'Uttara' ],
            [ 'upozilla_name' => 'Gulshan' ],
            [ 'upozilla_name' => 'Banani' ],
            [ 'upozilla_name' => 'Badda' ],
            [ 'upozilla_name' => 'Rampura' ],
            [ 'upozilla_name' => 'Dhanmondi' ],
            [ 'upozilla_name' => 'Savar' ],
        ];
        foreach ( $upazillas as $upazilla) {
            $upazilla['district_id'] = 1;
            $upazilla['company_id'] = 1;
            Upozilla::create($upazilla);
        }
    }
}
