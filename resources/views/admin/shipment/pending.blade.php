@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Pending Shipment</h4>
        </div>
        <div class="row">
            <div class="col-xxl-10 col-lg-12">
                <div class="card px-0">
                    <div class="card-body">
                        @if(!empty($pending_shipment['shipment_data']))
                            @foreach($pending_shipment['shipment_data'] as $bookingId => $shippingData)
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead class="bg-primary-subtle">
                                                <tr>
                                                    <th class="text-center">S/N</th>
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
                                                @foreach($shippingData['vehicles'] as $key => $val)
                                                    @php
                                                        $val = (object) $val;
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center fw-bold">{{++$key}}</td>
                                                        <td>{{$val->make_title}}</td>
                                                        <td>{{$val->model_title}}</td>
                                                        <td>{{$val->grade?:'-'}}</td>
                                                        <td>{{$val->chassis_model.'-'.$val->chassis_number}}</td>
                                                        <td>{{$val->veh_km}}</td>
                                                        <td>{{$val->veh_year}}</td>
                                                        <td>¥{{$val->purchase_price}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <aside class="col-lg-4">
                                        <div class="box bg-light px-4">
                                            <h6 class="mt-15 text-primary">Shipping Details</h6>
                                            <hr/>
                                            @if($shippingData['shipment'])
                                                @foreach($shippingData['shipment'] as $key => $val)
                                                    @php
                                                        $formattedKey = ucwords(str_replace('_', ' ', $key));
                                                    @endphp
                                                    <div class="d-flex mb-1">
                                                        <h6 class="mb-0 text-black">{{ $formattedKey }} : </h6>
                                                        <p class="ms-2 text-sm">{{$val}}</p>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <hr class="my-4"/>
                                        <form action="{{route('admin.shipment.store')}}" method="post">
                                            @csrf
                                            <div class="d-flex justify-content-center">
                                                <input type="hidden" name="booking-id" value="{{$bookingId}}">
                                                <button class="btn btn-primary">Import</button>
                                            </div>
                                        </form>
                                    </aside>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">No pending booking left</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
