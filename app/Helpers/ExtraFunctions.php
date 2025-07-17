<?php

use App\Events\RequestNotification;
use App\Helpers\Billing as HelpersBilling;
use App\Mail\Notification as MailNotification;
use App\Models\Billing;
use App\Models\Company;
use App\Models\Employee;
use App\Models\LeadGeneration;
use App\Models\Notification;
use App\Models\SupportCategory;
use App\Models\SupportTicket;
use App\Models\Tj;
use App\Models\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

if (!function_exists('format_bytes')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
    function format_bytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' kbps', ' Mbps', ' Gbps', ' Tbps');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }
}

if (!function_exists('getFileIcon')) {
    function getFileIcon($filePath)
    {
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileExtension), $imageExtensions)) {
            // Return image tag for image files
            return '<img src="' . $filePath . '" alt="Image" style="width: 50%; height: auto;">';
        }

        // Return appropriate icon for non-image files
        switch ($fileExtension) {
            case 'pdf':
                return '<i class="fas fa-file-pdf"></i>';
            case 'doc':
            case 'docx':
                return '<i class="fas fa-file-word"></i>';
            case 'zip':
            case 'rar':
                return '<i class="fas fa-file-archive"></i>';
            default:
                return '<i class="fas fa-file"></i>';
        }
    }
}

if (!function_exists('notifications')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
     function notifications(array $to, $form,$name,$mess,$subject)
    {
        Mail::to($to)->send(new MailNotification($form,$name,$mess,$subject));
    }
}

if (!function_exists('teamcount')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
     function teamcount($employee , $date = null)
    {
       $lead = LeadGeneration::where("created_by",$employee);
       if($date){
           $lead =  $lead->whereDate('created_at',$date);
       }
      return  $lead->pluck("id");
    }
}

if (!function_exists('notifications_store')) {

    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */

     function notifications_store($userid,$message,$link)
    {
        try {
            DB::beginTransaction();

            $data =  Notification::create([
                "user_id" => $userid,
                "message" => $message,
                "link" => $link
            ]);

            event(new RequestNotification($data));
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }

    }
}

if (!function_exists('customer_ticket_count')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */

     function customer_ticket_count($status = null,$userid = 0)
    {
       $data = new SupportTicket;
       if($status){
           $data = $data->where('status',$status);
        }
       if($userid){
           $data = $data->where('client_id',$userid);
       }

       $data = $data->count();
       return $data;
    }
}

if (!function_exists('ticket_count')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */

     function ticket_count($status = null,$userid = 0)
    {
       $data = new SupportTicket;
       if($status){
           $data = $data->where('status',$status);
        }
       if($userid){
           $data = $data->where('assign_to',$userid);
       }

       $data = $data->count();
       return $data;
    }
}

if (!function_exists('cateogry_type_count')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */

     function cateogry_type_count($status = null,$userid = 0)
    {
       $data = new SupportTicket();
       if($status){
           $data = $data->where('problem_category',$status);
        }
       if($userid){
           $data = $data->where('assign_to',$userid);
       }

       $data = $data->count();
       return $data;
    }
}

if (!function_exists('ticket_count_by_column')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */

     function ticket_count_by_column($column_value)
    {
       $data = new SupportTicket;
       if($column_value){
           $data = $data->where($column_value);
        }
       $data = $data->count();
       return $data;
    }
}

if (!function_exists('setNotification')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
     function setNotification($access,$message,$link = "#")
    {
        if(isset(auth()->user()->employee) || auth()->guard('bandwidthcustomer')->check()){
            $user = auth()->user()->employee ?? auth()->guard('bandwidthcustomer')->user()->kam;
           $email = [];
           $departments = $user->departments->name ?? "";
           $form = $user->email;
           $name = $user->name;
           $mess = "";
           $notification = "Notification from " .$name ;

            if($access == "team_leader"){
                $employees = Employee::where('team',$user->teams->id ?? 0)->where('type','LIKE', "%$access%")->get();
                $mess = $message. " from " . $name . "(".$departments.")";
                foreach($employees as $employee){
                    notifications_store($employee->user_id,$mess,$link);
                    array_push($email,$employee->email);
                }
            }else{
                $employees = Employee::where('type','LIKE', "%$access%")->get();
                if($access == "legal_department") $mess = $message. " from " . $name . "(".$departments.")";
                elseif($access == "billing_department") $mess = $message. " from " . $name . "(".$departments.")";
                elseif($access == "tx_planning") $mess = $mess = $message. " from " . $name . "(".$departments.")";
                elseif($access == "transmission") $mess = $mess = $message. " from " . $name . "(".$departments.")";
                elseif($access == "level_1") $mess = $message. " from " . $name . "(".$departments.")";
                elseif($access == "level_2") $mess = $message. " from " . $name . "(".$departments.")";
                elseif($access == "level_3") $mess = $message. " from " . $name . "(".$departments.")";
                elseif($access == "level_4") $mess = $message. " from " . $name . "(".$departments.")";

                foreach($employees as $employee){
                    notifications_store($employee->user_id,$mess,$link);
                    array_push($email,$employee->email);
                }
            }

            notifications($email,$form,$name,$mess,$notification);
        }
    }
}

if (!function_exists('check_access')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
    function check_access($access, $who = null)
    {
        $who = auth()->user()->id;
       if($who){
        $who = $who;
       }
       $user = User::find($who);
       if($user->employee){
           $implode = explode(',',$user->employee->type ?? "");
           if(in_array($access,$implode)){
               return true;
           }
       }
       return false;
    }
}

if (!function_exists('under_team_leader')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
    function under_team_leader($who = 0)
    {
        $who = auth()->user()->id;
        if($who){
         $who = $who;
        }

       $user = User::find($who);

       $employee = Employee::where('team',$user->employee->teams->id)->pluck('user_id')->toArray();
       return $employee;
    }
}

if (!function_exists('has_route')) {
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
    function has_route($route)
    {
       $routelist = auth()->user()->rollaccess->child_id;
       $arrayroute = explode(',', $routelist ?? "") ?? [];
       $status = in_array($route,$arrayroute);
       return $status;
    }
}

if (!function_exists('invoiceNumber')) {
    /**
     *
     * @return integer
     */
    function invoiceNumber($id)
    {

        $purchaseLastData = Billing::find($id);
        if ($purchaseLastData) :
            $purchaseData = $purchaseLastData->id;
        else :
            $purchaseData = 1;
        endif;
        $invoice_no = 'BV' . str_pad($purchaseData, 5, "0", STR_PAD_LEFT);

        return $invoice_no;
    }
}

if (!function_exists('sendSms')) {
    /**
     *
     * @return integer
     */
    function sendSms($number, $message)
    {
        $company = Company::first();
        $url = $company->url;

        $data = [
            "apiKey" => $company->apikey,
            "contactNumbers" => $number,
            "senderId" => $company->secretkey,
            "textBody" => $message
        ];

        $lool = null;
        if (!empty($company->secretkey)) {
            $lool = Http::post($url, $data);
        }
        return $lool;
    }
}

if (!function_exists('monthlyStartSms')) {
    /**
     *
     * @return integer
     */
    function monthlyStartSms($number, $message)
    {
        $company = Company::first();
        $url = $company->url;
        $data = [
            "apiKey" => $company->apikey,
            "contactNumbers" => $number,
            "senderId" => $company->secretkey,
            "textBody" => $message
        ];
        $response = null;
        if (!empty($company->secretkey)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);
            echo "$response";
            curl_close($ch);
        }
        return $response;
    }
}

if (!function_exists('upload_file')) {
    /**
     *
     *  @return integer
     */
    function upload_file($req, $name ,$filename = "file")
    {
        $path = "";
        if ($req->hasFile($name)) {
            $image = $req->file($name);
            $imageName = time() ."_". $image->getClientOriginalName(); // Obtenez le nom d'origine du fichier
            $image->storeAs('public/uploads/'.$filename, $imageName); // Stockez l'image dans public/images
            $path ="/uploads/$filename/$imageName";
        }
        return $path;
    }
}

if (!function_exists('messageconvert')) {
    /**
     *
     * @return integer
     */
    function messageconvert($customer, $message)
    {
        $explode = explode(" ", $message);
        $clientid = array_search("%clientid%", $explode);
        $username = array_search("%username%", $explode);
        $clientname = array_search("%clientname%", $explode);
        $password = array_search("%password%", $explode);
        $monthlybill = array_search("%monthlybill%", $explode);
        $expdate = array_search("%expdate%", $explode);
        $duebill = array_search("%duebill%", $explode);
        $link = array_search("%link%", $explode);
        $monthname = array_search("%monthname%", $explode);

        if ($clientid) {
            $explode[$clientid] = $customer->client_id;
        }

        if ($username) {
            $explode[$username] = $customer->username;
        }

        if ($password) {
            $explode[$password] = $customer->m_password;
        }

        if ($clientname) {
            $explode[$clientname] = $customer->name;
        }

        if ($monthlybill) {
            $explode[$monthlybill] = $customer->bill_amount;
        }

        if ($monthname) {
            $explode[$monthname] = date("M", strtotime($customer->date_));
        }

        if ($expdate) {
            $explode[$expdate] = date('d-m-Y', strtotime($customer->exp_date));
        }

        if ($duebill) {
            $billings = Billing::where('customer_id', $customer->id)->where('status', '!=', 'paid')->get();
            // $billings = Billing::where('customer_id', $customer->id)->whereMonth('date_', '!=', date('m'))->whereYear('date_', date('Y'))->where('status', '!=', 'paid')->get();
            $total = 0;
            foreach ($billings as $billing) {
                $total += $billing->customer_billing_amount - $billing->pay_amount;
            }

            $explode[$duebill] = $total;
        }

        if ($link) {
            $billings = Billing::where('customer_id', $customer->id)->where('status', '!=', 'paid')->whereMonth('date_',date('m'))->first();
            if($billings){
                $route = route('invoice.payment',['INV'.rand(1111111&111,999999999999), $billings->id]);
            }else{
                $route = "";
            }
            $explode[$link] = $route;
        }

        $implode = implode(" ", $explode);

        return $implode;
    }
}
