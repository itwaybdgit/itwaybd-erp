   @if (isset($dayes))
       @foreach ($dayes as $dayKey => $daye)
           <div style="display: flex; align-items: center; justify-content: space-between;padding:10px">
               <!-- Left Side: Dropdown -->
               <div class="col-md-3">
                   <select name="employee_id" class="form-control select2" id="employeId">
                       <option value="all">All</option>
                       @foreach ($employees as $employee)
                           <option value="{{ $employee->id }}">{{ $employee->id_card }}({{ $employee->name }})</option>
                       @endforeach
                   </select>
               </div>

               <!-- Centered Date (but visually centered in the full row) -->
               <div style="flex-grow: 1; text-align: center;">
                   <h5>{{ date('l, F j, Y', strtotime($daye->date)) }}</h5>
               </div>
           </div>

           <div class="table-wrapper table-responsive">

               <table id="systemDatatable" class="display table-hover table table-bordered table-striped">
                   <thead>
                       <tr>
                           <th>Employee ID/Name</th>
                           <th>Status</th>
                           <th>Attendance</th>
                           <th>Clock-In/Out Time</th>
                           <th>Over Time</th>
                           <th>Action</th>
                       </tr>
                   </thead>
                   <tbody>
                       @foreach ($attendances as $key => $attendance)
                           @if ($attendance->date == $daye->date)
                               @php

                                   // Step 1: Basic time parsing
                                   $signIn = date('h:i A', strtotime($attendance->sign_in));
                                   $last_in_time = date('h:i A', strtotime($attendance->employe->last_in_time));

                                   // Step 2: Setup fixed office hours
                                   $officeStart = Carbon\Carbon::parse($attendance->date)->setTime(8, 0); // 8:00 AM
                                   $officeStartIntime = Carbon\Carbon::parse($attendance->date)->setTime(8, 10); // 8:10 AM
                                   $officeEnd = Carbon\Carbon::parse($attendance->date)->setTime(17, 0); // 5:00 PM
                                   $actualIn = Carbon\Carbon::parse($attendance->date . ' ' . $attendance->sign_in);

                                   // Step 3: Parse signOut & handle if between 12am-6am (i.e. next day)
                                   if ($attendance->sign_out) {
                                       $signOutTime = Carbon\Carbon::parse($attendance->sign_out);
                                       $signOutHour = (int) $signOutTime->format('H');

                                       if ($signOutHour >= 0 && $signOutHour < 6) {
                                           // Add one day if sign out is between 12:00 AM and 6:00 AM
                                           $actualOut = Carbon\Carbon::parse($attendance->date)
                                               ->addDay()
                                               ->setTimeFrom($signOutTime);
                                       } else {
                                           $actualOut = Carbon\Carbon::parse(
                                               $attendance->date . ' ' . $attendance->sign_out,
                                           );
                                       }

                                       $signOut = $actualOut->format('h:i A');
                                   } else {
                                       $actualOut = Carbon\Carbon::now();
                                       $signOut = '--';
                                   }

                                   // Step 4: Duration calculation
                                   $workedDuration = $actualIn->diff($actualOut);

                                   // Step 5: Overtime logic
                                   $overtimeMinutes = 0;

                                   if ($actualOut->gt($officeEnd)) {
                                       $overtimeMinutes = $actualOut->diffInMinutes($officeEnd);
                                   }

                                   if ($actualIn->gt($officeStart)) {
                                       $lateMinutes = $actualIn->diffInMinutes($officeStart);
                                       $overtimeMinutes = max($overtimeMinutes - $lateMinutes, 0);
                                   }

                                   $overtimeHours = floor($overtimeMinutes / 60);
                                   $overtimeMins = $overtimeMinutes % 60;

                                   // Step 6: Optional debug info
                                   $debugInfo = [
                                       'actualIn' => $actualIn->format('H:i'),
                                       'actualOut' => $actualOut->format('H:i'),
                                       'signOutRaw' => $attendance->sign_out,
                                       'adjustedOut' => $actualOut->format('Y-m-d H:i'),
                                       'lateMinutes' => $actualIn->gt($officeStart)
                                           ? $actualIn->diffInMinutes($officeStart)
                                           : 0,
                                       'finalOvertime' => $overtimeMinutes,
                                   ];

                                   // Step 7: Status
                                   $hasSignIn = !is_null($attendance->sign_in);
                                   $isActive = $attendance->attendanceStatus == 'yes';
                                   $isAbsent = $attendance->attendanceStatus == 'no';
                                   $isLate = $actualIn && $actualIn->gt($officeStartIntime);
                               @endphp


                               <tr class="employee-row" data-employee-id="{{ $attendance->employe->id }}"
                                   data-attendance-id="{{ $attendance->id }}">

                                   <td>
                                       <div>
                                           <div class="fw-bold">{{ $attendance->employe->id_card }}</div>
                                           <div class="text-muted">{{ $attendance->employe->name }}</div>
                                       </div>
                                   </td>
                                   <td>

                                       <div class="d-flex flex-column">
                                           <div class="status-indicator">
                                               <div class="status-badge status-{{ $isActive ? 'Active' : 'absent' }}">
                                               </div>
                                               <div class="status-toggle">
                                                   <button type="button"
                                                       class="toggle-btn Active {{ $isActive ? 'active' : '' }}"
                                                       onclick="toggleStatus(event, {{ $attendance->employe->id }}, 'Active')">
                                                       <i class="bi bi-check-circle"></i> Active
                                                   </button>
                                                   <button type="button"
                                                       class="toggle-btn absent {{ $isAbsent ? 'active' : '' }}"
                                                       onclick="toggleStatus(event, {{ $attendance->employe->id }}, 'absent')">
                                                       <i class="bi bi-x-circle"></i> Absent
                                                   </button>
                                               </div>
                                           </div>


                                       </div>
                                   </td>
                                   @php
                                       $isMarked = $attendance->markStatus === 'yes';
                                   @endphp

                                   <td>
                                       <span class="{{ $isMarked ? 'marked' : 'not-marked' }}">
                                           {{ $isMarked ? 'Marked' : 'Not Marked' }}
                                       </span>
                                   </td>

                                   <td>
                                       <div class="time-container p-2 border rounded bg-light">
                                           @php
                                               $nowDhaka = Carbon\Carbon::now('Asia/Dhaka')->format('H:i');

                                               $signInTime = $attendance->sign_in
                                                   ? Carbon\Carbon::parse($attendance->sign_in)
                                                       ->timezone('Asia/Dhaka')
                                                       ->format('H:i')
                                                   : $nowDhaka;

                                               $signOutTime = $attendance->sign_out
                                                   ? Carbon\Carbon::parse($attendance->sign_out)
                                                       ->timezone('Asia/Dhaka')
                                                       ->format('H:i')
                                                   : $nowDhaka; // Updated here
                                           @endphp


                                           <div class="time-row mb-2">
                                               <label class="time-label d-block mb-1 fw-semibold">Clock In</label>
                                               <input type="time"
                                                   class="form-control form-control-sm time-input clock-in"
                                                   value="{{ $signInTime }}" style="width: 120px;"
                                                   onchange="handleClockInChange({{ $attendance->employe->id }})">
                                           </div>

                                           <div class="time-row mb-2">
                                               <label class="time-label d-block mb-1 fw-semibold">Clock Out</label>
                                               <input type="time" style="width: 120px;"
                                                   class="form-control form-control-sm time-input clock-out"
                                                   value="{{ $signOutTime }}">
                                           </div>

                                           <div class="form-check checkbox-container">
                                               <input type="checkbox" name="lateStatus"
                                                   class="form-check-input late-arrival" id="late{{ $attendance->id }}"
                                                   {{ $isLate ? 'checked' : '' }}>
                                               <label class="form-check-label small" for="late{{ $attendance->id }}">
                                                   Late
                                               </label>
                                           </div>
                                       </div>
                                   </td>

                                   <td class="overtime-display">
                                       @if ($attendance->ot != null)
                                           <input type="text" name="ot" class="form-control form-control-sm ot"
                                               value="{{ $attendance->ot }}">
                                       @else
                                           @if ($overtimeHours > 0 || $overtimeMins > 0)
                                               <input type="text" name="ot"
                                                   class="form-control form-control-sm ot"
                                                   value="{{ $overtimeHours }} : {{ str_pad($overtimeMins, 2, '0', STR_PAD_LEFT) }}">
                                           @else
                                               <input type="text" name="ot"
                                                   class="form-control form-control-sm ot" value="">
                                           @endif
                                       @endif

                                   </td>

                                   <td>
                                       <button class="save-btn"
                                           onclick="saveAttendance({{ $attendance->employe->id }})">
                                           <i class="fa fa-check" aria-hidden="true"></i>

                                           <span class="spinner-border spinner-border-sm" role="status"
                                               aria-hidden="true"></span>
                                       </button>
                                   </td>
                               </tr>
                           @endif
                       @endforeach
                   </tbody>

               </table>
           </div>
           <div class="save-all-container"> <!-- Move the save button here -->
               <input type="hidden" id="attendanceDetails" name="attendanceDetails[]">
               <button type="button" id="update_attendence" class="btn btn-success" onclick="ajaxUpdateAttendance()">
                   <i class="fa fa-check"></i> Save All
               </button>
           </div>
       @endforeach
   @endif
