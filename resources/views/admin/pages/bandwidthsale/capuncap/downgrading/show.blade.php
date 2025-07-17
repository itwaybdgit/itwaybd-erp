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
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col" width="25%">
                            <small class="text-secondary" >Item</small>
                        </th>
                        <th scope="col" width="20%">
                            <small class="text-secondary" >Quantity</small>
                        </th>
                        <th scope="col" width="20%">
                            <small class="text-secondary" >Price</small>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                        @php
                            $package = json_decode($editOption->package);
                        @endphp
                        @foreach ($package->item_id as $key => $val)
                        <tr>
                            <th scope="row">
                                <select name="item_id[]" class="form-control item_id">
                                <option value="">Select</option>
                                @foreach ($items as $item)
                                    <option {{$val == $item->id ? "selected":""}} value="{{ $item->id }}">{{ $item->name }}
                                    </option>
                                @endforeach
                               </select>
                            </th>
                            <td>{{$package->quantity[$key] ?? 0}}</td>
                            <td>{{$package->asking_price[$key] ?? 0}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>

            </div>
        </div>
    </div>
    <form action="{{route('downgrading.update',$editOption->id)}}">
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
