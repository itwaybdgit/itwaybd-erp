<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .top_rw {
  background-color: #f4f4f4;
}
.td_w {
}
button {
  padding: 5px 10px;
  font-size: 14px;
}
.invoice-box {
  max-width: 990px;
  margin: auto;
  padding: 10px;
  border: 1px solid #eee;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
  font-size: 14px;
  line-height: 24px;
  font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
  color: #555;
}
.invoice-box table {
  width: 100%;
  line-height: inherit;
  text-align: left;
  border-bottom: solid 1px #ccc;
}
.invoice-box table td {
  padding: 5px;
  vertical-align: middle;
}

.invoice-box table tr.top table td {
  padding-bottom: 20px;
}
.invoice-box table tr.top table td.title {
  font-size: 45px;
  line-height: 45px;
  color: #333;
}
.invoice-box table tr.information table td {
  padding-bottom: 40px;
}
.invoice-box table tr.heading td {
  background: #eee;
  border-bottom: 1px solid #ddd;
  font-weight: bold;
  font-size: 12px;
}
.invoice-box table tr.details td {
  padding-bottom: 20px;
}
.invoice-box table tr.item td {
  border-bottom: 1px solid #eee;
}
.invoice-box table tr.item.last td {
  border-bottom: none;
}
.invoice-box table tr.total td:nth-child(2) {
  border-top: 2px solid #eee;
  font-weight: bold;
}
@media only screen and (max-width: 600px) {
  .invoice-box table tr.top table td {
    width: 100%;
    display: block;
    text-align: center;
  }
  .invoice-box table tr.information table td {
    width: 100%;
    display: block;
    text-align: center;
  }
}
/** RTL **/
.rtl {
  direction: rtl;
  font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial,
    sans-serif;
}
.rtl table {
  text-align: right;
}
.rtl table tr td:nth-child(2) {
  text-align: left;
}

    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
          <tr class="information">
            <td >
              <table>
                <tr>
                  <td style="width: 34%">
                    <img src="{{ asset($business->logo) }}" id="businessInvoiceLogo" width="200px" height="100px" alt="">
                  </td>
                  <td style="width: 33%" style="text-align:center">
                    <b id="businessName" style="font-size : 20px">{{ $business->business_name ?? "" }}</b>
                    <address>
                        Phone : <strong id="businessPhone" >{{ $business->phone ?? $companyInfo->phone }}</strong><br>
                        Address : <strong id="businessAddress" ><em>{{ $business->address ?? $companyInfo->address }}</em></strong><br>
                        Email: <strong id="businessEmail" >{{ $business->email ?? $companyInfo->email }}</strong>
                    </address>
                  </td>
                  <td style="width: 33%" style="text-align:right">
                    <b style="text-decoration: underline">Invoice Info</b><br>
                    Name: {{ $saleinvoiceid->company_name ?? 'N/A' }} -
                    {{ $saleinvoiceid->company_owner_phone ?? 'N/A' }} <br>
                    Address:  House:  {{  $saleinvoiceid->house ?? "" }},  Road: {{$saleinvoiceid->road ?? ""}}, {{ $saleinvoiceid->upazilla->upozilla_name ?? "" }}, {{ $saleinvoiceid->district->district_name ?? "" }}, {{ $saleinvoiceid->division->name ?? "" }} <br>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <td colspan="3">
            <table cellspacing="0px" cellpadding="2px">
              <tr class="heading">
                <td >
                    SL.
                </td>
                <td >
                    Customer
                </td>
                <td >
                    Date
                </td>
                <td >
                    Invoice No
                </td>
                <td style="text-align: center">
                    Head Name
                </td>
                <td style="text-align: center">
                    Remark
                </td>
                <td style="text-align: center">
                    Credit
                </td>
                <td style="text-align: center">
                    Debit
                </td>
                <td style="text-align: center">
                    Balance
                </td>
              </tr>
              @php
              $credit = 0;
              $debit = 0;
              $count = 0;
              $total = 0;
          @endphp
       @if (isset($reseller))
       @foreach ($reseller as $monthl)
           @if ($monthl->account_id !== 5)
               @php($count++)
               <tr class="table_data">
                   <td align="right">
                       <strong>{{ $count }}</strong>
                   </td>
                   {{-- <td>
                       <strong>{{ date('m-Y', strtotime($monthl->billing->date_)) }}</strong>
                   </td> --}}
                   <td>
                       {{ $monthl->resellerCustomer->company_name }}
                   </td>
                   <td>
                       {{ $monthl->created_at }}
                   </td>
                   <td align="right">
                       <strong>{{ $monthl->invoice }}</strong>
                   </td>
                   <td align="right">
                       <strong>{{ $monthl->account->account_name ?? "" }}</strong>
                   </td>
                   <td align="right">
                       <strong>{{ $monthl->remark }}
                           {{ empty($monthl->debit) ? 'Month: ' . $monthl->resellerBill->billing_month : '' }}</strong>
                   </td>
                   <?php
                   $credit += $monthl->credit;
                   $debit += $monthl->debit;
                   $total += $monthl->credit;
                   $total -= $monthl->debit;
                   ?>
                   <td align="right">
                       {{ $monthl->credit }}
                   </td>
                   <td align="right">
                       {{ $monthl->debit }}
                   </td>
                   <td align="right">
                       {{ $total }}
                   </td>
               </tr>
           @endif
       @endforeach
   @else
       <tr>
           <td colspan="9" class="text-center">No Data Found</td>
       </tr>
   @endif
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Total</th>
            <th>{{$credit}}</th>
            <th>{{$debit}}</th>
            <th>{{$total}}</th>
          </tr>
          </td>
        </table>
        {{-- <tr class="total">
          <td colspan="3" align="right"> Total Amount in Words : <b> {{ ucfirst(\Terbilang::make($total)) }} </b> </td>
        </tr> --}}
        <tr>
          <td colspan="3">
            <table cellspacing="0px" cellpadding="2px">

              <tr>
                <td width="50%">
                  <b> Received by:_____________ </b>
                  <br>
                  <br>
                </td>
                <td width="50%">
                  <b> Authorized by:________________ </b>
                  <br>
                  <br>
                </td>
              </tr>
            </table>
          </td>
        </tr>
        </table>
      </div>
</body>
</html>
