@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Import Shipment</h4>
        </div>
        <div class="row">
            <div class="col-xxl-10 col-lg-12">
                <div class="card px-0">
                    <div class="card-header bg-white">
                        <div class="col-xl-6 col-lg-9 col-md-12 ms-auto">
                            <form action="{{ route('admin.shipment.create') }}" method="GET">
                                @csrf
                                <div class="d-flex justify-content-end gap-2">
                                    <input
                                        type="text"
                                        name="booking-id"
                                        class="form-control border w-50"
                                        value="{{ request('booking-id', old('booking-id')) }}"
                                        placeholder="Enter Booking ID"
                                    />
                                    <button type="submit" class="btn btn-md rounded font-sm hover-up">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(!empty($shippingData))
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead class="bg-primary-subtle">
                                            <tr>
                                                <th class="text-center">S/N</th>
                                                <th>Provider Name</th>
                                                <th>Make</th>
                                                <th>Model</th>
                                                <th>Grade</th>
                                                <th>Chassis</th>
                                                <th>KM</th>
                                                <th>Year</th>
                                                <th>Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(optional($shippingData)->data)
                                                @foreach($shippingData->data as $key => $val)
                                                    <tr>
                                                        <td class="text-center">{{++$key}}</td>
                                                        <td>{{$val->provider}}</td>
                                                        <td>{{$val->make_title}}</td>
                                                        <td>{{$val->model_title}}</td>
                                                        <td>{{$val->grade?:'-'}}</td>
                                                        <td>{{$val->chassis_model.'-'.$val->chassis_number}}</td>
                                                        <td>{{$val->veh_km}}</td>
                                                        <td>{{$val->veh_year}}</td>
                                                        <td>¥{{$val->purchase_price}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="text-center text-danger" colspan="10">No data</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <aside class="col-lg-4">
                                    <div class="box bg-light px-4">
                                        <h6 class="mt-15 text-primary">Shipping Details</h6>
                                        <hr/>
                                        @if($shippingData->shipment)
                                            @foreach($shippingData->shipment as $key => $val)
                                                @php
                                                    $formattedKey = ucwords(str_replace('_', ' ', $key));
                                                @endphp
                                                <div class="d-flex">
                                                    <h6 class="mb-0 text-black">{{ $formattedKey }} : </h6>
                                                    <p class="ms-2 text-sm">{{$val}}</p>
                                                </div>
                                                <br/>
                                            @endforeach
                                        @endif
                                    </div>
                                    <hr class="my-4"/>
                                    <form action="{{route('admin.shipment.store')}}" method="post">
                                        @csrf
                                        <div class="d-flex justify-content-between">
                                            <p class="text-muted">{{"Message : $shippingData->message"}}</p>
                                            <input type="hidden" name="booking-id" value="{{$_GET['booking-id']}}">
                                            <button class="btn btn-primary">Import</button>
                                        </div>
                                    </form>
                                </aside>
                            </div>
                        @else
                            <p class="text-center">Please enter a booking id and click search to fetch data.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
