@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Vehicle List</h4>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="table-light">
                            <tr>
                                <th class="align-middle" scope="col">S/N</th>
                                <th class="align-middle" scope="col">Make</th>
                                <th class="align-middle" scope="col">Model</th>
                                <th class="align-middle" scope="col">Chassis Model</th>
                                <th class="align-middle" scope="col">Chassis Number</th>
                                <th class="align-middle" scope="col">Grade</th>
                                <th class="align-middle" scope="col">Fuel</th>
                                <th class="align-middle" scope="col">Transmission</th>
                                <th class="align-middle" scope="col">Traction</th>
                                <th class="align-middle" scope="col">Millage</th>
                                <th class="align-middle" scope="col">CC</th>
                                <th class="align-middle" scope="col">Year</th>
                                <th class="align-middle" scope="col">Month</th>
                                <th class="align-middle" scope="col">Color</th>
                                <th class="align-middle" scope="col">Net Weight</th>
                                <th class="align-middle" scope="col">Gross Weight</th>
                                <th class="align-middle" scope="col">Purchase Price</th>
                                <th class="align-middle text-center" scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($vehicles) && $vehicles->count())
                                @foreach($vehicles as $vehicle)
                                    <tr>
                                        <td><a href="#" class="fw-bold text-black">{{$vehicle->id}}</a></td>
                                        <td><span class="badge badge-pill bg-success-subtle text-black fw-bold text-uppercase" style="font-size: 11px">{{$vehicle->make_title}}</span></td>
                                        <td><span class="badge badge-pill bg-primary-subtle text-black fw-bold text-uppercase" style="font-size: 11px">{{$vehicle->model_title}}</span></td>
                                        <td>{{$vehicle->chassis_model}}</td>
                                        <td>{{$vehicle->chassis_number}}</td>
                                        <td>{{$vehicle->grade}}</td>
                                        <td>{{$vehicle->veh_fuel}}</td>
                                        <td>{{$vehicle->veh_trans}}</td>
                                        <td>{{$vehicle->veh_traction}}</td>
                                        <td>{{$vehicle->veh_km}}</td>
                                        <td>{{$vehicle->veh_cc}}</td>
                                        <td><span class="badge badge-pill bg-danger fw-bold">{{$vehicle->veh_year}}</span></td>
                                        <td>{{$vehicle->veh_month}}</td>
                                        <td>{{$vehicle->veh_color}}</td>
                                        <td>{{$vehicle->net_weight}}</td>
                                        <td>{{$vehicle->gross_weight}}</td>
                                        <td class="text-end px-4 text-primary-emphasis fw-bolder">¥{{ number_format($vehicle->purchase_price ?? 0) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.part.edit', $vehicle->id) }}" class="btn btn-xs bg-primary text-center">Parts</a>
                                            <a href="{{ route('admin.vehicle.show', $vehicle->id) }}" class="btn btn-xs text-center">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-danger text-center" colspan="18">no data found!!!</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- table-responsive end// -->
            </div>
        </div>

    </section>

@endsection
