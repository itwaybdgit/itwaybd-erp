@extends('admin.master')
@section('content')
    <style>
        input.form-control[type="submit"] {
            background: #000;
            color: #fff;
        }

        .folder-icone {
            color: #D4AC0D;
        }

        input,
        label {
            display: block;
        }
    </style>

    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Billing Period</h4>
                        {{-- <a href="" class="btn btn-dark">Cash Book</a> --}}
                        <hr>

                    </div>
                    <div class="card-datatable">
                        <x-alert></x-alert>
                        <div class="treeview w-20 border">
                            <ul class="mb-1 pl-3 pb-2">

                                <form action="" method="POST" class="mt-3">
                                    @csrf
                                    <section>

                                        <div style="float:left; width:30%">
                                            <label for="">Month:</label>
                                            <input type="month" name="month"
                                                value="{{ $request->month ?? date('Y-m') }}" class="form-control">
                                        </div>

                                        <div style="float:left; width:30%">
                                            <label for="">Billing Frequency:</label>
                                            <select name="billing_frequency" class="form-control select2">
                                                <option value="All">All</option>
                                                <option {{ $request->billing_frequency == 'ONETIME' ? 'selected' : '' }}
                                                    value="ONETIME">ONETIME</option>
                                                <option {{ $request->billing_frequency == 'MONTHLY' ? 'selected' : '' }}
                                                    value="MONTHLY">MONTHLY</option>
                                                <option {{ $request->billing_frequency == 'YEARLY' ? 'selected' : '' }}
                                                    value="YEARLY">YEARLY</option>
                                            </select>
                                        </div>
                                        <div style="float:left;margin:20px 0px 0px 10px;">

                                            <input type="submit" value="Find" class="form-control">
                                        </div>

                                        <br style="clear:both;" />

                                    </section>
                                </form>

                                <button onclick="printTable()" class="btn btn-primary mt-2">Print</button>
                                {{-- table --}}
                                <div class="table-responsive mt-2">
                                    <!-- Print button -->

                                    <table width="100%" class="table table-bordered table-stripped print-font-size"
                                        cellpadding="6" cellspacing="1">
                                        <thead>
                                            <tr>
                                                <td height="25" width="5%"><strong>SL.</strong></td>
                                                <td width="10%"><strong>Date</strong></td>
                                                <td width="10%"><strong>Company Name</strong></td>
                                                <td width="10%"><strong>Company Owner Name</strong></td>
                                                <td width="10%"><strong>Owner Phone</strong></td>
                                                <td width="10%"><strong>Billing Frequency</strong></td>
                                                <td width="10%"><strong>Item</strong></td>
                                                <td width="12%"><strong>Qty</strong></td>
                                                <td width="12%"><strong>Price</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sl = 1;
                                                $total = 0;
                                            @endphp
                                            @if(isset($billing))
                                            @forelse($billing as $row)
                                                <tr>
                                                    <td>{{ $row->id }}</td>
                                                    <td>
                                                        @if (!empty($row->payment_date_monthly))
                                                            {{ $row->payment_date_monthly }}
                                                        @elseif (!empty($row->payment_date_yearly))
                                                            {{ $row->payment_date_yearly }}
                                                        @elseif (!empty($row->installment_date))
                                                            @php
                                                                $installmentDates = explode(
                                                                    ',',
                                                                    $row->installment_date,
                                                                );
                                                                $currentMonth = date('m', strtotime($request->month));
                                                                $filteredDates = array_filter(
                                                                    $installmentDates,
                                                                    function ($date) use ($currentMonth) {
                                                                        return date('m', strtotime($date)) ==
                                                                            $currentMonth;
                                                                    },
                                                                );
                                                                $matchingKeys = array_keys($filteredDates);
                                                                $displayKeys = !empty($matchingKeys)
                                                                    ? implode(', ', $matchingKeys)
                                                                    : null;
                                                                $displayDate = !empty($filteredDates)
                                                                    ? implode(', ', $filteredDates)
                                                                    : 'N/A';
                                                            @endphp
                                                            {{ $displayDate }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $row->customer->company_name ?? 'No Item' }}
                                                    </td>
                                                    <td>
                                                        {{ $row->customer->company_owner_name ?? 'No Item' }}
                                                    </td>
                                                    <td>
                                                        {{ $row->customer->company_owner_phone ?? 'No Item' }}
                                                    </td>
                                                    <td>
                                                        {{ $row->billing_frequency ?? 'No Item' }}
                                                    </td>
                                                    <td>
                                                        {{ $row->item->name ?? 'No Item' }}
                                                    </td>
                                                    <td>
                                                        {{ $row->qty ?? '0' }}
                                                    </td>
                                                    <td align="right">
                                                        @if ($row->billing_frequency == 'ONETIME')
                                                            @php
                                                                $installmentAmount = explode(',', $row->installment);
                                                                $percentage = $installmentAmount[$displayKeys] ?? 0;
                                                                $amount = ($percentage / 100) * $row->rate;
                                                            @endphp
                                                            {{ $amount }}
                                                        @else
                                                            {{ number_format($row->rate, 2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php $total += $row->rate; @endphp
                                            @empty
                                                <tr>
                                                    <td colspan="5" align="center">No data available for the selected
                                                        month.</td>
                                                </tr>
                                            @endforelse
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr class="table_data">
                                                <td colspan="8" align="right"><strong>Total</strong></td>
                                                <td colspan="2" align="right">
                                                    <strong>{{ number_format($total, 2) }}</strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('datatablescripts')
    <script>
        function printTable() {
            // Open a new window to only print the table content
            var printWindow = window.open('', '', 'height=600,width=800');

            // Get the table HTML content
            var tableContent = document.querySelector('.table-responsive').innerHTML;

            // Add the table content with some basic styling to the print window
            printWindow.document.write('<html><head><title>Print Table</title>');
            printWindow.document.write(
                '<style>table {width: 100%; border-collapse: collapse;} td, th {border: 1px solid black; padding: 6px;} .print-font-size {font-size: 14px;} </style>'
                );
            printWindow.document.write('</head><body>');
            printWindow.document.write(tableContent);
            printWindow.document.write('</body></html>');

            // Close the document to render the content
            printWindow.document.close();

            // Trigger the print dialog
            printWindow.print();
        }
    </script>
@endsection
