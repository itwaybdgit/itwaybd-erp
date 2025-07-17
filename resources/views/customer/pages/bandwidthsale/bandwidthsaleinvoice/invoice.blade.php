@extends('customer.master')

<style>
    @media print {
        .invoice {
            page-break-after: auto;
        }
    }
</style>
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Invoice</h3>
                </div>
                @foreach ($detals as $lo => $itellist)
                @php
                    $business = App\Models\Business::where('id', $itellist->first()->business_id)->first();
                    $invoice = $itellist->first()->getInvoice;
                    $description = $itellist->first()->description;
                @endphp
                <div class="card-body">
                    <div class="row no-print">
                    <div class="col-6">

                                <div class="modal fade sendMailModal{{$lo}}" id="" tabindex="-1" role="dialog" aria-labelledby="sendMailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sendMailModalLabel">Send Mail</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{route('bandwidthsaleinvoice.mail.invoice',["business" => $business->id,'saleinvoiceid'=> $itellist->first()->bandwidth_sale_invoice_id])}}" method="get">
                                            <!-- Modal Body -->
                                            <div class="modal-body">
                                               @php
                                                   $ccsemail = explode(",",$invoice->customer->billing_email ?? "");
                                               @endphp

                                                <div class="form-group package">
                                                    <label for="email">To</label>
                                                    <input type="text" name="email" value="{{  $ccsemail[0] ?? "" }}" class="form-control sakib">
                                                 <div>
                                                    <div class="remove d-flex justify-content-center align-items-center mt-1">
                                                        <button type="button" class="btn btn-success" id="addrow">Add New</button>
                                                    </div>
                                                 </div>
                                                 @for ($j = 1;$j < count($ccsemail); $j++)
                                                 <div class="form-group d-flex mt-1">
                                                    <input type="text" name="cc_email[]" value="{{$ccsemail[$j]}}" class="form-control">
                                                    <div class="remove-container ">
                                                        <button class="btn btn-danger remove"><i class="fas fa-trash-alt"></i></button>
                                                    </div>
                                                 </div>
                                                 @endfor
                                                </div>

                                                <div class="form-group">
                                                    <label for="subject">Subject</label>
                                                    <input type="text" value="Invoice : #{{$invoice->invoice_no}}" name="subject" class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="message">Message</label>
                                                    <textarea name="message" id="message" class="form-control summernote">Dear {{$invoice->customer->company_name ?? 'N/A'}} &#013; {!! $business->message !!}
                                                    </textarea>
                                                </div>

                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="modal-footer">

                                               <div class="d-inline">
                                                <button class="btn btn-info float-left my-2"><i class="fas fa-mail"></i>
                                                    Send Mail</button>
                                               </div>
                                               <div class="col-md-6">
                                                <button type="button" class="btn btn-danger w-50" data-dismiss="modal">Close</button>
                                               </div>

                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $('.modelclick').click(function(event) {
                                            event.preventDefault();
                                            let id = $(this).attr("model-id");
                                            $(this).closest('div').find('.sendMailModal'+id).modal('show');
                                        });
                                    });
                                </script>
                        </div>

                        <div class="col-6">
                            <a onclick='printDiv("DivIdToPrint{{$lo}}")' class="btn btn-default float-right my-2"><i
                                    class="fas fa-print"></i>
                                Print</a>
                        </div>
                    </div>

                    <div class="invoice p-3 mb-3" id="DivIdToPrint{{$lo}}">
                        <!-- title row -->
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 " style="">
                                {{-- @if (isset($companyInfo->invoice_logo))
                                    {!! $companyInfo->invoice_logo ?? '' !!}
                                @endif --}}
                                <img src="{{ asset('storage/'.$business->invoice_logo) }}" id="businessInvoiceLogo" width="200px" height="100px" alt="">
                            </div>

                            <!-- /.col -->
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col" style="text-align: center" >
                                <b style="font-size : 20px"> {{ $invoice->customer->company_name ?? 'N/A' }} </b>
                                <br>
                                Invoice: {{ $invoice->invoice_no ?? 'N/A' }} <br>

                                Phone : {{ $invoice->customer->company_owner_phone ?? 'N/A' }} <br>
                                Address:  House:  {{  $invoice->customer->house ?? "" }},  Road: {{$invoice->customer->road ?? ""}}, {{ $invoice->customer->upazilla->upozilla_name ?? "" }}, {{ $invoice->customer->district->district_name ?? "" }}, {{ $invoice->customer->division->name ?? "" }} <br>
                                {{ $invoice->billing_month ?? 'N/A' }}

                            </div>
                            <!-- /.col -->

                            <div class="col-sm-4 invoice-col" style="text-align:right">
                                <b id="businessName" >{{ $business->business_name ?? $companyInfo->company_name }}</b>
                                <address>
                                    Phone : <strong id="businessPhone" >{{ $business->phone ?? $companyInfo->phone }}</strong><br>
                                    Address : <strong id="businessAddress" ><em>{{ $business->address ?? $companyInfo->address }}</em></strong><br>
                                    Email: <strong id="businessEmail" >{{ $business->email ?? $companyInfo->email }}</strong>
                                </address>
                            </div>
                        </div><br>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table  table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Rate</th>
                                            <th>Vat</th>
                                            <th>From date</th>
                                            <th>To date</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($itellist as $detail)
                                            <tr>
                                                <td>{{ 1 }}</td>
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
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="7" class="text-right">Total :
                                            </th>
                                            <th>{{ number_format($total, 2) }}</th>

                                        </tr>

                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-12 mt-2 ">
                                <p>
                                   <b>Remarks:</b>

                                    {{$description ?? "N/A"}}
                                </p>
                            </div>

                            <div class="col-6 mt-3 text-left">
                                <p>Received by:_____________<br />
                                    Date:____________________
                                </p>
                            </div>

                            <div class="col-6 mt-3 text-right">
                                <p>Authorized by:________________<br />
                                    Date:_________________</p>
                            </div>
                             <hr>
                            <div class="col-md-12 bg-success text-white" style="text-align: center">
                                Thank you for choosing {{ $companyInfo->company_name }} Company products.
                                We believe you will be satisfied by our services.
                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->

                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#businessSelect').change(function() {
            var selectedBusinessId = $(this).val();
            // alert(selectedBusinessId);

            $.ajax({
                url: '/admin/businesses/get-business-info/' + selectedBusinessId,
                type: 'GET',
                success: function(data) {
                    $('#businessName').html(data.businessName);
                    $('#businessPhone').html(data.businessPhone);
                    $('#businessAddress').html(data.businessAddress);
                    $('#businessEmail').html(data.businessEmail);
                    $('#businessInvoiceLogo').attr('src', data.businessInvoiceLogo);

                    // Show an alert on success
                    // alert('Business information fetched successfully!');
                },
                error: function(error) {
                    console.error('Error fetching business information:', error);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Add new row
        $('#addrow').on('click', function() {
            const newRow = `
                <div class="form-group d-flex mt-1">
                    <input type="text" name="cc_email[]" value="" class="form-control">
                    <div class="remove-container ">
                        <button class="btn btn-danger remove"><i class="fas fa-trash-alt"></i></button>
                    </div>
                </div>
            `;
            $('.package').append(newRow);
        });

        // Remove row
        $(document).on('click', '.remove', function () {
            $(this).closest('.remove-container').prev('input').remove();
            $(this).closest('.remove-container').remove();
        });
    });
</script>
