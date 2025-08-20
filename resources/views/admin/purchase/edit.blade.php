@extends('admin.layouts.master')

@php use App\Models\Countries; @endphp
@php use App\Models\Provider; @endphp
@php use App\Models\Item; @endphp
@php use App\Models\DataIncoterm; @endphp
@php use App\Models\DataContainerType; @endphp
@php use App\Models\DataShelflife; @endphp
@php use App\Models\DataPackageType; @endphp
@php use App\Models\Ports; @endphp

@php
    $items = array();

    foreach (Item::orderBy('item_name')->get() as $p){
        $items[] = $p;
    }

   // \Barryvdh\Debugbar\Facades\Debugbar::info($items);


    foreach (DataPackageType::orderBy('package_type')->get() as $p){
        $dataPackagesList[] = $p;
    }

        foreach (DataShelflife::orderBy('id')->get() as $p){
        $dataShelflist[] = $p;
    }


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
                <form action="{{ route('admin.purchase.update', $shipment['id']) }}" method="POST" enctype="multipart/form-data">
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
                                               name="invoice_number"  value="{{ $shipment['invoice_number'] }}" required>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="invoice_date" class="form-label">Purchase/Invoice Date</label>
                                        <input type="date" placeholder="" class="form-control" id="invoice_date"
                                               name="invoice_date"  value="{{ $shipment['invoice_date'] }}" required>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="port_of_loading" class="form-label">Port of Loading</label>
                                        <select class="form-select" id="port_of_loading" name="port_of_loading">
                                            <option value="">Select</option>
                                            @foreach(Ports::orderBy('port_name')->whereNotIn('country_name', ['Japan'])->get() as $p)
                                                <option value="{{ $p->port_name }}" {{ $shipment['port_of_loading'] == $p->port_name ? 'selected' : '' }}  >{{ $p->port_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="port_of_landing" class="form-label">Destination</label>
                                        <select class="form-select" id="port_of_landing" name="port_of_landing"  >
                                            <option value="">Select</option>
                                            @foreach(Ports::orderBy('port_name')->whereIn('country_name', ['Japan'])->get() as $p)
                                                <option value="{{ $p->port_name }}" {{ $shipment['port_of_landing'] == $p->port_name ? 'selected' : '' }}  >{{ $p->port_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="country_of_destination" class="form-label">Country of Destination</label>
                                        <select class="form-select" id="country_of_destination" name="country_of_destination"  >
                                            <option value="">Select</option>
                                            @foreach(Countries::orderBy('country_name')->whereIn('country_name', ['Japan'])->get() as $p)
                                                <option value="{{ $p->country_name }}" {{ $shipment['country_of_destination'] == $p->country_name ? 'selected' : '' }}>{{ $p->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="incoterm" class="form-label">IncoTerm</label>
                                        <select class="form-select" id="incoterm" name="incoterm"  >
                                            <option value="">Select</option>
                                            @foreach(DataIncoterm::orderBy('incoterm')->get() as $p)
                                                <option value="{{ $p->incoterm }}" {{ $shipment['incoterm'] == $p->incoterm ? 'selected' : '' }}>{{ $p->incoterm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="provider_id" class="form-label">Provider Name</label>
                                        <select class="form-select" id="provider_id" name="provider_id"  required>
                                            <option value="">Select</option>
                                            @foreach(Provider::orderBy('provider_name')->get() as $p)
                                                <option value="{{ $p->id }}" {{ $shipment['provider_id'] == $p->id ? 'selected' : '' }}>{{ $p->provider_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="container_type" class="form-label">Container Type</label>
                                        <select class="form-select" id="container_type" name="container_type"  >
                                            <option value="">Select</option>
                                            @foreach(DataContainerType::orderBy('container_type')->get() as $p)
                                                <option value="{{ $p->container_type }}" {{ $shipment['container_type'] == $p->container_type ? 'selected' : '' }}>{{ $p->container_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="bl_number" class="form-label">BL Number</label>
                                        <input type="text" class="form-control" id="bl_number" name="bl_number"  value="{{ $shipment['bl_number'] }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="shipping_line" class="form-label">Shipping Line</label>
                                        <input type="text" class="form-control" id="shipping_line" name="shipping_line"  value="{{ $shipment['shipping_line'] }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="vessel" class="form-label">Vessel</label>
                                        <input type="text" class="form-control" id="vessel" name="vessel"  value="{{ $shipment['vessel'] }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="commercial_invoice" class="form-label">Commercial Invoice</label>

                                        @if(!empty($shipment['commercial_invoice']))
                                            <a target="_blank" href="{{ url('/'.$shipment['commercial_invoice']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @endif

                                        <input type="file" class="form-control" id="commercial_invoice" name="commercial_invoice">
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="etd" class="form-label">ETD</label>
                                        <input type="date" class="form-control" id="etd" name="etd"  value="{{ $shipment['etd'] }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="eta" class="form-label">ETA</label>
                                        <input type="date" class="form-control" id="eta" name="eta" value="{{ $shipment['eta'] }}">
                                    </div>
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="bl_telex_release" class="form-label">BL / Telex Release</label>
                                        @if(!empty($shipment['bl_telex_release']))
                                            <a target="_blank" href="{{ url('/'.$shipment['bl_telex_release']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @endif
                                        <input type="file" class="form-control" id="bl_telex_release" name="bl_telex_release">
                                    </div>

                                    <div class="col-lg-2 col-xl-2">
                                        <label for="packing_list" class="form-label">Packing List</label>
                                        @if(!empty($shipment['packing_list']))
                                            <a target="_blank" href="{{ url('/'.$shipment['packing_list']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @endif
                                        <input type="file" class="form-control" id="packing_list" name="packing_list">
                                    </div>

                                    <div class="col-lg-2 col-xl-2">
                                        <label for="origin_certificate" class="form-label">Origin Certificate</label>
                                        @if(!empty($shipment['origin_certificate']))
                                            <a target="_blank" href="{{ url('/'.$shipment['origin_certificate']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @endif
                                        <input type="file" class="form-control" id="origin_certificate" name="origin_certificate">
                                    </div>

                                    <div class="col-lg-2 col-xl-2">
                                        <label for="phytosanitary" class="form-label">Phytosanitary</label>
                                        @if(!empty($shipment['phytosanitary']))
                                            <a target="_blank" href="{{ url('/'.$shipment['phytosanitary']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @endif
                                        <input type="file" class="form-control" id="phytosanitary" name="phytosanitary">
                                    </div>

                                </div>
                                <div class="row mb-3">
{{--                                    <!-- <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="freight" class="form-label">Freight $</label>--}}
{{--                                        <input type="text" class="form-control" id="freight" name="freight"  value="{{ $shipment['freight'] }}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="insurance" class="form-label">Insurance $</label>--}}
{{--                                        <input type="text" class="form-control" id="insurance" name="insurance"  value="{{ $shipment['insurance'] }}">--}}
{{--                                    </div>--}}
                                    <div class="col-lg-2 col-xl-2">
                                        <label for="exchange_rate" class="form-label">Exchange Rate $</label>
                                        <input type="text" class="form-control" id="exchange_rate" name="exchange_rate"  value="{{ $shipment['exchange_rate'] }}">
                                    </div>
{{--                                    <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="duties" class="form-label">Duties $</label>--}}
{{--                                        <input type="text" class="form-control" id="duties" name="duties"  value="{{ $shipment['duties'] }}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="tax" class="form-label">Tax $</label>--}}
{{--                                        <input type="text" class="form-control" id="tax" name="tax"  value="{{ $shipment['tax'] }}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="unpack" class="form-label">Unpack $</label>--}}
{{--                                        <input type="text" class="form-control" id="unpack" name="unpack"  value="{{ $shipment['unpack'] }}">--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="row mb-3">--}}
{{--                                    <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="transport" class="form-label">Transport $</label>--}}
{{--                                        <input type="text" class="form-control" id="transport" name="transport"  value="{{ $shipment['transport'] }}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="penalty" class="form-label">Penalty $</label>--}}
{{--                                        <input type="text" class="form-control" id="penalty" name="penalty"  value="{{ $shipment['penalty'] }}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="other_fee" class="form-label">Other Fee $</label>--}}
{{--                                        <input type="text" class="form-control" id="other_fee" name="other_fee"  value="{{ $shipment['other_fee'] }}">--}}
{{--                                    </div>--}}
{{--                                    <div class="col-lg-2 col-xl-2">--}}
{{--                                        <label for="total_shipment_cost" class="form-label">Total Cost $</label>--}}
{{--                                        <input type="text" class="form-control" id="total_shipment_cost" name="total_shipment_cost"  value="0">--}}
{{--                                    </div> -->--}}
                                    <div class="col-lg-4 col-xl-4">
                                        <label for="other_fee" class="form-label">Comments</label>
                                        <input type="text" class="form-control" id="shipment_comment" name="shipment_comment"  value="{{ $shipment['shipment_comment'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>






                    <div class="row mb-3">
                        <div class="col-lg-12 col-xl-12">
                            <h5 class="mb-3">Purchase Costs</h5>
                            <table class="table table-bordered" id="purchase-costs-table">
                                <thead>
                                    <tr>
                                        <th width="10%">Cost Date</th>
                                        <th width="10%">Cost Name</th>
                                        <th width="10%">Cost Amount</th>
                                        <th width="50%">Description</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $costs = old('costs', $shipment['purchase_costs'] ?? []);
                                    @endphp

                                    @forelse($costs as $index => $cost)
                                        <tr>
                                            <td width="10%">
                                                <input type="hidden" name="costs[{{ $index }}][id]" value="{{ $cost['id'] ?? '' }}">
                                                <input type="date" class="form-control" name="costs[{{ $index }}][cost_date]" value="{{ $cost['cost_date'] ?? '' }}">
                                            </td>
                                            <td width="10%"><input type="text" class="form-control" name="costs[{{ $index }}][cost_name]" value="{{ $cost['cost_name'] ?? '' }}"></td>
                                            <td width="10%"><input type="number" class="form-control" name="costs[{{ $index }}][cost_amount]" value="{{ $cost['cost_amount'] ?? '' }}"></td>
                                            <td width="50%"><input type="text" class="form-control" name="costs[{{ $index }}][description]" value="{{ $cost['description'] ?? '' }}"></td>
                                            <td width="10%"><button type="button" class="btn btn-danger btn-sm remove-cost-row">Remove</button></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td width="10%"><input type="date" placeholder="Cost Date" class="form-control" name="costs[0][cost_date]"></td>
                                            <td width="10%"><input type="text" placeholder="Cost Name" class="form-control" name="costs[0][cost_name]"></td>
                                            <td width="10%"><input type="number" placeholder="Cost Amount" class="form-control" name="costs[0][cost_amount]"></td>
                                            <td width="50%"><input type="text" placeholder="Description" class="form-control" name="costs[0][description]"></td>
                                            <td width="10%"><button type="button" class="btn btn-danger btn-sm remove-cost-row">Remove</button></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-outline-secondary btn-sm" id="add-cost-row">Add New Cost</button>
                        </div>
                    </div>

                    <section>&nbsp;</section>

                    @php
                    $timestamp = time();
                        //print "<pre>";
                        //print_r($shipment);
                        //print "</pre>";
                    @endphp

                    @if(!empty($shipment['lots']) && count($shipment['lots']) > 0)
                        @php
                            foreach ($shipment['lots'] as $lot) {

                                $timestamp = substr($lot['lot_unique'], 0,10);
                                $lastTwo = substr($lot['lot_unique'], -2);

                                $containerIndex = (int) substr($lastTwo, 0, 1);
                                $lotIndex = (int) substr($lastTwo, 1, 1);

                                $groupedByContainer[$timestamp][$containerIndex][$lotIndex] = $lot;
                            }

                        @endphp
                    @endif
                    @for($c=1; $c<=9; $c++)
                        <div id="container_{{$c}}" style="display:none;">
                            <table class="table table-bordered table-nowrap table-part-category mb-0 mt-5" style="table-layout: auto">
                                <thead class="table-light border-1">
                                <tr>
                                    <th class="text-left px-4" colspan="14">Container No. {{$c}}</th>
                                </tr>
                                </thead>
                            </table>

                            @for($i=1; $i<=9; $i++)
                                @php ($i%2)==1 ? $bg ='#ffffff' : $bg ='#fbfbfb'; @endphp
                                <div id="tr_{{$c}}_{{$i}}" class="p-3" style="border:1px solid #ccc;display:none; background-color:{{$bg}}">
                                    <div class="row">
                                        <div class="col-lg-8 col-xl-8">
                                            <div class="row mb-2">
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="lot_number_{{$c}}_{{$i}}" class="form-label">{{ ($i) }}. Lot Number</label>
                                                    <input type="text" class="form-control" id="lot_number_{{$c}}_{{$i}}" name="lot_number[{{$c}}][{{$i}}]" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['lot_number'])){ echo $groupedByContainer[$timestamp][$c][$i]['lot_number'];} @endphp">
                                                    <input type="hidden" id="lot_unique_{{$c}}_{{$i}}" name="lot_unique[{{$c}}][{{$i}}]" value="{{ ($timestamp.$c.$i )   }}">
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="item_id_{{$c}}_{{$i}}" class="form-label">Product</label>
                                                    <select class="form-select" id="item_id_{{$c}}_{{$i}}" name="item_id[{{$c}}][{{$i}}]" onchange="updatePrice({{$c}}, {{$i}})">
                                                        <option value="" data-price="0">Select</option>
                                                        @foreach($items as $p)
                                                            <option value="{{ $p['id'] }}" data-price="{{ $p['default_price'] ?? 0 }}" @php if(isset($groupedByContainer[$timestamp][$c][$i]['item_id'])){ if($groupedByContainer[$timestamp][$c][$i]['item_id']== $p['id']){ echo 'selected'; }  } @endphp >{{ $p['item_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="package_kg_{{$c}}_{{$i}}" class="form-label">Package KG</label>
                                                    <input type="text" class="form-control" id="package_kg_{{$c}}_{{$i}}" name="package_kg[{{$c}}][{{$i}}]" onkeyup="calc_lot({{$c}},{{$i}});" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['package_kg'])){ echo $groupedByContainer[$timestamp][$c][$i]['package_kg'];} @endphp">
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="type_of_package_{{$c}}_{{$i}}" class="form-label">Type of Package</label>
                                                    <select class="form-select" id="type_of_package_{{$c}}_{{$i}}" name="type_of_package[{{$c}}][{{$i}}]"  >
                                                        <option value="">Select</option>
                                                        @foreach($dataPackagesList as $p)
                                                            <option value="{{ $p->package_type }}" @php if(isset($groupedByContainer[$timestamp][$c][$i]['type_of_package'])){ if($groupedByContainer[$timestamp][$c][$i]['type_of_package']== $p->package_type){ echo 'selected'; }  } @endphp  >{{ $p->package_type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="total_packages" class="form-label">Total Packages</label>
                                                    <input type="text" class="form-control" id="total_packages_{{$c}}_{{$i}}" name="total_packages[{{$c}}][{{$i}}]" onkeyup="calc_lot({{$c}},{{$i}});" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['total_packages'])){ echo $groupedByContainer[$timestamp][$c][$i]['total_packages'];} @endphp">
                                                </div>
                                                <div class="col-lg-1 col-xl-1">
                                                    <label for="unit_{{$c}}_{{$i}}" class="form-label">Unit</label>
                                                    <select class="form-select p-1" id="unit_{{$c}}_{{$i}}" name="unit[{{$c}}][{{$i}}]"   >
                                                        <option value="KG" @php if(isset($groupedByContainer[$timestamp][$c][$i]['unit'])){ if($groupedByContainer[$timestamp][$c][$i]['unit']== 'KG'){ echo 'selected'; }  } @endphp >KG</option>
                                                        <option value="L" @php if(isset($groupedByContainer[$timestamp][$c][$i]['unit'])){ if($groupedByContainer[$timestamp][$c][$i]['unit']== 'L'){ echo 'selected'; }  } @endphp >L</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-1 col-xl-1">
                                                    <label for="total_qty_{{$c}}_{{$i}}" class="form-label">Total Qty</label>
                                                    <input type="text" class="form-control  p-1" id="total_qty_{{$c}}_{{$i}}" name="total_qty[{{$c}}][{{$i}}]" onkeyup="calc_lot({{$c}},{{$i}});" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['total_qty'])){ echo $groupedByContainer[$timestamp][$c][$i]['total_qty'];} @endphp">
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="price_per_unit_{{$c}}_{{$i}}" class="form-label">Price per Unit $</label>
                                                    <input type="text" class="form-control" id="price_per_unit_{{$c}}_{{$i}}" name="price_per_unit[{{$c}}][{{$i}}]" onkeyup="calc_lot({{$c}},{{$i}});" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['price_per_unit'])){ echo $groupedByContainer[$timestamp][$c][$i]['price_per_unit'];} @endphp">
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="total_price_{{$c}}_{{$i}}" class="form-label">Total Price $</label>
                                                    <input type="text" class="form-control" id="total_price_{{$c}}_{{$i}}" name="total_price[{{$c}}][{{$i}}]" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['total_price'])){ echo $groupedByContainer[$timestamp][$c][$i]['total_price'];} @endphp">
                                                </div>

                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="manufacture_date_{{$c}}_{{$i}}" class="form-label">Manufacture Date</label>
                                                    <input type="date" class="form-control" id="manufacture_date_{{$c}}_{{$i}}" name="manufacture_date[{{$c}}][{{$i}}]" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['manufacture_date'])){ echo $groupedByContainer[$timestamp][$c][$i]['manufacture_date'];} @endphp">
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="crop_year_{{$c}}_{{$i}}" class="form-label">Crop Year</label>
                                                    <select class="form-select" id="crop_year_{{$c}}_{{$i}}" name="crop_year[{{$c}}][{{$i}}]"  >
                                                        <option value="">Select</option>
                                                        @for($year=date("Y"); $year>=2020; $year--)
                                                            <option value="{{ $year }}" @php if(isset($groupedByContainer[$timestamp][$c][$i]['crop_year'])){ if($groupedByContainer[$timestamp][$c][$i]['crop_year']== $year){ echo 'selected'; }  } @endphp  >{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="shelf_life_{{$c}}_{{$i}}" class="form-label">Shelf Life</label>
                                                    <select class="form-select" id="shelf_life_{{$c}}_{{$i}}" name="shelf_life[{{$c}}][{{$i}}]"  >
                                                        <option value="">Select</option>
                                                        @foreach($dataShelflist as $p)
                                                            <option value="{{ $p->shelflife }}" @php if(isset($groupedByContainer[$timestamp][$c][$i]['shelf_life'])){ if($groupedByContainer[$timestamp][$c][$i]['shelf_life']== $p['shelflife']){ echo 'selected'; }  } @endphp  >{{ $p->shelflife }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="best_before_{{$c}}_{{$i}}" class="form-label">Best Before</label>
                                                    <input type="date" class="form-control" id="best_before_{{$c}}_{{$i}}" name="best_before[{{$c}}][{{$i}}]" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['best_before'])){ echo $groupedByContainer[$timestamp][$c][$i]['best_before'];} @endphp">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="loading_report_{{$c}}_{{$i}}" class="form-label">Loading Report</label>

                                                    @if(!empty($groupedByContainer[$timestamp][$c][$i]['loading_report']))
                                                        <a target="_blank"
                                                           href="{{ url('/'.$groupedByContainer[$timestamp][$c][$i]['loading_report']) }}"
                                                           class="btn btn-youtube font-sm btn-outline-danger">
                                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                                        </a>
                                                    @endif

                                                    <input type="file" class="form-control"
                                                           id="loading_report_{{$c}}_{{$i}}"
                                                           name="loading_report[{{$c}}][{{$i}}]">
                                                </div>

                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="surveyor_name_{{$c}}_{{$i}}" class="form-label">Surveyor Name</label>
                                                    <input type="text" class="form-control" id="surveyor_name_{{$c}}_{{$i}}" name="surveyor_name[{{$c}}][{{$i}}]"   value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['surveyor_name'])){ echo $groupedByContainer[$timestamp][$c][$i]['surveyor_name']; } @endphp">
                                                </div>
                                                <div class="col-lg-2 col-xl-2">
                                                    <label for="loading_date_{{$c}}_{{$i}}" class="form-label">Loading Date</label>
                                                    <input type="date" class="form-control" id="loading_date_{{$c}}_{{$i}}" name="loading_date[{{$c}}][{{$i}}]" value="@php if(isset($groupedByContainer[$timestamp][$c][$i]['loading_date'])){ echo $groupedByContainer[$timestamp][$c][$i]['loading_date']; } @endphp">
                                                </div>
                                                <div class="col-lg-12 col-xl-12 p-4">
                                                    <?php
                                                        if(isset($groupedByContainer[$timestamp][$c][$i]['photos'])){
                                                        foreach($groupedByContainer[$timestamp][$c][$i]['photos'] as $photo){ ?>
                                                    <div id="img_container_{{$photo['lot_unique']}}_{{$photo['id']}}" class="float-start p-3">

                                                            <img src="{{url('/'.$photo['photo_url'])}}" style="max-width:200px; max-height:150px;">
                                                            <input type="hidden" name="photos[{{$photo['lot_unique']}}][]" id="photos_{{$photo['lot_unique']}}_{{$photo['id']}}" value="{{$photo['photo_url']}}">
                                                        <br>
                                                    <a onclick="remove_pic('{{$photo['lot_unique']}}_{{$photo['id']}}')" class="float-start btn btn-sm delete-part-category font-sm rounded btn-danger p-0">
                                                        <i class="material-icons md-delete_forever fs-6"></i> Remove This Image
                                                    </a>
                                                </div>

                                                    <?php
                                                        }
                                                        } ?>
                                                </div>
                                                <div class="col-lg-12 col-xl-12 p-4">
                                                    <input id="lot_photos_{{$c}}_{{$i}}" name="lot_photos" value="{{ ($timestamp.$c.$i )   }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2">
                                            <div class="row mb-2">
                                                <div class="col-lg-12 col-xl-12">
                                                    <label for="item_description_{{$c}}_{{$i}}" class="form-label">Description</label>
                                                    <textarea class="form-control" id="item_description_{{$c}}_{{$i}}" name="item_description[{{$c}}][{{$i}}]">@php if(isset($groupedByContainer[$timestamp][$c][$i]['item_description'])){ echo $groupedByContainer[$timestamp][$c][$i]['item_description'];} @endphp</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2">
                                            <div class="row mb-2">
                                                <div class="col-lg-12 col-xl-12">
                                                    <label for="lot_comment_{{$c}}_{{$i}}" class="form-label">Comments</label>
                                                    <textarea class="form-control" id="lot_comment_{{$c}}_{{$i}}" name="lot_comment[{{$c}}][{{$i}}]">@php if(isset($groupedByContainer[$timestamp][$c][$i]['lot_comment'])){ echo $groupedByContainer[$timestamp][$c][$i]['lot_comment'];} @endphp</textarea>
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
                            <div class="d-flex justify-content-start">
                                <a id="add_btn_{{$c}}" onclick="show_line('{{$c}}')" class="btn btn-sm  font-sm rounded btn-outline-secondary">
                                    <i class="material-icons md-add fs-6"></i> Add Item
                                </a>
                            </div>
                        </div>
                    @endfor
                    <br><br>
                    <div class="d-flex justify-content-start">
                        <a id="add_container" onclick="show_container()" class="btn btn-sm  font-sm rounded btn-outline-secondary">
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
    <script>
        $(document).ready(function() {
            let costRowIndex = {{ !empty($shipment['purchase_costs']) ? count($shipment['purchase_costs']) : 1 }};
            $('#add-cost-row').on('click', function() {
                let newRow = `
                <tr>
                    <td width="10%"><input type="date" placeholder="Cost Date" class="form-control" name="costs[${costRowIndex}][cost_date]"></td>
                    <td width="10%"><input type="text" placeholder="Cost Name" class="form-control" name="costs[${costRowIndex}][cost_name]"></td>
                    <td width="10%"><input type="number" placeholder="Cost Amount" class="form-control" name="costs[${costRowIndex}][cost_amount]"></td>
                    <td width="50%"><input type="text" placeholder="Description" class="form-control" name="costs[${costRowIndex}][description]"></td>
                    <td width="10%"><button type="button" class="btn btn-danger btn-sm remove-cost-row">Remove</button></td>
                </tr>`;
                $('#purchase-costs-table tbody').append(newRow);
                costRowIndex++;
            });

            $('#purchase-costs-table').on('click', '.remove-cost-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>

    <script>
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


        function hide_line(c, i){
            if(i){
                Swal.fire({
                    title: "Are you sure you want to delete this lot?",
                    text: "This Lot will be deleted immediately!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, remove it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#tr_'+c+'_'+i).remove();
                        // const photo_db_id_split = id.split("_");
                        // const photo_db_id  = photo_db_id_split[photo_db_id_split.length - 1];
                        console.log({{$timestamp}});
                        $.ajax({
                            url: '{{url('admin/purchase')}}/delete_complete_lot?id='+{{$timestamp}}+c+i,
                            method: "GET",
                            success: function (data) {
                                if (data.code === 200) {
                                    console.error("Removed Lot:", xhr);
                                }
                            },
                            error: function (xhr) {
                                console.error("Error removing photo:", xhr);
                            },
                        });


                    }


                });
            }
        }

        function remove_pic(id){
            if(id){
                Swal.fire({
                    title: "Are you sure you want to delete this image?",
                    text: "This photos will be deleted immediately!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, remove it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#img_container_'+id).remove();
                        const photo_db_id_split = id.split("_");
                        const photo_db_id  = photo_db_id_split[photo_db_id_split.length - 1];
                        console.log(photo_db_id);
                        $.ajax({
                            url: '{{url('admin/purchase')}}/delete_lot_photo?id='+photo_db_id,
                            method: "GET",
                            success: function (data) {
                                if (data.code === 200) {
                                    console.error("Removed photo:", xhr);
                                }
                            },
                            error: function (xhr) {
                                console.error("Error removing photo:", xhr);
                            },
                        });


                    }
                });
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

        function check_startup(){
            for(c=1; c<=9; c++){
                for(i=1; i<=9; i++) {
                    var lot = $('#lot_number_'+c+'_'+i).val();
                    if(lot!=''){
                        console.log(lot);
                        $('#tr_' + c + '_' + i).show();
                        $('#container_' + c).show();
                    }
                }
            }
        }
        check_startup();


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

        function calc_shipment(){
            var freight = Number($('#freight').val());
            var insurance = Number($('#insurance').val());
            var duties = Number($('#duties').val());
            var tax = Number($('#tax').val());
            var unpack = Number($('#unpack').val());
            var transport = Number($('#transport').val());
            var penalty = Number($('#penalty').val());
            var other_fee = Number($('#other_fee').val());

            var total = parseInt(freight) + parseInt(insurance) + parseInt(duties) + parseInt(tax) + parseInt(unpack) + parseInt(transport) + parseInt(penalty) + parseInt(other_fee);
            $('#total_shipment_cost').val(total);
        }
        calc_shipment();

        function updatePrice(c, i) {
            const selectElement = document.getElementById(`item_id_${c}_${i}`);
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            const priceInputElement = document.getElementById(`price_per_unit_${c}_${i}`);
            priceInputElement.value = price;
            calc_lot(c, i);
        }

        function calc_lot(c, i){
            var package_kg = Number($('#package_kg_'+c+'_'+i).val());
            var total_packages = Number($('#total_packages_'+c+'_'+i).val());
            var total_qty = parseFloat(package_kg) * parseFloat(total_packages);
            $('#total_qty_'+c+'_'+i).val(total_qty);

            var total_qty = Number($('#total_qty_'+c+'_'+i).val());
            var price_per_unit = Number($('#price_per_unit_'+c+'_'+i).val());

            var total_lot_price = parseFloat(total_qty) * parseFloat(price_per_unit);
            $('#total_price_'+c+'_'+i).val(total_lot_price);
        }

    </script>
        <script src="{{url('assets/filepond/jquery.js')}}"></script>
    <script src="{{url('assets/filepond/filepond.min.js')}}"></script>
    <script src="{{url('assets/filepond/filepond.jquery.js')}}"></script>

    <script>
        for (c = 1; c <= 9; c++) {
            for (i = 1; i <= 9; i++) {
                $('#lot_photos_'+c+'_'+i).filepond({
                    allowMultiple: true,
                    allowRemove:false,
                    server: {
                        process: {
                            url: '{{url('admin/purchase')}}/upload_lot_photo?lot_unique={{ $timestamp }}'+c+i,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            ondata: (formData) => {
                                //console.log(c+'_'+i);
                                //console.log($('#lot_unique_'+c+'_'+i).val());
                                formData.append('lot_unique', '123');
                                return formData;
                            },
                        }
                    }
                });
            }
        }
</script>

@endpush
