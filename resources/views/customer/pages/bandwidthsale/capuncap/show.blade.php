@extends('customer.master')

@section('content')
<div class="row text-center">
    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">{{ $page_heading ?? 'List' }}</h4>
                <a href="{{ $back_url ?? 'javascript:;' }}" class="btn btn-dark">Back</a>
            </div>
            <div class="card-body">
                <x-alert></x-alert>

                <div class="col-md-12 mb-1">

                         @php
                           $package = json_decode($editOption->package);
                         @endphp
                    <div class="card">
                        <div class="card-body">
                            <h5>Package</h5> <p>Duration : {{$editOption->apply_date}}</p>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <small class="text-secondary">Item</small>
                                        </th>
                                        <th scope="col">
                                            <small class="text-secondary">Old Quantity</small>
                                        </th>
                                        <th scope="col">
                                            <small class="text-secondary">New Quantity</small>
                                        </th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $oldtotal = 0;
                                        $total = 0;
                                    @endphp
                                    @foreach ($package->item_id as $key => $value)
                                        @php
                                            $item = App\Models\Item::find($value);
                                        @endphp
                                    <tr>
                                        <td>{{ $item->name ?? '' }}</td>
                                        <td>{{ $package->old_quantity[$key] ?? '' }}</td>
                                        <td>{{ $package->old_quantity[$key] + $package->quantity[$key] ?? '' }}</td>
                                        @php
                                            $oldtotal += $package->old_quantity[$key] + $package->quantity[$key] ?? 0;
                                        @endphp
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>Total:</td>
                                        <td>{{$oldtotal}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row text-center">
    <div class="col-md-12">
        <div class="card mt-3">
            <div class="card-body">

            </div>
        </div>
    </div>
</div>
@endsection
