@extends('admin.master')

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
                <h5>Package</h5>
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
                            <th scope="col">
                                <small class="text-secondary">Price</small>
                            </th>
                            <th scope="col">
                                <small class="text-secondary">Old Total</small>
                            </th>
                            <th scope="col">
                                <small class="text-secondary">New Total</small>
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
                            <td>{{ $package->asking_price[$key] ?? '' }}</td>
                            @php
                             $oldtotal += $oldsubtotal = $package->old_quantity[$key]  *  $package->asking_price[$key];
                             $total += $subtotal = ($package->old_quantity[$key] + $package->quantity[$key] ) *  $package->asking_price[$key];
                            @endphp
                            <td>{{ $oldsubtotal ?? '' }}</td>
                            <td>{{ $subtotal ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total:</td>
                            <td>{{$oldtotal}}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    <form action="{{route('upgradation.update',$editOption->id)}}">
       <div class="col-md-12">
          <div class="card">
             <div class="card-body">
               <label for="">Apply Date</label>
               <input type="date" name="date" class="form-control" value="{{$editOption->apply_date}}"">
             </div>
             <button class="mt-2 btn btn-success">Approve</button>
          </div>
       </div>
    </form>
</div>

@endsection
