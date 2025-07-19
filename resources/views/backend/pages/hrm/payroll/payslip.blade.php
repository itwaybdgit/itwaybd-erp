<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Paysheet</title>
    <style>
        @media print {
            body { margin: 0; }
            .page-break { page-break-after: always; }
            .no-print { display: none; }
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            margin: 10px;
            background: white;
        }
        
        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 15mm;
            box-sizing: border-box;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .pay-period {
            font-size: 14px;
            color: #666;
        }
        
        .employee-section {
            margin-bottom: 25px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .employee-header {
            background: #f5f5f5;
            padding: 8px 12px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .employee-name {
            font-weight: bold;
            font-size: 14px;
        }
        
        .employee-id {
            color: #666;
            font-size: 11px;
        }
        
        .pay-details {
            padding: 12px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .detail-row:last-child {
            margin-bottom: 0;
        }
        
        .detail-left {
            flex: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .detail-item {
            min-width: 120px;
        }
        
        .detail-label {
            font-weight: bold;
            color: #333;
            margin-right: 5px;
        }
        
        .detail-value {
            color: #666;
        }
        
        .earnings-deductions {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }
        
        .earnings, .deductions {
            flex: 1;
        }
        
        .section-title {
            font-weight: bold;
            background: #e9e9e9;
            padding: 4px 8px;
            margin-bottom: 5px;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .line-item {
            display: flex;
            justify-content: space-between;
            padding: 2px 8px;
            font-size: 11px;
        }
        
        .line-item:nth-child(even) {
            background: #f9f9f9;
        }
        
        .net-pay {
            background: #2c5aa0;
            color: white;
            padding: 8px 12px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
        }
        
        .controls {
            margin: 20px 0;
            text-align: center;
        }
        
        .btn {
            background: #2c5aa0;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 14px;
        }
        
        .btn:hover {
            background: #1e3f73;
        }
        
        @media screen {
            .page {
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="controls no-print">
        <button class="btn" onclick="window.print()">Print Paysheet</button>
        <button class="btn" onclick="generatePDF()">Generate PDF</button>
        <a class="btn" href="{{route('hrm.payroll.index')}}" style="text-decoration: none">Back</a>
    </div>

    <div class="page">
        <div class="header">
            <div class="company-name">{{$companyInfo->company_name}}</div>
            <div class="pay-period">Pay Period: {{$month}} , {{$year}}</div>
        </div>

        <!-- Employee 1 -->
        @foreach($payslips as $index=>$data)
        <div class="employee-section">
            <div class="employee-header">
                <span class="employee-name">{{$data->employee->name}}</span>
                <span class="employee-id">ID: {{$data->employee->id_card}}</span>
            </div>
            <div class="pay-details">
                <div class="detail-row">
                    <div class="detail-left">
                        <div class="detail-item">
                            <span class="detail-label">Department:</span>
                            <span class="detail-value">Sales</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Position:</span>
                            <span class="detail-value">Sales Manager</span>
                        </div>
                        
                    </div>
                </div>
                <div class="earnings-deductions">
                    <div class="earnings">
                        <div class="section-title">Earnings</div>
                        <div class="line-item">
                            <span>Basic Salary</span>
                            <span>{{$data->basic}}</span>
                        </div>
                        <div class="line-item">
                            <span>Overtime Hours ({{$data->overtime_hours}})</span>
                            <span>{{$data->overtime_pay}}</span>
                        </div>
                        <div class="line-item">
                            <span>Attendnace Allowance</span>
                            <span>{{$data->attendance_pay}}</span>
                        </div>
                        @php 
                        $totalsalary = $data->basic + $data->overtime_pay + $data->attendance_pay;

                        @endphp
                        <div class="line-item" style="border-top: 1px solid #ccc; font-weight: bold;">
                            <span>Gross Pay</span>
                            <span>{{$totalsalary}}</span>
                        </div>
                    </div>
                    <div class="deductions">
                        <div class="section-title">Deductions</div>
                        <div class="line-item">
                            <span>Absence</span>
                            <span>{{$data->absent_deduction}}</span>
                        </div>
                        <div class="line-item">
                            <span>Late</span>
                            <span>{{$data->late_deduction}}</span>
                        </div>
                        <div class="line-item">
                            <span>Loan</span>
                            <span>{{$data->loan_deduction}}</span>
                        </div>
                        @if($data->other_deduction_pay >0)
                        <div class="line-item">
                            <span>{{$data->other_deduction}}</span>
                            <span>{{$data->other_deduction_pay}}</span>
                        </div>
                        @endif
                       
                        <div class="line-item" style="border-top: 1px solid #ccc; font-weight: bold;">
                            <span>Total Deductions</span>
                            @php 
                            $totalDeduction= $data->absent_deduction + $data->other_deduction_pay + $data->loan_deduction;

                            @endphp
                            <span>{{$totalDeduction}}</span>
                        </div>
                    </div>
                </div>
                <div class="net-pay">NET PAY: {{$totalsalary -$totalDeduction }}</div>
            </div>
        </div>
        @endforeach

      
    </div>

    <script>
        function generatePDF() {
            // Hide the control buttons
            const controls = document.querySelector('.controls');
            controls.style.display = 'none';
            
            // Trigger print dialog which can save as PDF
            window.print();
            
            // Show controls again after a short delay
            setTimeout(() => {
                controls.style.display = 'block';
            }, 100);
        }
    </script>
</body>
</html>