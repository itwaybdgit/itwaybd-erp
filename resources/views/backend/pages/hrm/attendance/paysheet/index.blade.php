@extends('admin.master')
@section('title')
    Hrm - {{ $title }}
@endsection

@section('styles')
    <style>
        .bootstrap-switch-large {
            width: 200px;
        }

        div#ui-datepicker-div {
            background: #fff;
            padding: 10px 20px;
            margin-top: -6px;
            border: 1px solid #e6e6e6;
        }

        div#ui-datepicker-div table tbody tr td {
            border: 1px solid rgb(173, 173, 173)
        }

        div#ui-datepicker-div table tbody tr td a {
            color: #000
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                font-size: 11px;
            }

            .btn,
            .paynow,
            .fa-money-bill {
                display: none !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 4px;
                word-break: break-word;
            }

            h5 {
                margin: 0;
                padding: 10px 0;
                text-align: center;
            }



        }
    </style>
@endsection



@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Salary Pay Sheet</h3>
                    <div class="card-tools">
                        <span id="buttons"></span>
                        <a class="btn btn-tool btn-default" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </a>
                        <a class="btn btn-tool btn-default" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body hide_div">
                    <form action="{{ route('hrm.paysheet.index') }}" method="get">

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="employe" class="mt-2">Employee:</label>
                                <select name="employee_id" class="form-control select2" id="employe">
                                    <option value="all" selected>All</option>
                                    @foreach ($employees->all() as $employee)
                                        <option {{ $request->employee_id == $employee->id ? 'selected' : '' }}
                                            value="{{ $employee->id }}">
                                            {{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="From" class="mt-2">Select Month:</label>
                                <input type="month" id="From" value="{{ $request->month }}" class="form-control"
                                    name="month">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>

                            {{-- <div class="col-md-3">
                                <label for="From" class="mt-2">Date Range:</label>
                                <input type="text" class="form-control " name="dateRange" value=""
                                    id="reservation" />

                            </div> --}}
                            <div class="col-md-1" style="margin-top:38px">
                                <button class="btn btn-success">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col-->
    </div>

    <div class="row">
        <button onclick="printShitCard()" class="btn btn-primary mb-3 ml-3">
            <!-- SVG icon -->
            Print
        </button>

        <div class="col-md-12 shit_Card">
            <div class="card card-default">
                <!-- /.card-header -->
                <div class="card-body ">

                    <h5 class="text-center mt-3">Salary Pay Sheet History </h5>
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Name</th>
                                {{-- <th scope="col">Basic Salary</th>
                                <th scope="col">House Rent</th>
                                <th scope="col">Medical Allowance</th>
                                <th scope="col">Conveyance Allowance</th> --}}
                                <th scope="col">Gross Salary (GS)</th>
                                <th scope="col">Working Day</th>
                                <th scope="col">Presence</th>
                                <th scope="col">Absence (AB)</th>
                                <th scope="col">Absence Salary Deduction</th>
                                <!-- <th scope="col">Late (TLT)</th>
                                                 <th scope="col">Late (3days)</th>
                                                  <th scope="col">Late Salary Deduction</th> -->
                                <th scope="col">Attendance Bonus</th>
                                <th scope="col">Paid Leave (PL)</th>
                                <th scope="col">Unpaid Leave (UL)</th>
                                <th scope="col">Overtime Houre</th>
                                <th scope="col">Overtime Salary (OS)</th>
                                <!-- <th scope="col">Loan</th>
                                                      <th scope="col">Loan Adjusment</th> -->
                                <th scope="col">Payable Salary </th>
                                <th scope="col" class="no-print">Status</th>
                                <th scope="col" class="no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($MonthlyPaySheets))
                                @foreach ($MonthlyPaySheets as $key => $MonthlyPaySheet)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $MonthlyPaySheet->name }}</td>
                                        {{-- <td>{{ $MonthlyPaySheet->basic_salary }} </td>
                                        <td>{{ $MonthlyPaySheet->house_rent }} </td>
                                        <td>{{ $MonthlyPaySheet->medical_allowance }} </td>
                                        <td>{{ $MonthlyPaySheet->travel_allowance }} </td> --}}
                                        <td>{{ $MonthlyPaySheet->total_salary }} </td>
                                        <td>{{ $MonthlyPaySheet->working_day }} </td>
                                        <td>{{ $MonthlyPaySheet->employee_presence_day }} </td>
                                        <td class="text-danger">{{ $MonthlyPaySheet->employee_absence_day }} </td>
                                        <td class="text-danger">{{ $MonthlyPaySheet->absece_salary_deduction }} </td>
                                        <!-- <td>{{ $MonthlyPaySheet->employee_late }} </td>
                                                         <td>{{ $MonthlyPaySheet->employee_late_deduction }} </td>
                                                          <td>{{ $MonthlyPaySheet->employee_late_salary_deduction }}</td> -->
                                        <td>{{ $MonthlyPaySheet->attendance_bonus }} </td>
                                        <td>{{ $MonthlyPaySheet->employee_paid_leave }} </td>
                                        <td>{{ $MonthlyPaySheet->employee_unpaid_leave }}</td>
                                        <td>{{ $MonthlyPaySheet->overtime_houre }}h </td>
                                        <td>{{ $MonthlyPaySheet->overtime_salary }} </td>
                                        <!-- <td class="loanamount">
                                                            @php
                                                                $loan = DB::table('transections')
                                                                    ->where('account_id', 1)
                                                                    ->where(
                                                                        'employee_id',
                                                                        $MonthlyPaySheet->employee_id,
                                                                    )
                                                                    ->selectRaw(
                                                                        'SUM(debit) as debit
                                            ,SUM(credit) as credit',
                                                                    )
                                                                    ->first();
                                                                $loanBalance = $loan->debit - $loan->credit;
                                                                $loanAdjustment = App\Models\Lone::where(
                                                                    'employee_id',
                                                                    $MonthlyPaySheet->employee_id,
                                                                )
                                                                    ->where('status', 'approved')
                                                                    ->latest()
                                                                    ->pluck('lone_adjustment')
                                                                    ->first();

                                                            @endphp
                                                            {{ $loanBalance }}
                                                        </td>
                                                        <td class="loanAdjustment ">{{ $loanAdjustment }} </td> -->
                                        <td class="payable">{{ $MonthlyPaySheet->employee_payable_salary }} </td>
                                        <td>
                                            @if ($MonthlyPaySheet->status == 'paid')
                                                <b class="text-success">Paid</b>
                                            @elseif($MonthlyPaySheet->status == 'unpaid')
                                                <b class="text-danger">Unpaid</b>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($MonthlyPaySheet->status == 'paid')
                                                <button class="btn btn-success"><i class="fas fa-check"></i></button>
                                            @elseif($MonthlyPaySheet->status == 'unpaid')
                                                <button class="paynow"
                                                    href="{{ route('hrm.paysheet.empPayDetailsStore', $MonthlyPaySheet->employee_id) }}"
                                                    data-toggle="modal" data-target="#exampleModal"><i
                                                        class="fas fa-money-bill"></i></button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @elseif (isset($tables))
                                @php
                                    $total_salary = 0;
                                    $employee_payable_salary = 0;
                                @endphp
                                @foreach ($tables as $key => $table)
                                    <tr>
                                        <td>{{ $table['id_card'] }}</td>
                                        <td>{{ $table['name'] }}</td>
                                        {{-- <td>{{ $table['basic_salary'] }} </td>
                                        <td>{{ $table['house_rent'] }} </td>
                                        <td>{{ $table['medical_allowance'] }} </td>
                                        <td>{{ $table['travel_allowance'] }} </td> --}}
                                        <td>{{ $table['total_salary'] }} </td>
                                        <td>{{ $table['working_day'] }} </td>
                                        <td>{{ $table['employee_presence_day'] }} </td>
                                        <td class="text-danger">{{ $table['employee_absence_day'] }}
                                            <!-- @if (is_array($table['absenceDates']))
    @foreach ($table['absenceDates'] as $absDate)
    <span class="badge bg-danger">{{ $absDate }}</span><br>
    @endforeach
    @endif -->

                                        </td>
                                        <td class="text-danger">{{ $table['absece_salary_deduction'] }} </td>
                                        <!-- <td>{{ $table['employee_late'] }} </td>
                                                          <td>{{ $table['employee_late_deduction'] }} </td>
                                                          <td>{{ $table['employee_late_salary_deduction'] }}</td> -->
                                        <td>{{ $table['attendance_bonus'] }} </td>
                                        <td>{{ $table['employee_paid_leave'] }} </td>
                                        <td>{{ $table['employee_unpaid_leave'] }} </td>
                                        <td>{{ $table['overtime_houre'] }} </td>
                                        <td>{{ $table['overtime_salary'] }} </td>
                                        <!-- <td class="loanamount">
                                                            @php
                                                                $loan = DB::table('transections')
                                                                    ->where('account_id', 1)
                                                                    ->where('employee_id', $table['employee_id'])
                                                                    ->selectRaw(
                                                                        'SUM(debit) as debit
                                            ,SUM(credit) as credit',
                                                                    )
                                                                    ->first();
                                                                $loanBalance = $loan->debit - $loan->credit;
                                                                $loanAdjustment = App\Models\Lone::where(
                                                                    'employee_id',
                                                                    $table['employee_id'],
                                                                )
                                                                    ->where('status', 'approved')
                                                                    ->latest()
                                                                    ->pluck('lone_adjustment')
                                                                    ->first();
                                                            @endphp
                                                            {{ $loanBalance }}
                                                        </td>
                                                        <td class="loanAdjustment ">{{ $loanAdjustment }} </td> -->
                                        <td class="payable">{{ $table['employee_payable_salary'] - $loanAdjustment }} </td>
                                        <td class="no-print">
                                            @if ($table['payroll'] > 0)
                                                <b class="text-success">Paid</b>
                                            @else
                                                <b class="text-danger">Unpaid</b>
                                            @endif

                                        </td>
                                        <td class="no-print">
                                            {{-- @if ($table > status == 'paid') --}}
                                            {{-- <button class="btn btn-success"><i class="fas fa-check"></i></button> --}}
                                            {{-- {{-- @elseif($table > status == 'unpaid') --}}
                                            {{-- <button class="paynow"
                                                href="{{ route('hrm.paysheet.empPayDetailsStore', $table['employee_id']) }}"
                                                data-toggle="modal" data-target="#exampleModal"><i
                                                    class="fas fa-money-bill"></i></button> --}}
                                            {{-- @endif --}}
                                        </td>
                                    </tr>
                                    @php
                                        $total_salary += $table['total_salary'];
                                        $employee_payable_salary += $table['employee_payable_salary'];
                                    @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="22"></td>
                                </tr>
                            @endif
                        </tbody>


                        <tfoot class="footer-only-last">
                            <tr>
                                <td colspan="2" class="text-success text-right"></td>
                                <td class="text-right">{{ $total_salary }}</td>
                                <td colspan="15" class="text-right">{{ $employee_payable_salary }}</td>
                            </tr>
                            <tr>
                                <td colspan="29" class="text-success text-right">
                                    {{-- In Word: {{ ucfirst(Terbilang::make($total_salary)) }} --}}
                                </td>
                            </tr>
                        </tfoot>
                    </table>


                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col-->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="card-header">
                        <h3 class="card-title">Salary Pay Sheet</h3>
                        <div class="card-tools">
                            <span id="buttons"></span>
                            <a class="btn btn-tool btn-default" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </a>
                            <a class="btn btn-tool btn-default" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card card-body">
                        <form class="needs-validation" action="" method="post" novalidate>
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Paybale Salary</label>
                                <div class="col-md-9 mb-1">
                                    <h5 class="showpayable"></h5>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Amount <span class="text-danger">*</span></label>
                                <div class="col-md-9 mb-1">
                                    <input type="number" class="form-control payamount" min="1" required
                                        name="amount">
                                    @error('amount')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Payment Type <span
                                        class="text-danger">*</span></label>
                                <div class="col-md-9 mb-1">
                                    <select name="payment_type" class="form-control">
                                        <option selected disabled>Select a Method</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('amount')
                                        <span class=" error text-red text-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Loan </span></label>
                                <div class="col-md-9 mb-1">
                                    <h5 class="showloanamount">
                                    </h5>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Loan Adjustment</span></label>
                                <div class="col-md-9 mb-1">
                                    <h5 class="showloanadj">
                                    </h5>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let from = document.getElementById("From");
            let today = new Date();
            let currentMonth = today.toISOString().slice(0, 7); // Format: YYYY-MM

            from.setAttribute("max", currentMonth);
        });

        $(document).on('click', '.paynow', function() {
            let url = $(this).attr('href');
            $('form').attr('action', url);
            let payable = $(this).closest('tr').find('.payable').text();
            $('.showpayable').text(payable)
            $('.payamount').val(Number(payable))
            let loanamount = $(this).closest('tr').find('.loanamount').text();
            $('.showloanamount').text(loanamount);
            let loanAdjustment = $(this).closest('tr').find('.loanAdjustment').text();
            $('.showloanadj').text(loanAdjustment);
        })
    </script>
    <script>
        function printShitCard() {
            var content = document.querySelector('.shit_Card').innerHTML;
            var printWindow = window.open('', '', 'height=800,width=1200');

            printWindow.document.write('<html><head><title>Print Salary Sheet</title>');

            // Optional: Include your CSS or Bootstrap
            printWindow.document.write('<link rel="stylesheet" href="{{ asset('css/app.css') }}">');

            // Custom styles for print
            printWindow.document.write(`
            <style>
                @media print {
                    @page {
                        size: A4 landscape;
                       margin: 0;
                    }
                                .no-print {
        display: none !important;
    }
                    body {
                        font-size: 12px;
                    }
                    .btn, .paynow, .fa-money-bill {
                        display: none !important;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    table th, table td {
                        padding: 6px;
                        border: 1px solid #000;
                        word-break: break-word;
                    }


                }
            </style>
        `);

            printWindow.document.write('</head><body>');
            printWindow.document.write(content);
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.focus();

            printWindow.onload = function() {
                printWindow.print();
            };

            printWindow.onafterprint = function() {
                printWindow.close();
            };
        }
    </script>
@endsection
