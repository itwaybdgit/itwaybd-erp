<?php

namespace App\Imports;

use App\Models\ConnectedPath;
use App\Models\District;
use App\Models\Division;
use App\Models\LicenseType;
use App\Models\Upozilla;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BandwidthCustomer implements  ToCollection, WithValidation, SkipsOnError, WithHeadingRow
{
    use Importable, SkipsErrors;

    /**
    * @param Collection $collection
    */

    public function collection(Collection $collection)
    {
        $array=[];
        foreach($collection as $row){

        if (!empty($row['type'])) {
            $connection_type = ConnectedPath::firstOrCreate([
                'name' => $row['type'],
                // 'provider' => json_encode($row['provider']),
                // 'type' => "lb" ,
            ]);
        }
        if (!empty($row['choose_license_type'])) {
            $license_type = LicenseType::firstOrCreate([
                'name' => $row['choose_license_type'],
                // 'provider' => json_encode($row['provider']),
                // 'type' => "lb" ,
            ]);
        }
        if (!empty($row['divishon'])) {
            $divishon = Division::firstOrCreate([
                'name' => $row['divishon'],
            ]);
        }
        if (!empty($row['district'])) {
            $district = District::firstOrCreate([
                'district_name' => $row['district'],
            ]);
        }
        if (!empty($row['upazila_thana'])) {
            $upazila_thana = Upozilla::firstOrCreate([
                'district_id' => $district->id ?? "",
                'upozilla_name' => $row['upazila_thana'],
            ]);
        }
            $array[]=[
             'company_name'=> $row['company_name'],
             'company_owner_name'=> $row['company_owner_name'],
             'company_owner_phone'=> $row['company_owner_phone'],
             'contact_person_name'=> $row['company_name'],
             'contact_person_phone'=> $row['contact_parson_phone'],
             'contact_person_email'=> $row['contact_person_email'],
             'customer_address'=> $row['company_name'],
             'license_type'=> $license_type->id ?? "",
             'division_id'=> $divishon->id ?? "",
             'district_id'=> $district->id ?? "",
             'upazila_id'=> $upazila_thana->id ?? "",
             'road'=> $row['vill_road'],
             'house'=> $row['house'],
             'vat_check'=> "no",
             'latitude'=> $row['latitude'],
             'longitude'=> $row['longitude'],
             'admin_name'=> $row['a_c_name'],
             'admin_designation'=> $row['a_c_designation'],
             'admin_cell'=> $row['a_c_cell'],
             'admin_email'=> $row['a_c_email'],
             'billing_name'=> $row['b_c_name'],
             'billing_designation'=> $row['b_c_designation'],
             'billing_cell'=> $row['b_c_cell'],
             'billing_email'=> $row['b_c_email'],
             'technical_name'=> $row['t_c_name'],
             'technical_designation'=> $row['t_c_designation'],
             'technical_cell'=> $row['t_c_cell'],
             'technical_email'=> $row['t_c_email'],
             'connection_path_id'=> isset($connection_type) ? $connection_type->id : "" ,
             'sales_approve'=> 1,
             'legal_approve'=> 1,
             'transmission_approve'=> 1,
             'noc_approve'=> 1,
             'noc2_approve'=> 1,
             'billing_approve'=> 1,
             'reject_sales_approve'=> 0,
             'reject_legal_approve'=> 0,
             'reject_transmission_approve'=> 0,
             'reject_noc_approve'=> 0,
             'reject_noc2_approve'=> 0,
             'reject_billing_approve'=> 0,
             'level_confirm'=> 2,
             'level_confirm_by'=> 1,
             'sales_approve_by'=> 1,
             'legal_approve_by'=> 1,
             'transmission_approve_by'=> 1,
             'noc_approve_by'=> 1,
             'noc2_approve_by'=> 1,
             'billing_approve_by'=> 1,
             'created_by'=> 1,
             'updated_by'=> 1,
             'approved_by'=> 1,
            ];
        }

        DB::table('bandwidth_customers')->insert($array);
    }

    public function rules(): array
    {
        return [
            // 'username' => [
            //     'required', 'unique',
            // ],
        ];
    }
}
