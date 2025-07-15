@extends('admin.layouts.master')

@php use App\Models\Countries; @endphp
@php use App\Models\Provider; @endphp
@php use App\Models\Item; @endphp
@php use App\Models\DataIncoterm; @endphp
@php use App\Models\DataContainerType; @endphp
@php use App\Models\DataShelflife; @endphp
@php use App\Models\DataPackageType; @endphp

@php
    $items = array();
    $timestamp = time();

    foreach (Item::orderBy('item_name')->get() as $p){
        $items[] = $p;
    }

   // \Barryvdh\Debugbar\Facades\Debugbar::info($items);
@endphp

@section('content')
    <link href="{{url('assets/filepond/filepond.css')}}" rel="stylesheet" />

    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Edit Purchase</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <form action="{{ route('admin.purchase.update', $shipment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Please enter purchase information</h5>
                                <div class="row mb-4">
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="invoice_number" class="form-label">Purchase/Invoice No.</label>
                                        <input type="text" placeholder="" class="form-control" id="invoice_number"
                                               name="invoice_number"  value="{{ empty(old('invoice_number')) ?? $shipment->invoice_number }}" required>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="invoice_date" class="form-label">Purchase/Invoice Date</label>
                                        <input type="date" placeholder="" class="form-control" id="invoice_date"
                                               name="invoice_date"  value="{{ empty(old('invoice_date')) ? $shipment->invoice_date : old('invoice_date') }}" required>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="port_of_loading" class="form-label">Port of Loading</label>
                                        <select class="form-select" id="port_of_loading" name="port_of_loading">
                                            <option value="">Select</option>
                                            <option value="Lima" {{ $shipment->port_of_loading == 'Lima' ? 'selected' : '' }}>Lima</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="port_of_landing" class="form-label">Port of Landing</label>
                                        <select class="form-select" id="port_of_landing" name="port_of_landing"  >
                                            <option value="">Select</option>
                                            <option value="Yokohama" {{ $shipment->port_of_landing == 'Yokohama' ? 'selected' : '' }}>Yokohama</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="country_of_destination" class="form-label">Country of Destination</label>
                                        <select class="form-select" id="country_of_destination" name="country_of_destination"  >
                                            <option value="">Select</option>
                                            @foreach(Countries::orderBy('country_name')->whereIn('country_name', ['Japan'])->get() as $p)
                                                <option value="{{ $p->country_name }}" {{ $shipment->country_name == $p->country_name ? 'selected' : '' }}>{{ $p->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="incoterm" class="form-label">IncoTerm</label>
                                        <select class="form-select" id="incoterm" name="incoterm"  >
                                            <option value="">Select</option>
                                            @foreach(DataIncoterm::orderBy('incoterm')->get() as $p)
                                                <option value="{{ $p->incoterm }}" {{ $shipment->incoterm == $p->incoterm ? 'selected' : '' }}>{{ $p->incoterm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="provider_id" class="form-label">Provider Name</label>
                                        <select class="form-select" id="provider_id" name="provider_id"  value="{{ old('provider_id') }}" required>
                                            <option value="">Select</option>
                                            @foreach(Provider::orderBy('provider_name')->get() as $p)
                                                <option value="{{ $p->id }}" {{ $shipment->provider_id == $p->id ? 'selected' : '' }}>{{ $p->provider_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="container_type" class="form-label">Container Type</label>
                                        <select class="form-select" id="container_type" name="container_type"  >
                                            <option value="">Select</option>
                                            @foreach(DataContainerType::orderBy('container_type')->get() as $p)
                                                <option value="{{ $p->container_type }}" {{ $shipment->provider_name == $p->container_type ? 'selected' : '' }}>{{ $p->container_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="bl_number" class="form-label">BL Number</label>
                                        <input type="text" class="form-control" id="bl_number" name="bl_number"  value="{{ $shipment->bl_number }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="shipping_line" class="form-label">Shipping Line</label>
                                        <input type="text" class="form-control" id="shipping_line" name="shipping_line"  value="{{ $shipment->shipping_line }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="vessel" class="form-label">Vessel</label>
                                        <input type="text" class="form-control" id="vessel" name="vessel"  value="{{ $shipment->vessel }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="commercial_invoice" class="form-label">Commercial Invoice</label>
                                        <input type="file" class="form-control" id="commercial_invoice" name="commercial_invoice"  value="{{ $shipment->commercial_invoice }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="eta" class="form-label">ETA</label>
                                        <input type="date" class="form-control" id="eta" name="eta" value="{{ $shipment->eta }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="etd" class="form-label">ETD</label>
                                        <input type="date" class="form-control" id="etd" name="etd"  value="{{ $shipment->etd }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="bl_telex_release" class="form-label">BL / Telex Release</label>
                                        <input type="file" class="form-control" id="bl_telex_release" name="bl_telex_release"  value="{{ $shipment->bl_telex_release }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="packing_list" class="form-label">Packing List</label>
                                        <input type="file" class="form-control" id="packing_list" name="packing_list"  value="{{ $shipment->packing_list }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="origin_certificate" class="form-label">Origin Certificate</label>
                                        <input type="file" class="form-control" id="origin_certificate" name="origin_certificate"  value="{{ $shipment->origin_certificate }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="phytosanitary" class="form-label">Phytosanitary</label>
                                        <input type="file" class="form-control" id="phytosanitary" name="phytosanitary"  value="{{ $shipment->phytosanitary }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="freight" class="form-label">Freight</label>
                                        <input type="text" class="form-control" id="freight" name="freight"  value="{{ $shipment->freight }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="insurance" class="form-label">Insurance</label>
                                        <input type="text" class="form-control" id="insurance" name="insurance"  value="{{ $shipment->insurance }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="exchange_rate" class="form-label">Exchange Rate</label>
                                        <input type="text" class="form-control" id="exchange_rate" name="exchange_rate"  value="{{ $shipment->exchange_rate }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="duties" class="form-label">Duties</label>
                                        <input type="text" class="form-control" id="duties" name="duties"  value="{{ $shipment->duties }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="tax" class="form-label">Tax</label>
                                        <input type="text" class="form-control" id="tax" name="tax"  value="{{ $shipment->tax }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="unpack" class="form-label">Unpack</label>
                                        <input type="text" class="form-control" id="unpack" name="unpack"  value="{{ $shipment->unpack }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="transport" class="form-label">Transport</label>
                                        <input type="text" class="form-control" id="transport" name="transport"  value="{{ $shipment->transport }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="penalty" class="form-label">Penalty</label>
                                        <input type="text" class="form-control" id="penalty" name="penalty"  value="{{ $shipment->penalty }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="other_fee" class="form-label">Other Fee</label>
                                        <input type="text" class="form-control" id="other_fee" name="other_fee"  value="{{ $shipment->other_fee }}">
                                    </div>
                                    <div class="col-lg-6 col-xl-6">
                                        <label for="other_fee" class="form-label">Comments</label>
                                        <input type="text" class="form-control" id="shipment_comment" name="shipment_comment"  value="{{ $shipment->shipment_comment }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    @if(!empty($shipment->lots) && count($shipment->lots) > 0)
                        @php
                            $groupedByContainer = [];

                            foreach ($shipment->lots as $lot) {
                                $lastTwo = substr($lot['lot_unique'], -2);

                                $containerIndex = (int) substr($lastTwo, 0, 1);

                                if (!isset($groupedByContainer[$containerIndex])) {
                                    $groupedByContainer[$containerIndex] = [];
                                }

                                $groupedByContainer[$containerIndex][] = $lot;
                            }
                        @endphp
                    @endif

                    @for($containerIndex = 1; $containerIndex <= count($groupedByContainer); $containerIndex++)

                        <div class="card">
                            <div class="card-body">
                                <div id="container_{{$containerIndex}}" style="display: block;">
                                    <table class="table table-bordered table-nowrap table-part-category mb-0 mt-5" style="table-layout: auto">
                                        <thead class="table-light border-1">
                                        <tr>
                                            <th class="text-left px-4" colspan="14">Container No. {{$containerIndex}}</th>
                                        </tr>
                                        </thead>
                                    </table>

                                    @for($lotIndex = 1; $lotIndex <= count($groupedByContainer[$containerIndex]); $lotIndex++)
                                        @php
                                            $lot = $groupedByContainer[$containerIndex][$lotIndex - 1];
                                            $bg = ($lotIndex % 2) == 1 ? '#ffffff' : '#fbfbfb';
                                        @endphp

                                        <div id="tr_{{$containerIndex}}_{{$lotIndex}}" class="p-3" style="border:1px solid #ccc; display:block; background-color:{{$bg}}">
                                            <div class="row">
                                                <div class="col-lg-8 col-xl-8">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="lot_number_{{$containerIndex}}_{{$lotIndex}}" class="form-label">{{ ($lotIndex) }}. Lot Number</label>
                                                            <input type="text" class="form-control" id="lot_number_{{$containerIndex}}_{{$lotIndex}}" name="lot_number[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->lot_number }}">
                                                            <input type="hidden" id="lot_unique_{{$containerIndex}}_{{$lotIndex}}" name="lot_unique[{{$containerIndex}}][{{$lotIndex}}]" value="{{ ($timestamp.$containerIndex.$lotIndex )   }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="item_id_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Product</label>
                                                            <select class="form-select" id="item_id_{{$containerIndex}}_{{$lotIndex}}" name="item_id[{{$containerIndex}}][{{$lotIndex}}]">
                                                                <option value="0">Select</option>
                                                                @foreach($items as $p)
                                                                    <option value="{{ $p['id'] }}" {{ $lot->item_id == $p['id'] ? 'selected' : '' }}>{{ $p['item_name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="package_kg_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Package KG</label>
                                                            <input type="text" class="form-control" id="package_kg_{{$containerIndex}}_{{$lotIndex}}" name="package_kg[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->package_kg }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="type_of_package_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Type of Package</label>
                                                            <select class="form-select" id="type_of_package_{{$containerIndex}}_{{$lotIndex}}" name="type_of_package[{{$containerIndex}}][{{$lotIndex}}]"  >
                                                                <option value="">Select</option>
                                                                @foreach(DataPackageType::orderBy('package_type')->get() as $p)
                                                                    <option value="{{ $p->package_type }}" {{ $lot->type_of_package == $p['package_type'] ? 'selected' : '' }}>{{ $p->package_type }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="total_packages" class="form-label">Total Packages</label>
                                                            <input type="text" class="form-control" id="total_packages_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="total_packages[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->total_packages }}">
                                                        </div>
                                                        <div class="col-lg-1 col-xl-1">
                                                            <label for="unit_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Unit</label>
                                                            <select class="form-select p-1" id="unit_{{$containerIndex}}_{{$lotIndex}}" name="unit[{{$containerIndex}}][{{$lotIndex}}]"   >
                                                                <option value="KG">KG</option>
                                                                <option value="L">L</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-1 col-xl-1">
                                                            <label for="total_qty_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Total Qty</label>
                                                            <input type="text" class="form-control  p-1" id="total_qty_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="total_qty[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->total_qty }}">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="price_per_unit_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Price per Unit</label>
                                                            <input type="text" class="form-control" id="price_per_unit_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="price_per_unit[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->price_per_unit }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="total_price_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Total Price</label>
                                                            <input type="text" class="form-control" id="total_price_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="total_price[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->total_price }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="manufacture_date_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Manufacture Date</label>
                                                            <input type="date" class="form-control" id="manufacture_date_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="manufacture_date[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->manufacture_date }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="crop_year_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Crop Year</label>
                                                            <select class="form-select" id="crop_year_{{$containerIndex}}_{{$lotIndex}}" name="crop_year[{{$containerIndex}}][{{$lotIndex}}]"  >
                                                                <option value="">Select</option>
                                                                @for($year = date("Y"); $year >= 2020; $year--)
                                                                    <option value="{{ $year }}" {{ $year == $lot->crop_year ? 'selected' : '' }}>{{ $year }}</option>
                                                                @endfor
                                                            </select>

                                                        </div>

                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="shelf_life_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Shelf Life</label>
                                                            <select class="form-select" id="shelf_life_{{$containerIndex}}_{{$lotIndex}}" name="shelf_life[{{$containerIndex}}][{{$lotIndex}}]"  >
                                                                <option value="">Select</option>
                                                                @foreach(DataShelflife::orderBy('id')->get() as $p)
                                                                    <option value="{{ $p->shelflife }}" {{ $p->shelflife == $lot->shelf_life ? 'selected' : '' }} >{{ $p->shelflife }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="best_before_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Best Before</label>
                                                            <input type="date" class="form-control" id="best_before_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="best_before[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->best_before }}">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="loading_report_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Loading Report</label>
                                                            <input type="file" class="form-control" id="loading_report_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="loading_report[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->loading_report }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="surveyor_name_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Surveyor Name</label>
                                                            <input type="text" class="form-control" id="surveyor_name_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="surveyor_name[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->surveyor_name }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="loading_date_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Loading Date</label>
                                                            <input type="date" class="form-control" id="loading_date_{{$containerIndex}}_{{$lotIndex}}"
                                                                   name="loading_date[{{$containerIndex}}][{{$lotIndex}}]" value="{{ $lot->loading_date }}">
                                                        </div>
                                                        <div class="col-lg-6 col-xl-6">
                                                            <input id="lot_photos_{{$containerIndex}}_{{$lotIndex}}" name="lot_photos" value="{{ ($timestamp.$containerIndex.$lotIndex )   }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-xl-2">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <label for="item_description_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Description</label>
                                                            <textarea class="form-control" id="item_description_{{$containerIndex}}_{{$lotIndex}}"
                                                                      name="item_description[{{$containerIndex}}][{{$lotIndex}}]">{{ $lot->item_description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <label for="lot_comment_{{$containerIndex}}_{{$lotIndex}}" class="form-label">Comments</label>
                                                            <textarea class="form-control" id="lot_comment_{{$containerIndex}}_{{$lotIndex}}"
                                                                      name="lot_comment[{{$containerIndex}}][{{$lotIndex}}]">{{ $lot->lot_comment }}</textarea>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <a id="hide_line_{{$containerIndex}}_{{$lotIndex}}" onclick="hide_line({{$containerIndex}} , {{$lotIndex}})"
                                                       class="float-end btn btn-sm delete-part-category font-sm rounded btn-danger">
                                                        <i class="material-icons md-delete_forever fs-6"></i>Remove This Lot
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor

                                    @for($i = $lotIndex; $i <= 9; $i++)
                                        @php
                                            $c = $containerIndex;
                                            ($i % 2) == 1 ? $bg ='#ffffff' : $bg ='#fbfbfb';
                                        @endphp
                                        <div id="tr_{{$c}}_{{$i}}" class="p-3" style="border:1px solid #ccc;display:none; background-color:{{$bg}}">
                                            <div class="row">
                                                <div class="col-lg-8 col-xl-8">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="lot_number_{{$c}}_{{$i}}" class="form-label">{{ ($i) }}. Lot Number</label>
                                                            <input type="text" class="form-control" id="lot_number_{{$c}}_{{$i}}" name="lot_number[{{$c}}][{{$i}}]" value="">
                                                            <input type="hidden" id="lot_unique_{{$c}}_{{$i}}" name="lot_unique[{{$c}}][{{$i}}]" value="{{ ($timestamp.$c.$i )   }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="item_id_{{$c}}_{{$i}}" class="form-label">Product</label>
                                                            <select class="form-select" id="item_id_{{$c}}_{{$i}}" name="item_id[{{$c}}][{{$i}}]">
                                                                <option value="0">Select</option>
                                                                @foreach($items as $p)
                                                                    <option value="{{ $p['id'] }}" >{{ $p['item_name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="package_kg_{{$c}}_{{$i}}" class="form-label">Package KG</label>
                                                            <input type="text" class="form-control" id="package_kg_{{$c}}_{{$i}}" name="package_kg[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="type_of_package_{{$c}}_{{$i}}" class="form-label">Type of Package</label>
                                                            <select class="form-select" id="type_of_package_{{$c}}_{{$i}}" name="type_of_package[{{$c}}][{{$i}}]"  >
                                                                <option value="">Select</option>
                                                                @foreach(DataPackageType::orderBy('package_type')->get() as $p)
                                                                    <option value="{{ $p->package_type }}"  >{{ $p->package_type }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="total_packages" class="form-label">Total Packages</label>
                                                            <input type="text" class="form-control" id="total_packages_{{$c}}_{{$i}}" name="total_packages[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-1 col-xl-1">
                                                            <label for="unit_{{$c}}_{{$i}}" class="form-label">Unit</label>
                                                            <select class="form-select p-1" id="unit_{{$c}}_{{$i}}" name="unit[{{$c}}][{{$i}}]"   >
                                                                <option value="KG">KG</option>
                                                                <option value="L">L</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-1 col-xl-1">
                                                            <label for="total_qty_{{$c}}_{{$i}}" class="form-label">Total Qty</label>
                                                            <input type="text" class="form-control  p-1" id="total_qty_{{$c}}_{{$i}}" name="total_qty[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="price_per_unit_{{$c}}_{{$i}}" class="form-label">Price per Unit</label>
                                                            <input type="text" class="form-control" id="price_per_unit_{{$c}}_{{$i}}" name="price_per_unit[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="total_price_{{$c}}_{{$i}}" class="form-label">Total Price</label>
                                                            <input type="text" class="form-control" id="total_price_{{$c}}_{{$i}}" name="total_price[{{$c}}][{{$i}}]" value="">
                                                        </div>

                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="manufacture_date_{{$c}}_{{$i}}" class="form-label">Manufacture Date</label>
                                                            <input type="date" class="form-control" id="manufacture_date_{{$c}}_{{$i}}" name="manufacture_date[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="crop_year_{{$c}}_{{$i}}" class="form-label">Crop Year</label>
                                                            <select class="form-select" id="crop_year_{{$c}}_{{$i}}" name="crop_year[{{$c}}][{{$i}}]"  >
                                                                <option value="">Select</option>
                                                                @for($year=date("Y"); $year>=2020; $year--)
                                                                    <option value="{{ $year }}"  >{{ $year }}</option>
                                                                @endfor
                                                            </select>

                                                        </div>

                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="shelf_life_{{$c}}_{{$i}}" class="form-label">Shelf Life</label>
                                                            <select class="form-select" id="shelf_life_{{$c}}_{{$i}}" name="shelf_life[{{$c}}][{{$i}}]"  >
                                                                <option value="">Select</option>
                                                                @foreach(DataShelflife::orderBy('id')->get() as $p)
                                                                    <option value="{{ $p->shelflife }}"  >{{ $p->shelflife }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="best_before_{{$c}}_{{$i}}" class="form-label">Best Before</label>
                                                            <input type="date" class="form-control" id="best_before_{{$c}}_{{$i}}" name="best_before[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="loading_report_{{$c}}_{{$i}}" class="form-label">Loading Report</label>
                                                            <input type="file" class="form-control" id="loading_report_{{$c}}_{{$i}}" name="loading_report[{{$c}}][{{$i}}]" >
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="surveyor_name_{{$c}}_{{$i}}" class="form-label">Surveyor Name</label>
                                                            <input type="text" class="form-control" id="surveyor_name_{{$c}}_{{$i}}" name="surveyor_name[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="loading_date_{{$c}}_{{$i}}" class="form-label">Loading Date</label>
                                                            <input type="date" class="form-control" id="loading_date_{{$c}}_{{$i}}" name="loading_date[{{$c}}][{{$i}}]" value="">
                                                        </div>


                                                        <div class="col-lg-6 col-xl-6">
                                                            <input id="lot_photos_{{$c}}_{{$i}}" name="lot_photos" value="{{ ($timestamp.$c.$i )   }}">

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <label for="item_description_{{$c}}_{{$i}}" class="form-label">Description</label>
                                                            <textarea class="form-control" id="item_description_{{$c}}_{{$i}}" name="item_description[{{$c}}][{{$i}}]"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <label for="lot_comment_{{$c}}_{{$i}}" class="form-label">Comments</label>
                                                            <textarea class="form-control" id="lot_comment_{{$c}}_{{$i}}" name="lot_comment[{{$c}}][{{$i}}]"></textarea>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <a id="hide_line_{{$c}}_{{$i}}" onclick="hide_line({{$c}} , {{$i}})" class="float-end btn btn-sm delete-part-category font-sm rounded btn-danger">
                                                        <i class="material-icons md-delete_forever fs-6"></i> Remove This Lot
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    @endfor

                                    <div class="my-2">
                                        <a id="add_btn_{{$containerIndex}}" onclick="show_line('{{$containerIndex}}')" class="btn btn-sm font-sm rounded btn-outline-primary">
                                            <i class="material-icons md-add fs-6"></i> Add Item
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endfor

                    @for($c = $containerIndex; $c <= 9; $c++)
                        <div id="container_{{$c}}" class="card"  style="display:none;">
                            <div class="card-body">
                                <div>
                                    <table class="table table-bordered table-nowrap table-part-category mb-0 mt-5" style="table-layout: auto">
                                        <thead class="table-light border-1">
                                        <tr>
                                            <th class="text-left px-4" colspan="14">Container No. {{$c}}</th>
                                        </tr>
                                        </thead>
                                    </table>

                                    @for($i = 1; $i <= 9; $i++)
                                        @php ($i % 2) == 1 ? $bg ='#ffffff' : $bg ='#fbfbfb'; @endphp
                                        <div id="tr_{{$c}}_{{$i}}" class="p-3" style="border:1px solid #ccc; font-size: 11px !important; display:none; background-color:{{$bg}}">
                                            <div class="row">
                                                <div class="col-lg-8 col-xl-8">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="lot_number_{{$c}}_{{$i}}" class="form-label">{{ ($i) }}. Lot Number</label>
                                                            <input type="text" class="form-control" id="lot_number_{{$c}}_{{$i}}" name="lot_number[{{$c}}][{{$i}}]" value="">
                                                            <input type="hidden" id="lot_unique_{{$c}}_{{$i}}" name="lot_unique[{{$c}}][{{$i}}]" value="{{ ($timestamp.$c.$i )   }}">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="item_id_{{$c}}_{{$i}}" class="form-label">Product</label>
                                                            <select class="form-select" id="item_id_{{$c}}_{{$i}}" name="item_id[{{$c}}][{{$i}}]">
                                                                <option value="0">Select</option>
                                                                @foreach($items as $p)
                                                                    <option value="{{ $p['id'] }}" >{{ $p['item_name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="package_kg_{{$c}}_{{$i}}" class="form-label">Package KG</label>
                                                            <input type="text" class="form-control" id="package_kg_{{$c}}_{{$i}}" name="package_kg[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="type_of_package_{{$c}}_{{$i}}" class="form-label">Type of Package</label>
                                                            <select class="form-select" id="type_of_package_{{$c}}_{{$i}}" name="type_of_package[{{$c}}][{{$i}}]"  >
                                                                <option value="">Select</option>
                                                                @foreach(DataPackageType::orderBy('package_type')->get() as $p)
                                                                    <option value="{{ $p->package_type }}"  >{{ $p->package_type }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="total_packages" class="form-label">Total Packages</label>
                                                            <input type="text" class="form-control" id="total_packages_{{$c}}_{{$i}}" name="total_packages[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-1 col-xl-1">
                                                            <label for="unit_{{$c}}_{{$i}}" class="form-label">Unit</label>
                                                            <select class="form-select p-1" id="unit_{{$c}}_{{$i}}" name="unit[{{$c}}][{{$i}}]"   >
                                                                <option value="KG">KG</option>
                                                                <option value="L">L</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-1 col-xl-1">
                                                            <label for="total_qty_{{$c}}_{{$i}}" class="form-label">Total Qty</label>
                                                            <input type="text" class="form-control  p-1" id="total_qty_{{$c}}_{{$i}}" name="total_qty[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="price_per_unit_{{$c}}_{{$i}}" class="form-label">Price per Unit</label>
                                                            <input type="text" class="form-control" id="price_per_unit_{{$c}}_{{$i}}" name="price_per_unit[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="total_price_{{$c}}_{{$i}}" class="form-label">Total Price</label>
                                                            <input type="text" class="form-control" id="total_price_{{$c}}_{{$i}}" name="total_price[{{$c}}][{{$i}}]" value="">
                                                        </div>

                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="manufacture_date_{{$c}}_{{$i}}" class="form-label">Manufacture Date</label>
                                                            <input type="date" class="form-control" id="manufacture_date_{{$c}}_{{$i}}" name="manufacture_date[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="crop_year_{{$c}}_{{$i}}" class="form-label">Crop Year</label>
                                                            <select class="form-select" id="crop_year_{{$c}}_{{$i}}" name="crop_year[{{$c}}][{{$i}}]"  >
                                                                <option value="">Select</option>
                                                                @for($year=date("Y"); $year>=2020; $year--)
                                                                    <option value="{{ $year }}"  >{{ $year }}</option>
                                                                @endfor
                                                            </select>

                                                        </div>

                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="shelf_life_{{$c}}_{{$i}}" class="form-label">Shelf Life</label>
                                                            <select class="form-select" id="shelf_life_{{$c}}_{{$i}}" name="shelf_life[{{$c}}][{{$i}}]"  >
                                                                <option value="">Select</option>
                                                                @foreach(DataShelflife::orderBy('id')->get() as $p)
                                                                    <option value="{{ $p->shelflife }}"  >{{ $p->shelflife }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="best_before_{{$c}}_{{$i}}" class="form-label">Best Before</label>
                                                            <input type="date" class="form-control" id="best_before_{{$c}}_{{$i}}" name="best_before[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="loading_report_{{$c}}_{{$i}}" class="form-label">Loading Report</label>
                                                            <input type="file" class="form-control" id="loading_report_{{$c}}_{{$i}}" name="loading_report[{{$c}}][{{$i}}]" >
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="surveyor_name_{{$c}}_{{$i}}" class="form-label">Surveyor Name</label>
                                                            <input type="text" class="form-control" id="surveyor_name_{{$c}}_{{$i}}" name="surveyor_name[{{$c}}][{{$i}}]" value="">
                                                        </div>
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="loading_date_{{$c}}_{{$i}}" class="form-label">Loading Date</label>
                                                            <input type="date" class="form-control" id="loading_date_{{$c}}_{{$i}}" name="loading_date[{{$c}}][{{$i}}]" value="">
                                                        </div>


                                                        <div class="col-lg-6 col-xl-6">
                                                            <input id="lot_photos_{{$c}}_{{$i}}" name="lot_photos" value="{{ ($timestamp.$c.$i )   }}">

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <label for="item_description_{{$c}}_{{$i}}" class="form-label">Description</label>
                                                            <textarea class="form-control" id="item_description_{{$c}}_{{$i}}" name="item_description[{{$c}}][{{$i}}]"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <div class="row mb-2">
                                                        <div class="col-lg-12 col-xl-12">
                                                            <label for="lot_comment_{{$c}}_{{$i}}" class="form-label">Comments</label>
                                                            <textarea class="form-control" id="lot_comment_{{$c}}_{{$i}}" name="lot_comment[{{$c}}][{{$i}}]"></textarea>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <a id="hide_line_{{$c}}_{{$i}}" onclick="hide_line({{$c}} , {{$i}})" class="float-end btn btn-sm delete-part-category font-sm rounded btn-danger">
                                                        <i class="material-icons md-delete_forever fs-6"></i> Remove This Lot
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    @endfor

                                    <div class="mt-2">
                                        <a id="add_btn_{{$c}}" onclick="show_line('{{$c}}')" class="btn btn-sm font-sm rounded btn-outline-primary">
                                            <i class="material-icons md-add fs-6"></i> Add Item
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor

                    <div class="d-flex justify-content-start">
                        <a id="add_container" onclick="show_container()" class="btn btn-sm font-sm rounded btn-outline-secondary">
                            <i class="material-icons md-add fs-6"></i> Add Container
                        </a>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary btn-block rounded" type="submit" name="submit">UPDATE SHIPMENT</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{url('assets/filepond/jquery.js')}}"></script>
    <script src="{{url('assets/filepond/filepond.min.js')}}"></script>
    <script src="{{url('assets/filepond/filepond.jquery.js')}}"></script>

    <script>
        for (c = 1; c <= 9; c++) {
            for (i = 1; i <= 9; i++) {
                $('#lot_photos_' + c + '_' + i).filepond({
                    allowMultiple: true,
                    allowRemove: false,
                    server: {
                        process: {
                            url: 'upload_lot_photo?lot_unique={{ $timestamp }}' + c + i,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            ondata: (formData) => {
                                console.log(c + '_' + i);
                                //console.log($('#lot_unique_'+c+'_'+i).val());
                                formData.append('lot_unique', '123');
                                return formData;
                            },
                        }
                    }
                });
            }
        }

        function show_line(c) {
            for (i = 1; i <= 9; i++) {
                if ($('#tr_' + c + '_' + i).length) {
                    if ($('#tr_' + c + '_' + i + ':visible').length == 0) {
                        $('#tr_' + c + '_' + i).show();
                        if (i == 9) {
                            $('#add_btn_' + c).hide();
                        }
                        break;
                    }
                }
            }
        }

        function hide_line(c, i) {
            if (i) {
                $('#tr_' + c + '_' + i).remove();
            }
        }

        function show_container() {
            for (i = 1; i <= 9; i++) {
                if ($('#container_' + i).length) {
                    if ($('#container_' + i + ':visible').length == 0) {
                        $('#container_' + i).show();
                        show_line(i);
                        if (i == 9) {
                            $('#add_container').hide();
                        }
                        break;
                    }
                }
            }
        }

        show_container();

        function update_line(i) {
            unit_price = parseFloat(document.getElementById('item_unit_price_' + i).value);
            item_qty = parseFloat(document.getElementById('item_qty_' + i).value);
            line_total = parseFloat(unit_price * item_qty).toFixed(2);
            if (!isNaN(line_total)) {
                document.getElementById('item_line_price_' + i).value = line_total;
            } else {
                document.getElementById('item_line_price_' + i).value = 0;
            }
            get_total();
        }

        function get_total() {
            var total_purchase_amount = 0;
            for (i = 0; i < 20; i++) {
                if ($('#tr_' + i).length) {
                    if ($('#tr_' + i + ':visible').length != 0) {
                        each_total = parseFloat(parseFloat(parseFloat(document.getElementById('item_unit_price_' + i).value) * parseFloat(document.getElementById('item_qty_' + i).value)).toFixed(2));
                        if (!isNaN(each_total)) {
                            total_purchase_amount = parseFloat(total_purchase_amount) + parseFloat(each_total);
                        }
                    }
                }
            }
            document.getElementById('purchase_amount').value = total_purchase_amount;
        }

        function update_item_info(i) {
            selected_item_id = document.getElementById('item_id_' + i).value

            @foreach($items as $p)
            if (selected_item_id == {{$p['id']}}) {
                item_description = '{{$p['item_description']}}';
                item_hts_code = '{{$p['hts_code']}}';
                default_price = '{{$p['default_price']}}';
                $('#item_description_' + i).html(item_description);
                $('#item_hts_code_' + i).html(item_hts_code);
                $('#item_unit_price_' + i).val(default_price);
            }
            @endforeach
        }

    </script>
@endpush
