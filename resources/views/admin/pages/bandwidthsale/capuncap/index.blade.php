{{-- @dd($columns) --}}
@extends('admin.master')

@section('content')

    <section id="ajax-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">{{ $page_heading ?? 'List' }}</h4>
                        @if (isset($create_url) && $create_url)
                            <a href="{{ $create_url ?? '#' }}" class="btn btn-rounded btn-info text-right">
                                <span class="btn-icon-start text-white">
                                    <i class="fa fa-plus"></i>
                                </span>
                                Add
                            </a>
                        @endif

                    </div>
                    <div class="card-datatable table-responsive">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="buttons">
                                </div>
                            </div>
                        </div>
                        <table id="server_side_lode" class="table">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Customer</th>
                                    <th>Create By</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($model as $item)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <th>{{$item->customer->company_name ?? ""}}</th>
                                    <th>{{$item->createby->name ?? ""}}</th>
                                    <th>
                                       @if($item->status == "pending")
                                       <button type="button" class="btn btn-warning">Pending</button>
                                       @elseif($item->status == "reject")
                                       <button type="button" class="btn btn-danger">Reject</button>
                                       @else
                                       <button type="button" class="btn btn-success">approve</button>
                                       @endif
                                    </th>
                                    <th>
                                      <a href="{{route('capuncap.show', $item->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
