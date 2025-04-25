@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Vehicle</h4>
        </div>

        <div class="col-md-12 col-xxl-8">
            <div class="card mb-4">
                <div class="card mb-4 rounded-0">
                    <div class="card-header bg-brand-1" style="height: 150px"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl col-lg flex-grow-0" style="flex-basis: 200px">
                                <div class="img-thumbnail shadow-sm w-100 bg-white position-relative text-center" style="height: 190px; width: 200px; margin-top: -120px">
                                    <img src="{{ $brandLogo }}" class="center-xy img-thumbnail" alt="Logo Brand">
                                </div>
                            </div>
                            <div class="col-xl col-lg">
                                <h3>{{ $vehicle->make_title }}</h3>
                                <p>{{ $vehicle->model_title }}</p>
                            </div>
                            <div class="col-xl col-lg text-md-end">
                                <a href="{{ route('admin.shipment.index', $vehicle->shipment->id) }}" class="btn btn-primary">View Shipment</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th class="align-middle" scope="col">S/N</th>
                                    <th class="align-middle" scope="col">Make</th>
                                    <th class="align-middle" scope="col">Model</th>
                                    <th class="align-middle" scope="col">Chassis</th>
                                    <th class="align-middle" scope="col">Fuel</th>
                                    <th class="align-middle" scope="col">Transmission</th>
                                    <th class="align-middle" scope="col">Traction</th>
                                    <th class="align-middle" scope="col">Millage</th>
                                    <th class="align-middle" scope="col">CC</th>
                                    <th class="align-middle" scope="col">Year</th>
                                    <th class="align-middle" scope="col">Color</th>
                                    <th class="text-end" scope="col">P. JPY</th>
                                    <th class="text-end" scope="col">Ex. Rate</th>
                                    <th class="text-end" scope="col">P. Tala</th>
                                    <th class="align-middle text-center" scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <a href="#" class="fw-bold text-black">{{$vehicle->id}}</a>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill bg-success-subtle text-black fw-bold text-uppercase" style="font-size: 11px">{{$vehicle->make_title}}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill bg-primary-subtle text-black fw-bold text-uppercase" style="font-size: 11px">{{$vehicle->model_title}}</span>
                                    </td>
                                    <td>{{$vehicle->chassis_model . '-' . $vehicle->chassis_number}}</td>
                                    <td>{{$vehicle->veh_fuel}}</td>
                                    <td>{{$vehicle->veh_trans}}</td>
                                    <td>{{$vehicle->veh_traction}}</td>
                                    <td>{{$vehicle->veh_km}}</td>
                                    <td>{{$vehicle->veh_cc}}</td>
                                    <td><span class="badge badge-pill bg-danger fw-bold">{{$vehicle->veh_year}}</span></td>
                                    <td>{{$vehicle->veh_color}}</td>
                                    <td class="text-end text-primary-emphasis fw-bolder">¥ {{ number_format($vehicle->purchase_price ?? 0) }}</td>
                                    <td><span class="badge bg-primary text-white fw-bold" style="font-size: 11px">¥ {{ number_format($vehicle->shipment->exchange_rate ?? 0 , 2) }}</span></td>
                                    <td class="text-end text-primary fw-bolder" style="font-size: 14px">$ {{ number_format($vehicle->purchase_price / $vehicle->shipment->exchange_rate  ?? 0) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.part.edit', $vehicle->id) }}" class="btn btn-xs bg-warning text-center text-black fw-bold text-uppercase">Edit Parts</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-parts">
                                <thead class="table-light">
                                <tr>
                                    <th class="text-center border-1">S/N</th>
                                    <th class="border-1">Part Name</th>
                                    <th class="border-1 text-center">Price</th>
                                    <th class="border-1 text-center">B. Qty</th>
                                    <th class="border-1 text-center">Qty Sold</th>
                                    <th class="border-1 text-center">Remaining</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vehicle->parts as $part)
                                    <tr class="border-1">
                                        <td class="text-center border-1" width="40">{{ $part->partCategory->id }}</td>
                                        <td class="border-1 fw-bold px-4">{{ $part->partCategory->name }}</td>
                                        <td class="text-end">$ {{ $part->price }}</td>
                                        <td class="border-1 text-center fw-bold">{{ $part->quantity }}</td>
                                        <td class="border-1 text-center"> {{ $part->sales->sum(function ($sale){ return $sale->pivot->quantity_sold; }) }} </td>
                                        <td class="text-center">{{ $part->quantity - $part->sales->sum(function ($sale){ return $sale->pivot->quantity_sold; }) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
