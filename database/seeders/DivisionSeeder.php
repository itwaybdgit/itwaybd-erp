<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $divisions = [
            [ 'name' => 'DHAKA', 'details' => 'DHAKA DIVISION' ],
            [ 'name' => 'RAJSHAHI', 'details' => 'RAJSHAHI DIVISION' ],
            [ 'name' => 'CHATTOGRAM', 'details' => 'CHATTOGRAM DIVISION' ],
            [ 'name' => 'KHULNA', 'details' => 'KHULNA DIVISION' ],
            [ 'name' => 'BARISHAL', 'details' => 'BARISHAL DIVISION' ],
            [ 'name' => 'SYLHET', 'details' => 'SYLHET DIVISION' ],
            [ 'name' => 'RANGPUR', 'details' => 'RANGPUR DIVISION' ],
            [ 'name' => 'MYMENSINGH', 'details' => 'MYMENSINGH DIVISION' ],
        ];
        foreach ( $divisions as $division ) {
            Division::create($division);
        }
    }
}
