@extends('admin.master')

@section('content')
    <style>
        .file-preview img {
            width: 100%;
            height: auto;
            display: block;
        }

        .file-preview i {
            font-size: 5rem;
            display: block;
            margin: 0 auto;
        }

        .file-preview p {
            text-align: center;
            margin-top: 10px;
        }
    </style>
    <div class="row">
        <div class="container">
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('General Information') }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless table-striped" style="font-size: 0.8rem;">
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Company Name') }}</th>
                                        <td class="col-8 px-1">

                                            <span>{{ $customer->company_name ?? 'N/A' }}</span>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Name Of Client') }}</th>
                                        <td class="col-8 px-1">
                                            <span>{{ $customer->company_owner_name ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="col-4 px-1">{{ __('Phone') }}</th>
                                        <td class="col-8 px-1">
                                            <span> {{ $customer->company_owner_phone ?? 'N/A' }}
                                            </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="col-4 px-1 mt-0 pt-0">{{ __('Registered Address') }}</th>
                                        <td class="col-8 px-1">
                                            <span>{{ $customer->customer_address ?? 'N/A' }}</span>
                                            <br>
                                        </td>
                                    </tr>
                                </table>
                                <hr>
                                <div class="">
                                    <table class="table table-borderless table-striped" style="font-size: 0.8rem;">

                                        @php
                                            $message = \App\Models\TickerMessage::where(
                                                'ticket_id',
                                                $supportticket->id,
                                            )->get();
                                        @endphp

                                        <thead>
                                            <tr>
                                                <td>Time</td>
                                                <td>Note</td>
                                                <td>Create By</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($message as $key => $value)
                                                <tr>
                                                    <th>{{ $value->created_at }}</th>
                                                    <th>{{ $value->remark }}</th>
                                                    <th>{{ $value->assignUser->name ?? '' }}</th>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Ticket Info') }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Problem: </td>
                                        <td>{{ $supportticket->problem->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Complain: </td>
                                        <td>{{ $supportticket->note ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Complain Time: </td>
                                        <td>{{ $supportticket->complain_time ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Working Person: </td>
                                        <td>{!! $supportticket->assignUser->name ??
                                            '<a  onclick="return confirm(`Are you sure you would like to accept this reply as your favor?`);" href=" ' .
                                                route('supportticket.assign', $supportticket->id) .
                                                '" class="btn btn-warning btn-sm">No One</a>' !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Status: </td>
                                        <td>{{ $supportticket->supportstatus->name ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Remark</td>
                                        <td>
                                            @php
                                                $message = explode(',', $supportticket->remark ?? '');
                                            @endphp
                                            @foreach ($message as $key => $value)
                                                <p>{{ $value }}</p>
                                                <hr>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Duration: </td>
                                        @php
                                            $startDateTime = \Carbon\Carbon::parse($supportticket->complain_time);
                                            $endDateTime = \Carbon\Carbon::parse(
                                                $supportticket->complete_time ?? now(),
                                            );
                                            $duration = $startDateTime->diff($endDateTime);
                                            $format = $duration->format('Day:(%d) - Time: %h:%i %s s');
                                        @endphp
                                        <td>{{ $format }}</td>
                                    </tr>
                                    <tr>
                                        <td>

                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                @if ($supportticket->attachments)
                    <div class="row">
                        <label> Files</label>
                        @foreach (json_decode($supportticket->attachments, true) as $filePath)
                            <div class="col-3">
                                <div class="file-preview text-center">
                                    {!! getFileIcon($filePath) !!}
                                    <a href="{{ $filePath }}" download class="btn btn-secondary btn-sm">Download</a>
                                    <div class="mt-2">
                                        <input type="checkbox" name="remove_files[]" value="{{ $filePath }}"> Remove
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
