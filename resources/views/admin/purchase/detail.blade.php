@php use App\Models\Category; @endphp
@extends('admin.layouts.master')

@section('content')
<style>
    .data-table-head th{
        width: 200px;
    }
    </style>
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Purchase Invoice No. : {{ $data->invoice_number }}</h4>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Purchase information <a href="{{ route('admin.purchase.edit', $data->id) }}" class="btn btn-sm font-sm rounded btn-dark">
                                <i class="material-icons md-edit fs-6"></i> Edit
                            </a></h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-5 col-xl-5">

                                <table class="table table-striped table-hover">
                                    <thead class="data-table-head">
                                    <tr>
                                        <th scope="col">Purchase/Invoice Date :</th>
                                        <th scope="col">{{ $data->invoice_date }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Port of Loading:</th>
                                        <th scope="col">{{ $data->port_of_loading }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Destination:</th>
                                        <th scope="col">{{ $data->port_of_landing }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Country of Destination:</th>
                                        <th scope="col">{{ $data->country_of_destination }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">IncoTerm:</th>
                                        <th scope="col">{{ $data->incoterm }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Provider Name:</th>
                                        <th scope="col">{{ $data->provider->provider_name ?? 'N/A' }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Container Type:</th>
                                        <th scope="col">{{ $data->container_type }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">BL Number:</th>
                                        <th scope="col">{{ $data->bl_number }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Shipping Line:</th>
                                        <th scope="col">{{ $data->shipping_line }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Vessel:</th>
                                        <th scope="col">{{ $data->vessel }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">ETD:</th>
                                        <th scope="col">{{ $data->etd }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">ETA:</th>
                                        <th scope="col">{{ $data->eta }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Freight $:</th>
                                        <th scope="col">{{ $data->freight }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Insurance $:</th>
                                        <th scope="col">{{ $data->insurance }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Exchange Rate $:</th>
                                        <th scope="col">{{ $data->exchange_rate }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Duties $:</th>
                                        <th scope="col">{{ $data->duties }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Tax $:</th>
                                        <th scope="col">{{ $data->tax }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Unpack $:</th>
                                        <th scope="col">{{ $data->unpack }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Transport $:</th>
                                        <th scope="col">{{ $data->transport }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Penalty $:</th>
                                        <th scope="col">{{ $data->penalty }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Other Fee $:</th>
                                        <th scope="col">{{ $data->other_fee }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Total Cost $:</th>
                                        @php
                                            $totalCost = ($data->freight ?? 0) +
                                                         ($data->insurance ?? 0) +
                                                         ($data->duties ?? 0) +
                                                         ($data->tax ?? 0) +
                                                         ($data->unpack ?? 0) +
                                                         ($data->transport ?? 0) +
                                                         ($data->penalty ?? 0) +
                                                         ($data->other_fee ?? 0);
                                        @endphp
                                        <th scope="col">{{ number_format($totalCost, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Comments:</th>
                                        <th scope="col">{{ $data->shipment_comment }}</th>
                                    </tr>
                                    </thead>
                                </table>
                                @php
                                    $lots = $data->lots;
                                    $groupedByContainer = [];
                                    if ($lots->isNotEmpty()) {
                                        foreach ($lots as $lot) {
                                            if (strlen($lot->lot_unique) >= 2) {
                                                $containerIndex = (int) substr($lot->lot_unique, -2, 1);
                                                $lotIndex = (int) substr($lot->lot_unique, -1, 1);
                                                if ($containerIndex > 0) {
                                                    $groupedByContainer[$containerIndex][$lotIndex] = $lot;
                                                }
                                            }
                                        }
                                        ksort($groupedByContainer);
                                    }
                                @endphp

                                @if (!empty($groupedByContainer))
                                    @foreach ($groupedByContainer as $containerIndex => $lotsInContainer)
                                        @php ksort($lotsInContainer); @endphp
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h4>Container No. {{ $containerIndex }}</h4>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($lotsInContainer as $lotIndex => $lot)
                                                    @php
                                                        $lotPhoto = \App\Models\lot_photos::where('lot_unique', $lot->lot_unique)->first();
                                                        $item = \App\Models\Item::find($lot->item_id);
                                                    @endphp
                                                        <h5 class="mb-3">Lot No. {{ $loop->iteration }}</h5>
                                                    <table class="table table-bordered">
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                @if($lotPhoto)
                                                                    <img style="max-height:120px; max-width: 120px;" src="{{url('/storage/'.$lotPhoto->photo_url)}}">
                                                                @else
                                                                    <img style="max-height:120px; max-width: 120px;" src="{{url('/assets/imgs/item_placeholder.jpg')}}">
                                                                @endif
                                                            </td>
                                                        </tr>
                                                            <tr>
                                                                <th style="width: 20%;">Product</th>
                                                                <td>{{ $item ? $item->item_name : 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Package Type</th>
                                                                <td>{{ $lot->type_of_package }}</td>
                                                            </tr>
                                                             <tr>
                                                                <th>Package (KG)</th>
                                                                <td>{{ $lot->package_kg }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total Packages</th>
                                                                <td>{{ $lot->total_packages }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total Qty (KG)</th>
                                                                <td>{{ $lot->total_qty }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Price Per Unit</th>
                                                                <td>${{ number_format($lot->price_per_unit, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total Price</th>
                                                                <td>${{ number_format($lot->total_price, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Manufacture Date</th>
                                                                <td>{{ $lot->manufacture_date}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Crop Year</th>
                                                                <td>{{ $lot->crop_year}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Shelf Life</th>
                                                                <td>{{ $lot->shelf_life}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Best Before</th>
                                                                <td>{{ $lot->best_before}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Surveyor Name</th>
                                                                <td>{{ $lot->surveyor_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Loading Date</th>
                                                                <td>{{ $lot->loading_date}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th>Comment</th>
                                                                <td>{{ $lot->lot_comment }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Description</th>
                                                                <td>{{ $lot->item_description}}</td>
                                                            </tr>
                                                        <tr>
                                                            <th>Loading Report</th>
                                                            <td>
                                                                @if(!empty($lot->loading_report))
                                                                    <a target="_blank" href="{{ url('/storage/'.$lot->loading_report) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                                        <i class="material-icons md-picture_as_pdf fs-6"></i>Download
                                                                    </a>
                                                                @else
                                                                    <span class="badge rounded-pill alert-warning">Not Uploaded</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No lots found for this shipment.</p>
                                @endif
                            </div>

                                <div class="col-lg-6 col-xl-6">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th colspan="2" scope="col">Documents</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="p-2">Commercial Invoice</td>
                                            <td class="p-2">
                                                @if(!empty($data->commercial_invoice))
                                                    <a target="_blank" href="{{url('/'.$data->commercial_invoice)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> JAS
                                                    </a>
                                                @endif
                                                @if(!empty($data->organic_certification_jas_exporter_nop))
                                                    <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_nop)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> NOP
                                                    </a>
                                                @endif
                                                @if(!empty($data->organic_certification_jas_exporter_cor))
                                                    <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_cor)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> COR
                                                    </a>
                                                @endif
                                                @if(!empty($data->organic_certification_jas_exporter_eu))
                                                    <a target="_blank" href="{{url('/'.$data->organic_certification_jas_exporter_eu)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> EU
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
{{--                                        <tr>--}}
{{--                                            <td class="p-2">PRODUCER ORGANIC CERTIFICATION</td>--}}
{{--                                            <td class="p-2">--}}
{{--                                                @if(!empty($data->producer_organic_certification_jas))--}}
{{--                                                    <a target="_blank" href="{{url('/'.$data->producer_organic_certification_jas)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">--}}
{{--                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> JAS--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                                @if(!empty($data->producer_organic_certification_nop))--}}
{{--                                                    <a target="_blank" href="{{url('/'.$data->producer_organic_certification_nop)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">--}}
{{--                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> NOP--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                                @if(!empty($data->producer_organic_certification_cor))--}}
{{--                                                    <a target="_blank" href="{{url('/'.$data->producer_organic_certification_cor)}}" class="btn btn-youtube font-sm btn-outline-danger mr-10">--}}
{{--                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> COR--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                                @if(!empty($data->producer_organic_certification_eu))--}}
{{--                                                    <a target="_blank" href="{{url('/'.$data->producer_organic_certification_eu)}}" class="btn btn-youtube font-sm btn-outline-danger">--}}
{{--                                                        <i class="material-icons md-picture_as_pdf fs-6"></i> EU--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
                                        <tr>
                                            <td class="p-2">BL / Telex Release</td>
                                            <td class="p-2">
                                                @if(!empty($data->bl_telex_release))
                                                    <a target="_blank" href="{{url('/'.$data->bl_telex_release)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i>Download
                                                    </a>
                                                @else
                                                    <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                        Not Uploaded
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">Packing List</td>
                                            <td class="p-2">
                                                @if(!empty($data->packing_list))
                                                    <a target="_blank" href="{{url('/'.$data->packing_list)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i>Download
                                                    </a>
                                                @else
                                                    <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                        Not Uploaded
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">Origin Certificate</td>
                                            <td class="p-2">
                                                @if(!empty($data->origin_certificate))
                                                    <a target="_blank" href="{{url('/'.$data->origin_certificate)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i>Download
                                                    </a>
                                                @else
                                                    <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                        Not Uploaded
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="p-2">Phytosanitary</td>
                                            <td class="p-2">
                                                @if(!empty($data->phytosanitary))
                                                    <a target="_blank" href="{{url('/'.$data->phytosanitary)}}" class="btn btn-youtube font-sm btn-outline-danger">
                                                        <i class="material-icons md-picture_as_pdf fs-6"></i>Download
                                                    </a>
                                                @else
                                                    <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                        Not Uploaded
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>


                                        </tbody>
                                    </table>

                                </div>
                            </div>


                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
