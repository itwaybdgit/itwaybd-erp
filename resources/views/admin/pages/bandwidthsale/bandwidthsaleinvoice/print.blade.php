@extends('admin.master-invoice')

<style>
/* ===== General Invoice Styling ===== */
.invoice {
    background: #fff;
    padding: 20px;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
    color: #333;
    position: relative;
}

/* ===== Header Section ===== */
.header-section {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    background-color: #fff;
    position: relative;
}

.header-logo {
    flex: 0 0 220px;
    margin: 0 20px;
    z-index: 2;
}

.header-logo img {
    max-width: 220px;
    height: auto;
}

.header-banner {
    flex: 1;
    height: 180px;
    position: relative;
}

.header-banner img.rotated-bg {
    position: absolute;
    top: 0;
    right: 0;
    width: 90%;
    transform: rotate(180deg);
    object-fit: cover;
    z-index: 1;
}

.header-text {
    position: absolute;
    top: 30%;
    right: 40px;
    transform: translateY(-50%);
    color: #fff;
    font-weight: bold;
    font-size: 2rem;
    text-align: right;
    z-index: 2;
    white-space: nowrap;
}

/* ===== Invoice Info ===== */
.invoice-details {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
}

.invoice-details div {
    margin-bottom: 5px;
}

/* ===== Table Styling ===== */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.table th {
    background-color: #f2f2f2;
}

tfoot th {
    text-align: right;
}

/* ===== Payment Info & Notes ===== */
.payment-info, .note-section {
    margin-top: 20px;
    font-size: 0.9rem;
}

.payment-info div {
    margin-bottom: 3px;
}

/* ===== Footer Section ===== */
/* Footer fixed at bottom */
.footer {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    border-top: 2px solid #ddd;
    background: #fff;
    padding: 10px 0;
    text-align: center;
    z-index: 10;
}



.footer h3 {
    margin-bottom: 10px;
}

.footer img.rotated-bg {
    width: 100%;
    max-width: 50%;
    display: block;
    margin: 0 auto;
}

/* ===== Responsive ===== */
@media (max-width: 768px) {
    .header-section, .invoice-details {
        flex-direction: column;
        text-align: center;
    }

    .header-text {
        text-align: center;
        position: relative;
        transform: none;
        margin-top: 10px;
    }
}

/* ===== Print Styles ===== */
@media print {
    body * {
        visibility: hidden;
        margin-bottom: 150px;
    }

    .invoice, .invoice * {
        visibility: visible;
    }

    .invoice {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
    }

    /* Flex fallback for print */
    .header-section, .invoice-details {
        display: block !important;
        width: 100% !important;
        text-align: center !important;
    }

    .header-logo, .header-banner, .header-text {
        float: none !important;
        margin: 0 auto !important;
        text-align: center !important;
        position: relative !important;
    }

    .table th, .table td {
        font-size: 12px;
    }

    .payment-info, .note-section {
        font-size: 11px;
    }

    .footer img.rotated-bg {
        width: 100% !important;
        height: auto !important;
    }
    .footer {
        position: fixed; /* maintain at bottom */
        bottom: 0;
        width: 100%;
        background: #fff;
        z-index: 10;
    }
}
</style>

@section('content')
@foreach ($detals as $lo => $itellist)
@php
$business = App\Models\Business::where('id', $itellist->first()->business_id)->first();
$invoice = $itellist->first()->getInvoice;
$description = $itellist->first()->description;
@endphp

<div class="invoice" id="DivIdToPrint{{$lo}}">

    <!-- Header -->
    <div class="header-section">
        <div class="header-logo">
            <img src="{{ asset('storage/'.$companyInfo->getRawOriginal('invoice_logo')) }}" alt="Logo">
        </div>
        <div class="header-banner">
            <img src="{{ asset('admin_assets/shade1.png') }}" class="rotated-bg" alt="Header Background">
            <div class="header-text">
                Leading Website & Software Development<br>
                Company in Bangladesh
            </div>
        </div>
    </div>

    <!-- Invoice Info -->
    <div class="invoice-details">
        <div>
            <strong>Invoice No:</strong> {{ $invoice->invoice_no ?? 'N/A' }}<br>
            <strong>Invoice to:</strong> {{ $invoice->customer->company_name ?? 'N/A' }}
        </div>
        <div>
            <strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y') }}
        </div>
    </div>

    <!-- Items Table -->
    <table class="table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Rate</th>
                <th>Vat</th>
                <th>From</th>
                <th>To</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($itellist as $i => $detail)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $detail->getItem->name }}</td>
                <td>{{ $detail->qty }}</td>
                <td>{{ $detail->rate }}</td>
                <td>{{ $detail->vat }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->from_date)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($detail->to_date)->format('d-m-Y') }}</td>
                <td>{{ number_format($detail->total,2) }}</td>
            </tr>
            @php $total += $detail->total; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">Total</th>
                <th>{{ number_format($total,2) }}</th>
            </tr>
        </tfoot>
    </table>

    <!-- Payment Info -->
    <div class="payment-info">
        <strong>Payment Information:</strong><br>
        Nagad Merchant: 01854125454<br>
        Bkash/Nagad Personal: 01844690700<br>
        Upay: 01854125454<br>
        <em>2% charge applicable for Bkash & Nagad payment.</em><br>
        Dutch Bangla Bank, Uttara Branch<br>
        Account Name: IT WAY BD<br>
        Account Number: 117110004832
    </div>

    <!-- Remarks / Notes -->
    <div class="note-section">
        <em>Remarks: {{ $description ?? 'N/A' }}</em><br>
        <em>Note: VAT(Exempted) & Tax not included with the mentioned price.</em>
    </div>

    <!-- Footer / Our Products -->
    <div class="footer">
        <h3>Our Products:</h3>
        <img src="{{ asset('admin_assets/shade1.png') }}" class="rotated-bg" alt="Products Banner">
    </div>

</div>
@endforeach
@endsection

<script>
    window.onload = function() {
        var printContents = document.querySelector('.printDiv').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        window.onafterprint = function() {
            window.close();
        };
        window.close();
    };

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
