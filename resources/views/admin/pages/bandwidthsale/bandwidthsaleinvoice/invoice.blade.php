@extends('admin.master')

<style>
    .payment-info.mb-4 {
        margin-top: 26px;
        margin-left: 20px;
        font-size: px;

    }

    @media print {
        .invoice {
            page-break-after: auto;
        }
    }
</style>


<style>
    .header-section {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        width: 100%;
        position: relative;
        background-color: #ffffff;
    }

    .header-logo {
        flex: 0 0 220px;
        /* padding: 34px 115px; */
        margin-top: 80px;
        margin-left: 90px;
        z-index: 2;
    }

    .row.mt-3.mb-3 {
        align-items: center;
    }

    .header-banner {
        flex: 1;
        /* position: relative; */
        height: 180px;
    }

    .header-banner img.rotated-bg {
        position: absolute;
        top: 0;
        right: 0;
        width: 85%;
        transform: rotate(180deg) scaleX(1);
        /* 🔄 Rotate & Flip horizontally */
        object-fit: cover;
        z-index: 1;
    }

    .invoice-details {
        font-size: 20px;
        font-weight: 800;
    }

    .header-text {
        position: absolute;
        top: 40%;
        right: 43px;
        transform: translateY(-50%);
        color: #fff;
        font-weight: bold;
        font-size: 2.0rem;
        text-align: right;
        z-index: 2;
        white-space: nowrap;
    }

    img.rotated-bg {
        width: 50%;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-logo {
            text-align: center;
            width: 100%;
        }

        .header-banner {
            width: 80%;
            height: 120px;
        }

        .header-banner img.rotated-bg {
            object-fit: cover;
            height: 120px;
        }

        .header-text {
            font-size: 1.1rem;
            right: 15px;
            text-align: center;
            width: 100%;
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
                                @if (has_route('bandwidthsaleinvoice.mail.invoice'))
                                    <button type="button" class="btn btn-info float-left my-2 modelclick"
                                        model-id="{{ $lo }}" data-toggle="modal" data-target=".sendMailModal">
                                        <i class="fas fa-mail"></i> Mail
                                    </button>
                                @endif
                                <div class="modal fade sendMailModal{{ $lo }}" id="" tabindex="-1"
                                    role="dialog" aria-labelledby="sendMailModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sendMailModalLabel">Send Mail</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form
                                                action="{{ route('bandwidthsaleinvoice.mail.invoice', ['business' => $business->id, 'saleinvoiceid' => $itellist->first()->bandwidth_sale_invoice_id]) }}"
                                                method="get">
                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    @php
                                                        $ccsemail = explode(
                                                            ',',
                                                            $invoice->customer->billing_email ?? '',
                                                        );
                                                    @endphp

                                                    <div class="form-group package">
                                                        <label for="email">To</label>
                                                        <input type="text" name="email"
                                                            value="{{ $ccsemail[0] ?? '' }}" class="form-control sakib">
                                                        <div>
                                                            <div
                                                                class="remove d-flex justify-content-center align-items-center mt-1">
                                                                <button type="button" class="btn btn-success"
                                                                    id="addrow">Add New</button>
                                                            </div>
                                                        </div>
                                                        @for ($j = 1; $j < count($ccsemail); $j++)
                                                            <div class="form-group d-flex mt-1">
                                                                <input type="text" name="cc_email[]"
                                                                    value="{{ $ccsemail[$j] }}" class="form-control">
                                                                <div class="remove-container ">
                                                                    <button class="btn btn-danger remove"><i
                                                                            class="fas fa-trash-alt"></i></button>
                                                                </div>
                                                            </div>
                                                        @endfor
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="subject">Subject</label>
                                                        <input type="text" value="Invoice : #{{ $invoice->invoice_no }}"
                                                            name="subject" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="message">Message</label>
                                                        <textarea name="message" id="message" class="form-control summernote">Dear {{ $invoice->customer->company_name ?? 'N/A' }} &#013; {!! $business->message !!}
                                                    </textarea>
                                                    </div>

                                                </div>

                                                <!-- Modal Footer -->
                                                <div class="modal-footer">

                                                    <div class="d-inline">
                                                        <button class="btn btn-info float-left my-2"><i
                                                                class="fas fa-mail"></i>
                                                            Send Mail</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-danger w-50"
                                                            data-dismiss="modal">Close</button>
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
                                            $(this).closest('div').find('.sendMailModal' + id).modal('show');
                                        });
                                    });
                                </script>
                            </div>

                            <div class="col-6">
                                <a onclick='printDiv("DivIdToPrint{{ $lo }}")'
                                    class="btn btn-default float-right my-2"><i class="fas fa-print"></i>
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
                                <img src="{{ asset($invoice->customer->invoice_logo) }}" id="businessInvoiceLogo" width="200px" height="100px" alt="">
                            </div>
                              <!-- /.col -->
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col" style="text-align: center" >
                                <b style="font-size : 20px"> {{ $invoice->customer->company_name ?? 'N/A' }} </b>
                                <br>
                                Invoice: {{ $invoice->invoice_no ?? 'N/A' }} <br>


                            <div class="header-section">
                                <!-- Logo -->
                                <div class="header-logo">
                                    <img src="{{ $business->business_name == 'ISP BILLING PRO'
                                        ? 'https://ispbillingpro.com/wp-content/uploads/2020/10/cropped-WhatsApp_Image_2023-04-04_at_3.04.37_PM-removebg-preview-300x112.png'
                                        : asset('storage/' . $business->invoice_logo) }}"
                                        id="businessInvoiceLogo" width="220px" height="90px" alt="Company Logo">
                                </div>

                                <!-- Banner -->
                                <div class="header-banner">
                                    <img src="{{ asset('admin_assets/shade1.png') }}" class="rotated-bg"
                                        alt="Header Background">
                                    <div class="header-text">
                                        Leading Website & Software Development<br>
                                        Company in Bangladesh
                                    </div>
                                </div>
                            </div>



                            <br>
                            <!-- /.row -->
                            <div class="row mt-3 mb-3 align-content-center">
                                <div class="col-md-8">
                                    <div class="invoice-details">
                                        <div class="mb-2">
                                            <span class="fw-bold text-decoration-underline">Invoice No:</span>
                                            {{ $invoice->invoice_no ?? 'N/A' }}
                                        </div>
                                        <div>
                                            <span class="fw-bold text-decoration-underline">Invoice to:</span>
                                            <span class="fw-bold">{{ $invoice->customer->company_name ?? 'N/A' }} </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="text-end invoice-details">
                                        <div class="fw-bold">Month: {{ $invoice->billing_month ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
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
                                                    <td>{{ \Carbon\Carbon::parse($detail->from_date)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($detail->to_date)->format('d-m-Y') }}</td>
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

                                        {{ $description ?? 'N/A' }}
                                    </p>
                                </div>

                                <!-- Payment Information -->
                                <div class="payment-info mb-4 mt-3">
                                    <div class="fw-bold mb-2">Payment Information:</div>
                                    <div class="payment-details">
                                        <div><span class="fw-bold">Nagad Merchant:</span> 01854125454</div>
                                        <div><span class="fw-bold">Bkash/Nagad Personal:</span> 01844690700</div>
                                        <div><span class="fw-bold">Upay:</span> 01854125454</div>
                                        <div class="fw-bold fst-italic small">2% charge applicable for Bkash & Nagad
                                            payment.</div>
                                        <div class="fw-bold">Dutch Bangla Bank</div>
                                        <div class="fw-bold">Uttara Branch</div>
                                        <div><span class="fw-bold">Account Name:</span> IT WAY BD</div>
                                        <div class="fw-bold">Account Number:</div>
                                        <div>117110004832</div>
                                    </div>
                                </div>


                            </div>

                            <!-- Note -->
                            <div class="note-section mb-4">
                                <div class="fw-bold fst-italic">Note: VAT(Exempted) & Tax not included with the
                                    mentioned Price
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-6 mt-3 text-left">
                                    <p>Received by:_____________<br />
                                        Date:____________________
                                    </p>
                                </div>

                                <div class="col-6 mt-3 text-right">
                                    <p>Authorized by:________________<br />
                                        Date:_________________</p>
                                </div>
                            </div>

                            <hr>

                            <div class="col-12">
                                <h3>Our Products : </h3>
                            </div>

                            <div class="row">


                                <img src="{{ asset('admin_assets/shade1.png') }}" class="rotated-bg"
                                    alt="Header Background">

                            </div>
                            {{-- <div class="col-md-12 bg-success text-white" style="text-align: center">
                                Thank you for choosing {{ $companyInfo->company_name }} Company products.
                                We believe you will be satisfied by our services.
                            </div> --}}
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
        $(document).on('click', '.remove', function() {
            $(this).closest('.remove-container').prev('input').remove();
            $(this).closest('.remove-container').remove();
        });
    });
</script>
