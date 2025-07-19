
                        @if (isset($dayes))
                            @foreach ($dayes as $dayKey => $daye)
                                <h5 class="text-center mt-3">Attendance History of {{ $daye->date }}</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Employee Name</th>
                                            <th scope="col"> In Time</th>
                                            <th scope="col"> Office In Time</th>
                                            <th scope="col"> Last Out Time</th>
                                            <th scope="col"> Worked Hours</th>
                                            <th scope="col"> OverTime Houre</th>
                                            <th scope="col"> Late</th>
                                            <th scope="col"> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
   @php 
$in = null; 
$lastin = null; 
$diff = null; 
$sld = 1; 
@endphp 

@foreach ($attendances as $key => $attendance) 
    @if ($attendance->date == $daye->date) 
        @php
        // Format display times
        $signIn = date('h:i A', strtotime($attendance->sign_in));
        $last_in_time = date('h:i A', strtotime($attendance->employe->last_in_time));
        $signOut = $attendance->sign_out ? date('h:i A', strtotime($attendance->sign_out)) : '--';
        
        // Reference times using Carbon for consistency
        $officeStart = \Carbon\Carbon::parse($attendance->date)->setTime(8, 0); // 8:00 AM
        $officeEnd = \Carbon\Carbon::parse($attendance->date)->setTime(17, 0); // 5:00 PM
        $actualIn = \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->sign_in);
        
        // Handle sign out - use actual time or current time if still working
        $actualOut = $attendance->sign_out ? 
            \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->sign_out) : 
            \Carbon\Carbon::now();
        
        // Calculate total worked duration for display
        $workedDuration = $actualIn->diff($actualOut);
        
        // OVERTIME CALCULATION
        // Rule: Only time worked after 5:00 PM counts as overtime
        $overtimeMinutes = 0;
        
        // Step 1: Calculate time worked after 5:00 PM
        if ($actualOut->gt($officeEnd)) {
            $overtimeMinutes = $actualOut->diffInMinutes($officeEnd);
        }
        
        // Step 2: If clocked in late (after 8:00 AM), subtract late minutes from overtime
        if ($actualIn->gt($officeStart)) {
            $lateMinutes = $actualIn->diffInMinutes($officeStart);
            $overtimeMinutes = max($overtimeMinutes - $lateMinutes, 0);
        }
        
       
        $overtimeHours = floor($overtimeMinutes / 60);
        $overtimeMins = $overtimeMinutes % 60;
        
        // Optional: Add debug info (remove in production)
        $debugInfo = [
            'actualIn' => $actualIn->format('H:i'),
            'actualOut' => $actualOut->format('H:i'),
            'timeAfter5PM' => $actualOut->gt($officeEnd) ? $actualOut->diffInMinutes($officeEnd) : 0,
            'lateMinutes' => $actualIn->gt($officeStart) ? $actualIn->diffInMinutes($officeStart) : 0,
            'finalOvertime' => $overtimeMinutes,
            'isEarlyArrival' => $actualIn->lt($officeStart),
            'isLateArrival' => $actualIn->gt($officeStart)
        ];
        @endphp
        
        <tr>
            <td>{{ $attendance->employe->id_card }}</td>
            <td>{{ $attendance->employe->name }}</td>
            <td>{{ $signIn }}</td>
            <td>{{ $last_in_time }}</td>
            <td>{{ $signOut }}</td>
            <td>
                {{ $workedDuration->h }} : {{ str_pad($workedDuration->i, 2, '0', STR_PAD_LEFT) }} 
                {{ !$attendance->sign_out ? '(Running)' : '' }}
            </td>
            <td>
                {{ $overtimeHours }} : {{ str_pad($overtimeMins, 2, '0', STR_PAD_LEFT) }}
               
            </td>
            <td>
                {{ CUSTOM_LATE_DAYS($attendance->employe, date('m', strtotime($daye->date)), date('d', strtotime($attendance->date))) == 1 ? 'Late' : 'N/A' }}
            </td>
            <td>
                <a href="{{ route('hrm.attendance.edit', $attendance->id) }}">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        
        {{-- Debug section (remove in production) --}}
        <!-- <tr class="debug-row" style="background-color: #f8f9fa; font-size: 12px;">
            <td colspan="9">
                Debug: In={{ $debugInfo['actualIn'] }}, Out={{ $debugInfo['actualOut'] }}, 
                After5PM={{ $debugInfo['timeAfter5PM'] }}min, Late={{ $debugInfo['lateMinutes'] }}min, 
                Final={{ $debugInfo['finalOvertime'] }}min, Early={{ $debugInfo['isEarlyArrival'] ? 'YES' : 'NO' }}
            </td>
        </tr> -->
    @endif 
@endforeach


                                    </tbody>
                                </table>
                            @endforeach
                        @endif