@php
    use App\Enums\Currency;
    use App\Enums\ShipmentStatus;
    use App\Models\Cost;
    use App\Utils\CarBrandUtils;
@endphp
@extends('admin.layouts.master')

@php
    $carBrandUtils = new CarBrandUtils()
@endphp

@section('content')
    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Receive Shipment</h4>
        </div>
        <div class="row">
            <div class="col-xxl-10 col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title">Total Vehicles {{ count($shipment->vehicles) }}</h6>
                        <div class="row">
                            <div class="col-xxl-4 col-xl-12">
                                <form action="{{ route('admin.shipment.receive.update', $shipment->id) }}" method="POST">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="provider" name="provider" value="{{ $shipment->provider }}" placeholder="{{ $shipment->provider }}" disabled>
                                        <label for="provider">Provider</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="shippingPort" name="shipping-port" value="{{ $shipment->shipping_port }}" placeholder="{{ $shipment->shipping_port }}" disabled>
                                        <label for="shippingPort">Shipping Port</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="destinationPort" name="destination-port" value="{{ $shipment->destination_port }}" placeholder="{{ $shipment->destination_port }}" disabled>
                                        <label for="destinationPort">Destination Port</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="selectStatus" name="selectStatus">
                                            @foreach(ShipmentStatus::cases() as $status)
                                                <option value="{{ $status->value }}" {{ $status->value === ShipmentStatus::RECEIVED->value ? 'selected' : '' }} >{{ strtoupper(str_replace('_', ' ', $status->value)) }}</option>
                                            @endforeach
                                        </select>
                                        <label for="selectStatus">Status</label>
                                    </div>
                                    <hr>
                                    @php
                                        $subtotalYen = 0;
                                        $subtotalTala = 0;
                                    @endphp

                                    @foreach(Cost::all() as $cost)
                                        @if($cost->currency == Currency::JPY->value)
                                            @php $subtotalYen += $cost->default_cost @endphp
                                        @else
                                            @php $subtotalTala += $cost->default_cost @endphp
                                        @endif
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control currency_{{ $cost->currency }}" id="{{ lcfirst(str_replace(' ', '', ucwords(strtolower($cost->name)))) }}" name="cost_{{ $cost->id }}" value="{{ $cost->default_cost }}" placeholder="{{ $cost->name }}">
                                            <label class="text-uppercase" for="{{ lcfirst(str_replace(' ', '', ucwords(strtolower($cost->name)))) }}">{{ $cost->name . ' (' . $cost->currency . ')' }}</label>
                                        </div>
                                    @endforeach

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="exchangeRate" name="exchange-rate" value="{{ $shipment->exchange_rate == 1 ? $wstToJpyRate : $shipment->exchange_rate }}" placeholder="{{ $shipment->exchange_rate }}">
                                        <label for="exchangeRate">Exchange Rate</label>
                                    </div>
                                    <hr>
                                    <div style="display: flex; justify-content: end">
                                        <article class="float-end">
                                            <dl class="dlist">
                                                <dt>Purchase Price JPY:</dt>
                                                <dd class="fw-bold">¥ {{ number_format($shipment->vehicles->sum('purchase_price'), 0) }}</dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt>Other Cost JPY:</dt>
                                                <dd class="fw-bold">¥ {{ number_format($subtotalYen, 0) }}</dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt>Subtotal Cost JPY:</dt>
                                                <dd class="fw-bold">¥ {{ number_format($shipment->vehicles->sum('purchase_price') + $subtotalYen, 0) }}</dd>
                                            </dl>
                                            <dl class="dlist bg-warning-subtle">
                                                <dt>Exchange Rate:</dt>
                                                <dd><b class="h7 fw-bold">{{ $wstToJpyRate }}</b></dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt>Converted Cost TALA:</dt>
                                                <dd class="fw-bold">WS$ {{ number_format(($shipment->vehicles->sum('purchase_price') + $subtotalYen) / $wstToJpyRate, 2) }}</dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt>Other Cost TALA:</dt>
                                                <dd class="fw-bold">WS$ {{ number_format($subtotalTala, 0) }}</dd>
                                            </dl>
                                            <dl class="dlist bg-success-subtle">
                                                <dt>Total Cost TALA:</dt>
                                                <dd>
                                                    <b class="h6 fw-bold">{{ number_format((($shipment->vehicles->sum('purchase_price') + $subtotalYen) / $wstToJpyRate) + $subtotalTala, 2) }}</b>
                                                </dd>
                                            </dl>
                                            <dl class="dlist">
                                                <dt class="text-muted">Status:</dt>
                                                <dd>
                                                    <span class="badge rounded-pill bg-warning text-black">Pending Shipment</span>
                                                </dd>
                                            </dl>
                                        </article>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary text-center">Update Shipment</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xxl-8 col-xl-12">
                                <div class="table-responsive">
                                    <table class="table table-striped vehicle-table mb-0">
                                        <thead class="table-light">
                                        <tr class="border-1 text-center">
                                            <th width="60" class="align-middle" scope="col">S/N</th>
                                            <th width="80" class="align-middle" scope="col">Logo</th>
                                            <th class="align-middle" scope="col">Make</th>
                                            <th class="align-middle" scope="col">Model</th>
                                            <th width="100" class="align-middle" scope="col">Year</th>
                                            <th class="align-middle" scope="col">Purchase Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!empty($shipment->vehicles))
                                            @foreach($shipment->vehicles as $vehicle)
                                                <tr>
                                                    <td class="text-center">{{$loop->index + 1}}</td>
                                                    <td class="d-flex justify-content-center align-items-center">
                                                        <img src="{{ $carBrandUtils->getCarThumbnail(strtolower($vehicle->make_title)) }}" alt="" width="40"/>
                                                    </td>
                                                    <td class="fw-bold">{{$vehicle->make_title}}</td>
                                                    <td>{{$vehicle->model_title}}</td>
                                                    <td class="text-center"><span>{{$vehicle->veh_year}}</span></td>
                                                    <td class="fw-bold text-primary-dark text-end">
                                                        ¥{{ number_format($vehicle->purchase_price ?? 0) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>No Data</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
