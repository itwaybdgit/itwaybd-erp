<?php

namespace Database\Seeders;

use App\Models\Navigation;
use App\Models\RollPermission;
use Illuminate\Database\Seeder;

class NavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        Navigation::truncate();
        $menus = config('navigation');

        $main = array();
        $submain = array();
        foreach ($menus as $key => $menu) {
            if (isset($menu['submenu']) && count($menu['submenu']) > 0) {
                foreach ($menu['submenu'] as $index => $submenu) {

                    array_push($submain, $submenu['route']);
                }
            }
            array_push($main, $menu['access']);
        }
        // $parent_id = array_map('array_pop', $main);
        // $child_id = array_map('array_pop', $submain);
        RollPermission::create([
            "name" => "Super Admin",
            "parent_id" => implode(',', $main),
            "child_id" => implode(',', $submain),
        ]);
    }
}
