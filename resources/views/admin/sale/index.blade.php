@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">All Sales</h4>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-nowrap mb-0" style="white-space: nowrap">
                            <thead class="table-light">
                            <tr class="border-1 text-uppercase">
                                <th class="align-middle" scope="col">S/N</th>
                                <th class="align-middle text-center" scope="col">Date</th>
                                <th class="align-middle" scope="col">Part Information</th>
                                <th class="align-middle text-center" scope="col">Total Unit</th>
                                <th class="align-middle text-end" scope="col">Total Price</th>
                                <th class="align-middle text-end" scope="col">Selling Price</th>
                                <th class="align-middle text-end" scope="col">Discount</th>
                                <th class="align-middle" scope="col">Comments</th>
                                <th class="align-middle text-center" scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($sales) && $sales->count())
                                @foreach($sales as $sale)
                                    <tr class="border-1">
                                        <td class="text-center fw-bolder text-primary-emphasis" width="40">{{ ++$loop->index }}</td>
                                        <td class="text-center"><span class="badge bg-primary fw-bolder" style="font-size: 12px">{{ date('Y-m-d', strtotime($sale->sold_at) ) }}</span></td>
                                        <td>
                                            <table class="table-sub-sale" style="min-width: 900px">
                                                <thead>
                                                <tr class="border-1">
                                                    <th class="align-middle px-4" scope="col">Name</th>
                                                    <th class="align-middle" scope="col">Make</th>
                                                    <th class="align-middle" scope="col">Model</th>
                                                    <th class="align-middle" scope="col">Chassis</th>
                                                    <th class="align-middle" scope="col">Year</th>
                                                    <th class="align-middle" scope="col">Unit</th>
                                                    <th class="align-middle text-end px-4" scope="col">Price</th>
                                                </tr>
                                                </thead>
                                                @foreach($sale->parts as $part)
                                                    @if($loop->index === 0)
                                                    @endif
                                                    <tr class="border-1">
                                                        <td width="200" class="px-2 fw-bold text-primary-emphasis">{{ $part->partCategory->name }}</td>
                                                        <td width="150">
                                                            <a href="{{ route('admin.vehicle.show', $part->vehicle->id) }}"
                                                               class="badge badge-pill bg-success-subtle text-black fw-bold text-uppercase"
                                                               style="font-size: 11px">{{ $part->vehicle->make_title }}</a>
                                                        </td>
                                                        <td width="150">
                                                            <span class="badge badge-pill bg-primary-subtle text-black fw-bold text-uppercase" style="font-size: 11px">{{ $part->vehicle->model_title }}</span>
                                                        </td>
                                                        <td width="150">{{ $part->vehicle->chassis_model . '-' . $part->vehicle->chassis_number }}</td>
                                                        <td width="100">
                                                            <span class="badge badge-pill bg-danger fw-bold">{{ $part->vehicle->veh_year }}</span>
                                                        </td>
                                                        <td width="50">{{ $part->pivot->quantity_sold }}</td>
                                                        <td width="100" class="text-end px-4 text-primary-emphasis fw-bolder">$ {{ number_format($part->pivot->price_at_sale, 0) }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td class="fw-bolder text-center">{{ $sale->quantity_sold }}</td>
                                        <td class="fw-bolder text-end fw-bold text-primary-emphasis fs-6">$ {{ number_format($sale->parts->sum(function ($part){ return $part->pivot->price_at_sale * $part->pivot->quantity_sold ;}), 0) }}</td>
                                        <td class="fw-bolder text-end fw-bold text-primary-emphasis fs-6">$ {{ $sale->price_at_sale }}</td>
                                        <td class="fw-bolder text-end fw-bold text-primary-emphasis fs-6">$ {{ number_format($sale->parts->sum(function ($part){ return $part->pivot->price_at_sale * $part->pivot->quantity_sold ;}) - $sale->price_at_sale, 0) }}</td>
                                        <td width="400"><textarea class="bg-white text-black p-1" cols="50" rows="4" disabled>{{ $sale->comment }}</textarea></td>
                                        <td>
                                            <a href="{{ route('admin.part.edit', $sale->id) }}" class="btn btn-xs text-center">Vehicle details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center text-danger" colspan="8">no sale data found!!!</td>
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
