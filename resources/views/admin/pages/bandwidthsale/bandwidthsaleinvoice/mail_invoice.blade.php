<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .top_rw {
            background-color: #f4f4f4;
        }

        .td_w {}

        button {
            padding: 5px 10px;
            font-size: 14px;
        }

        .invoice-box {
            max-width: 890px;
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
                <td>
                    <table>
                        <tr>
                            <td style="width:33%">
                                <img src="{{ asset("storage/".$business->invoice_logo) }}" id="businessInvoiceLogo" width="200px"
                                    height="100px" alt="">
                            </td>
                            <td style="text-align:center;width:33%">
                                <b id="businessName"> {{ $saleinvoiceid->customer->company_name ?? 'N/A' }}</b> <br>
                                Invoice: {{ $saleinvoiceid->invoice_no ?? 'N/A' }} <br>
                               Phone: {{ $saleinvoiceid->customer->company_owner_phone ?? 'N/A' }} <br>
                                Address: House: {{ $saleinvoiceid->customer->house ?? '' }}, Road:
                                {{ $saleinvoiceid->customer->road ?? '' }},
                                {{ $saleinvoiceid->customer->upazilla->upozilla_name ?? '' }},
                                {{ $saleinvoiceid->customer->district->district_name ?? '' }},
                                {{ $saleinvoiceid->customer->division->name ?? '' }} <br>
                                {{ $saleinvoiceid->billing_month ?? 'N/A' }}
                            </td>
                            <td  style="text-align:right;width:33%">
                                <b  >{{ $business->business_name ?? '' }}</b>
                                <address>
                                    Phone : <strong
                                        id="businessPhone">{{ $business->phone ?? $companyInfo->phone }}</strong><br>
                                    Address : <strong
                                        id="businessAddress"><em>{{ $business->address ?? $companyInfo->address }}</em></strong><br>
                                    Email: <strong
                                        id="businessEmail">{{ $business->email ?? $companyInfo->email }}</strong>
                                </address>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            <td colspan="3">
                <table cellspacing="0px" cellpadding="2px">
                    <tr class="heading">
                        <td>
                            SL
                        </td>
                        <td style="width:15%;">
                            ITEM
                        </td>
                        <td style="width:10%; ">
                            QTY.
                        </td>
                        <td style="width:10%; ">
                            PRICE (INR)
                        </td>
                        <td style="width:15%; ">
                            VAT
                        </td>
                        <td style="width:15%; ">
                            FROM DATE
                        </td>
                        <td style="width:15%; ">
                            TO DATE
                        </td>
                        <td style="width:15%; ">
                            TOTAL
                        </td>
                    </tr>
                    @php
                        $total = 0;
                    @endphp
                    @php
                        $description = $saleinvoicedetails->first()->description;
                    @endphp
                    @foreach ($saleinvoicedetails as $key => $detail)
                        <tr class="item">
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $detail->getItem->name }}</td>

                            <td>{{ $detail->qty }}</td>
                            <td>{{ $detail->rate }}</td>
                            <td>{{ $detail->vat }}</td>
                            <td>{{ $detail->from_date }}</td>
                            <td>{{ $detail->to_date }}</td>
                            <td>{{ number_format($detail->total, 2) }}</td>
                        </tr>
                        @php
                            $total += $detail->total;
                        @endphp
                    @endforeach
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Total</th>
                        <th>{{ number_format($total, 2) }}</th>
                    </tr>
            </td>
        </table>

        <tr>
            <td colspan="3">
                <table cellspacing="0px" cellpadding="2px">
                    <tr>
                        <td width="100%">
                            <b> Remarks: </b> <br>
                            {{ $description }}
                        </td>
                    </tr>

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
