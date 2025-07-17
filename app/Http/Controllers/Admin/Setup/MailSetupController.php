<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MailSetupController extends Controller
{
    /**
     * String property
     */
    protected $routeName =  'mailer';
    protected $viewName =  'admin.pages.companies';

    protected function getModel()
    {
        return new Company();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Mail Setup";
        $page_heading = "Mail Setup";
        $store_url = route($this->routeName . '.store');
        return view($this->viewName . '.mailor', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Update the environment variables
        $envFile = base_path('.env');

        // Read the current contents of the .env file
        $contents = file_get_contents($envFile);

        // Define the new values for environment variables
        $mailMailer = $request->input('MAIL_MAILER');
        $mailHost = $request->input('MAIL_HOST');
        $mailPort = $request->input('MAIL_PORT');
        $mailUsername = $request->input('MAIL_USERNAME');
        $mailPassword = '"'.$request->input('MAIL_PASSWORD').'"';
        $mailEncryption = $request->input('MAIL_ENCRYPTION');

        // Replace the existing values with the new values
        $contents = preg_replace('/MAIL_MAILER=.*/', "MAIL_MAILER=$mailMailer", $contents);
        $contents = preg_replace('/MAIL_HOST=.*/', "MAIL_HOST=$mailHost", $contents);
        $contents = preg_replace('/MAIL_PORT=.*/', "MAIL_PORT=$mailPort", $contents);
        $contents = preg_replace('/MAIL_USERNAME=.*/', "MAIL_USERNAME=$mailUsername", $contents);
        $contents = preg_replace('/MAIL_PASSWORD=.*/', "MAIL_PASSWORD=$mailPassword", $contents);
        $contents = preg_replace('/MAIL_ENCRYPTION=.*/', "MAIL_ENCRYPTION=$mailEncryption", $contents);

        // Write the updated contents back to the .env file
        file_put_contents($envFile, $contents);

        // Return a response
        return back()->with('success', 'Mail Setup Successfully');
    }


   //

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Company $company)
    {
        $modal_title = 'Company Details';
        $modal_data = $company;
        $html = view($this->viewName . '.show', get_defined_vars())->render();
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $page_title = "Company Edit";
        $page_heading = "Company Edit";
        $back_url = route($this->routeName . '.index');
        $update_url = route($this->routeName . '.update', $company->id);
        $editinfo = $company;
        return view($this->viewName . '.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $valideted = $this->validate($request, [
            "logo" => ['image'],
            "favicon" => ['image'],
            "invoice_logo" => ['image'],
            "company_name" => ['string'],
            "website" => ['string'],
            "phone" => ['string'],
            "email" => ['email'],
            "address" => ['string'],
            "url" => ['string'],
            "apikey" => ['string'],
            "secretkey" => ['string'],
            "account_info" => ['string', 'nullable'],
            "mobile_banking" => ['string', 'nullable'],
            "prefix" => ['string', 'nullable'],
            "create_msg" => ['string', 'nullable'],
            "billing_exp_msg" => ['string', 'nullable'],
            "bill_paid_msg" => ['string', 'nullable'],
            "bill_exp_warning_msg" => ['string', 'nullable']
        ]);
        // dd($valideted);
        try {
            DB::beginTransaction();

            if ($request->hasFile('logo')) {
                if ($company->logo) {
                    Storage::disk('public')->delete($company->logo);
                }
                $path =  $request->file('logo')->store('compnay', 'public');
                $valideted['logo'] = $path;
            }
            if ($request->hasFile('favicon')) {
                if ($company->favicon) {
                    Storage::disk('public')->delete($company->favicon);
                }
                $path =  $request->file('favicon')->store('compnay', 'public');
                $valideted['favicon'] = $path;
            }
            if ($request->hasFile('invoice_logo')) {
                if ($company->invoice_logo) {
                    Storage::disk('public')->delete($company->invoice_logo);
                }
                $path =  $request->file('invoice_logo')->store('compnay', 'public');
                $valideted['invoice_logo'] = $path;
            }

            $valideted['update_by'] = auth()->id();
            $company->update($valideted);

            DB::commit();
            return back()->with('success', 'Data Updated Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('failed', 'Oops! Something was wrong. Message: ' . $e->getMessage() . ' Line: ' . $e->getLine() . 'File: ' . $e->getFile());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return back()->with('success', 'Data deleted successfully.');
    }
}
