@extends('admin.master')
@section('title')
    Hrm - {{ $title }}
@endsection

@section('styles')
    <style>
        .bootstrap-switch-large {
            width: 200px;
        }
    </style>
@endsection



@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Attendance Log</h3>
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
                <div class="card-body">
                    <form action="{{ route('hrm.attendancelog.index') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="employe" class="mt-2">Employee:</label>
                            <div class="col-md-3">
                                <select name="employee_id" class="form-control select2" id="employe">
                                    <option value="all">All</option>
                                    @foreach ($employees as $employee)
                                        <option {{ $request->employee_id == $employee->id ? 'selected' : '' }}
                                            value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="From" class="mt-2">From:</label>
                            <div class="col-md-3">
                                <input type="date" id="From" value="{{ $request->from ?? date('Y-m-d') }}"
                                    class="form-control" name="from">
                            </div>
                            <label for="To" class="mt-2">To:</label>
                            <div class="col-md-3">
                                <input type="date" id="To" value="{{ $request->to ?? date('Y-m-d') }}"
                                    class="form-control" name="to">
                            </div>
                            <div class="col-md-1">
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

    <div class="row" id="testDiv">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-body">
                    <button class="btn btn-primary mb-3" onclick="printDiv('attendanceDiv')">Print</button>
                    <button onclick="downloadAttendancePDF()" class="btn btn-primary mb-3">Download PDF</button>
                    <div id="loadingIcon" style="display: none; text-align: center;">
                        <img src="https://cdn-icons-gif.flaticon.com/17905/17905715.gif" alt="Loading..." width="50">
                        <p>Generating PDF...</p>
                    </div>
                    <div id="attendanceDiv">

                        <div id="attendanceDiv">
                            @php

                                $totalOvertimeMinutes = 0;
                            @endphp

                            <h5 class="text-center mt-3">Monthly Attendance History</h5>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Employee Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">In Time</th>
                                        <th scope="col">Office In Time</th>
                                        <th scope="col">Last Out Time</th>
                                        <th scope="col">Worked Hours</th>
                                        <th scope="col">OverTime Hours</th>
                                        <th scope="col">Late</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $key => $attendance)
                                        @php
                                            $signIn = date('h:i A', strtotime($attendance->sign_in));
                                            $last_in_time = date(
                                                'h:i A',
                                                strtotime($attendance->employe->last_in_time),
                                            );
                                            $signOut = $attendance->sign_out
                                                ? date('h:i A', strtotime($attendance->sign_out))
                                                : '--';

                                            $officeStart = Carbon\Carbon::parse($attendance->date)->setTime(8, 0); // 8 AM
                                            $officeEnd = Carbon\Carbon::parse($attendance->date)->setTime(17, 0); // 5 PM
                                            $actualIn = Carbon\Carbon::parse(
                                                $attendance->date . ' ' . $attendance->sign_in,
                                            );
                                            $actualOut = $attendance->sign_out
                                                ? Carbon\Carbon::parse($attendance->date . ' ' . $attendance->sign_out)
                                                : Carbon\Carbon::now();

                                            $workedDuration = $actualIn->diff($actualOut);

                                            $overtimeMinutes = 0;
                                            if ($actualOut->gt($officeEnd)) {
                                                $overtimeMinutes = $actualOut->diffInMinutes($officeEnd);
                                            }

                                            if ($actualIn->gt($officeStart)) {
                                                $lateMinutes = $actualIn->diffInMinutes($officeStart);
                                                $overtimeMinutes = max($overtimeMinutes - $lateMinutes, 0);
                                            }

                                            $totalOvertimeMinutes += $overtimeMinutes;

                                            $overtimeHours = floor($overtimeMinutes / 60);
                                            $overtimeMins = $overtimeMinutes % 60;
                                        @endphp

                                        <tr>
                                            <td>{{ $attendance->employe->id_card }}</td>
                                            <td>{{ $attendance->employe->name }}</td>
                                            <td>{{ $attendance->date }}</td>
                                            <td>{{ $signIn }}</td>
                                            <td>{{ $last_in_time }}</td>
                                            <td>{{ $signOut }}</td>
                                            <td>
                                                {{ $workedDuration->h }} :
                                                {{ str_pad($workedDuration->i, 2, '0', STR_PAD_LEFT) }}
                                                {{ !$attendance->sign_out ? '(Running)' : '' }}
                                            </td>
                                            <td>
                                                {{ $overtimeHours }} : {{ str_pad($overtimeMins, 2, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td>
                                                {{ CUSTOM_LATE_DAYS($attendance->employe, date('m', strtotime($attendance->date)), date('d', strtotime($attendance->date))) == 1 ? 'Late' : 'N/A' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('hrm.attendance.edit', $attendance->id) }}">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @php
                                        $totalOvertimeHours = floor($totalOvertimeMinutes / 60);
                                        $totalOvertimeMins = $totalOvertimeMinutes % 60;
                                    @endphp

                                    <tr>
                                        <td colspan="6" class="text-end"><strong>Total Monthly Overtime:</strong></td>
                                        <td><strong>{{ $totalOvertimeHours }} :
                                                {{ str_pad($totalOvertimeMins, 2, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>







                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.4.3/purify.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function printDiv(divId) {
            const content = document.getElementById(divId).innerHTML;

            // Create a new window
            const printWindow = window.open('', '_blank', 'height=600,width=800');

            // Write the content into the new window
            printWindow.document.open();
            printWindow.document.write(`
                                   <html>
                                   <head>
                                       <title>Print</title>
                                       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                                       <style>
                                           body {
                                               margin: 20px;
                                           }
                                           table {
                                               width: 100%;
                                               border-collapse: collapse;
                                           }
                                           table, th, td {
                                               border: 1px solid black;
                                           }
                                       </style>
                                   </head>
                                   <body>
                                       ${content}
                                   </body>
                                   </html>
                     `);
            printWindow.document.close();

            // Wait for the content to load, then print
            printWindow.onload = function() {
                printWindow.focus();
                printWindow.print();
                printWindow.close();
            };
        }

        function downloadAttendancePDF() {
            const {
                jsPDF
            } = window.jspdf;
            let doc = new jsPDF('p', 'mm', 'a4');

            let element = document.getElementById("attendanceDiv");
            let loadingIcon = document.getElementById("loadingIcon");

            // Show loading icon
            loadingIcon.style.display = "block";

            html2canvas(element, {
                scale: 2
            }).then(canvas => {
                let imgData = canvas.toDataURL("image/png");
                let imgWidth = 190;
                let pageHeight = 297;
                let imgHeight = (canvas.height * imgWidth) / canvas.width;
                let heightLeft = imgHeight;
                let position = 10;

                doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft > 0) {
                    position -= pageHeight;
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                doc.save("Attendance_Report.pdf");

                // Hide loading icon after download
                loadingIcon.style.display = "none";
            });
        }
    </script>
@endsection
