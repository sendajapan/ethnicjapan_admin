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
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                    <section class="section">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Purchase information</h5>
                                <div class="row mb-0  border-x-1 border-top-1">
                                    <div class="col-lg-2 col-xl-2 border-1 p-2">
                                        <label class="form-label">Purchase/Invoice No.</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['invoice_number'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2">
                                        <label for="invoice_date" class="form-label">Purchase/Invoice Date</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['invoice_date'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2">
                                        <label for="port_of_loading" class="form-label">Port of Loading</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['port_of_loading'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2">
                                        <label for="port_of_landing" class="form-label">Destination</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['port_of_landing'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2">
                                        <label for="country_of_destination" class="form-label">Country of Destination</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['country_of_destination'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2">
                                        <label for="incoterm" class="form-label">IncoTerm</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['incoterm'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-0  border-x-1 border-top-0">
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="provider_id" class="form-label">Provider Name</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['provider']['provider_name'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="container_type" class="form-label">Container Type</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['container_type'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="bl_number" class="form-label">BL Number</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['bl_number'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="shipping_line" class="form-label">Shipping Line</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['shipping_line'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="vessel" class="form-label">Vessel</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['vessel'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="commercial_invoice" class="form-label">Commercial Invoice</label>
                                        <br>
                                        @if(!empty($shipment['commercial_invoice']))
                                            <a target="_blank" href="{{ url('/'.$shipment['commercial_invoice']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                Not Uploaded
                                            </a>
                                        @endif
                                    </div>

                                </div>
                                <div class="row mb-0  border-x-1 border-top-0">
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="etd" class="form-label">ETD</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['etd'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="eta" class="form-label">ETA</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['eta'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="bl_telex_release" class="form-label">BL / Telex Release</label>
                                        <br>
                                        @if(!empty($shipment['bl_telex_release']))
                                            <a target="_blank" href="{{ url('/'.$shipment['bl_telex_release']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                Not Uploaded
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="packing_list" class="form-label">Packing List</label>
                                        <br>
                                        @if(!empty($shipment['packing_list']))
                                            <a target="_blank" href="{{ url('/'.$shipment['packing_list']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                Not Uploaded
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="origin_certificate" class="form-label">Origin Certificate</label>
                                        <br>
                                        @if(!empty($shipment['origin_certificate']))
                                            <a target="_blank" href="{{ url('/'.$shipment['origin_certificate']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                Not Uploaded
                                            </a>
                                        @endif
                                    </div>

                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="phytosanitary" class="form-label">Phytosanitary</label>
                                        <br>
                                        @if(!empty($shipment['phytosanitary']))
                                            <a target="_blank" href="{{ url('/'.$shipment['phytosanitary']) }}" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @else
                                            <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                Not Uploaded
                                            </a>
                                        @endif
                                    </div>

                                </div>
                                <div class="row mb-0  border-x-1 border-top-0">
                                    <!-- <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="freight" class="form-label">Freight $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['freight'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="insurance" class="form-label">Insurance $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['insurance'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="exchange_rate" class="form-label">Exchange Rate $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['exchange_rate'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="duties" class="form-label">Duties $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['duties'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="tax" class="form-label">Tax $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['tax'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="unpack" class="form-label">Unpack $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['unpack'] }}</label>
                                    </div>
                                </div>
                                <div class="row mb-0  border-x-1 border-top-0">
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="transport" class="form-label">Transport $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['transport'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="penalty" class="form-label">Penalty $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['penalty'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="other_fee" class="form-label">Other Fee $</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['other_fee'] }}</label>
                                    </div>
                                    <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                        <label for="total_shipment_cost" class="form-label">Total Cost $</label>
                                        <br>
                                        <label class="font-bold"></label>
                                    </div> -->
                                    <div class="col-lg-4 col-xl-4 border-1 p-2 border-top-0">
                                        <label for="other_fee" class="form-label">Comments</label>
                                        <br>
                                        <label class="font-bold">{{ $shipment['shipment_comment'] }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    @if(!empty($shipment['purchase_costs']))
                        <section class="section">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3">Purchase Costs</h5>
                                    <div class="row mb-0 border-x-1 border-top-1">
                                        <div class="col-lg-3 col-xl-3 border-1 p-2 fw-bold">Cost Date</div>
                                        <div class="col-lg-3 col-xl-3 border-1 p-2 fw-bold">Cost Name</div>
                                        <div class="col-lg-3 col-xl-3 border-1 p-2 fw-bold">Cost Amount $</div>
                                        <div class="col-lg-3 col-xl-3 border-1 p-2 fw-bold">Description</div>
                                    </div>
                                    @php $totalCost = 0; @endphp
                                    @foreach($shipment['purchase_costs'] as $cost)
                                    <div class="row mb-0 border-x-1 border-top-0">
                                        <div class="col-lg-3 col-xl-3 border-1 p-2 border-top-0">{{ $cost['cost_date'] }}</div>
                                        <div class="col-lg-3 col-xl-3 border-1 p-2 border-top-0">{{ $cost['cost_name'] }}</div>
                                        <div class="col-lg-3 col-xl-3 border-1 p-2 border-top-0">$ {{ number_format($cost['cost_amount']) }}</div>
                                        <div class="col-lg-3 col-xl-3 border-1 p-2 border-top-0">{{ $cost['description'] }}</div>
                                    </div>
                                        @php $totalCost += $cost['cost_amount']; @endphp
                                    @endforeach
                                    <div class="row mb-0 border-x-1 border-top-0">
                                        <div class="col-lg-6 col-xl-6 border-1 p-2 border-top-0 text-end fw-bold">Total Costs:</div>
                                        <div class="col-lg-6 col-xl-6 border-1 p-2 border-top-0 fw-bold">$ {{ number_format($totalCost) }}</div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif

                    @php
                        $timestamp = time();
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
                            @php if(isset($groupedByContainer[$timestamp][$c][1]['lot_number'])){ @endphp
                            <table class="table table-bordered table-nowrap table-part-category mb-0 mt-5" style="table-layout: auto">
                                <thead class="table-light border-1">
                                <tr>
                                    <th class="text-left px-4" colspan="14">Container No. {{$c}}</th>
                                </tr>
                                </thead>
                            </table>
                            @php } @endphp
                            @for($i=1; $i<=9; $i++)
                                @php if(isset($groupedByContainer[$timestamp][$c][$i]['lot_number'])){ @endphp
                                @php ($i%2)==1 ? $bg ='#ffffff' : $bg ='#fbfbfb'; @endphp
                                <div id="tr_{{$c}}_{{$i}}" class="p-3" style="border:1px solid #ccc;display:none; background-color:{{$bg}}">
                                    <div class="row">
                                        <div class="col-lg-8 col-xl-8">
                                            <div class="row mb-0  border-x-1 border-top-0">
                                                <div class="col-lg-2 col-xl-2 border-1 p-2">
                                                    <label class="form-label">{{ ($i) }}. Lot Number</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['lot_number'])){ echo $groupedByContainer[$timestamp][$c][$i]['lot_number'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2">
                                                    <label class="form-label">Product</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['item']['item_name'])){ echo $groupedByContainer[$timestamp][$c][$i]['item']['item_name'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2">
                                                    <label class="form-label">Package KG</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['package_kg'])){ echo $groupedByContainer[$timestamp][$c][$i]['package_kg'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2">
                                                    <label for="type_of_package_{{$c}}_{{$i}}" class="form-label">Type of Package</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['type_of_package'])){ echo $groupedByContainer[$timestamp][$c][$i]['type_of_package'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2">
                                                    <label for="total_packages" class="form-label">Total Packages</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['total_packages'])){ echo $groupedByContainer[$timestamp][$c][$i]['total_packages'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-1 col-xl-1 border-1 p-2">
                                                    <label for="unit_{{$c}}_{{$i}}" class="form-label">Unit</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['unit'])){ echo $groupedByContainer[$timestamp][$c][$i]['unit'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-1 col-xl-1 border-1 p-2">
                                                    <label for="total_qty_{{$c}}_{{$i}}" class="form-label">Total Qty</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['total_qty'])){ echo $groupedByContainer[$timestamp][$c][$i]['total_qty'];} @endphp</label>
                                                </div>
                                            </div>

                                            <div class="row mb-0  border-x-1">
                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="price_per_unit_{{$c}}_{{$i}}" class="form-label">Price per Unit $</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['price_per_unit'])){ echo $groupedByContainer[$timestamp][$c][$i]['price_per_unit'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="total_price_{{$c}}_{{$i}}" class="form-label">Total Price $</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['total_price'])){ echo $groupedByContainer[$timestamp][$c][$i]['total_price'];} @endphp</label>
                                                </div>

                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="manufacture_date_{{$c}}_{{$i}}" class="form-label">Manufacture Date</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['manufacture_date'])){ echo $groupedByContainer[$timestamp][$c][$i]['manufacture_date'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="crop_year_{{$c}}_{{$i}}" class="form-label">Crop Year</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['crop_year'])){ echo $groupedByContainer[$timestamp][$c][$i]['crop_year'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="shelf_life_{{$c}}_{{$i}}" class="form-label">Shelf Life</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['shelf_life'])){ echo $groupedByContainer[$timestamp][$c][$i]['shelf_life'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="best_before_{{$c}}_{{$i}}" class="form-label">Best Before</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['best_before'])){ echo $groupedByContainer[$timestamp][$c][$i]['best_before'];} @endphp</label>
                                                </div>
                                            </div>
                                            <div class="row mb-0  border-x-1 border-top-0">
                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="loading_report_{{$c}}_{{$i}}" class="form-label">Loading Report</label>
                                                    @if(!empty($groupedByContainer[$timestamp][$c][$i]['loading_report']))
                                                        <a target="_blank"
                                                           href="{{ url('/'.$groupedByContainer[$timestamp][$c][$i]['loading_report']) }}"
                                                           class="btn btn-youtube font-sm btn-outline-danger">
                                                            <i class="material-icons md-picture_as_pdf fs-6"></i>
                                                        </a>
                                                    @else
                                                        <a class="btn btn-info disabled font-sm btn-outline-danger">
                                                            Not Uploaded
                                                        </a>
                                                    @endif
                                                </div>

                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="surveyor_name_{{$c}}_{{$i}}" class="form-label">Surveyor Name</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['surveyor_name'])){ echo $groupedByContainer[$timestamp][$c][$i]['surveyor_name'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-2 col-xl-2 border-1 p-2 border-top-0">
                                                    <label for="loading_date_{{$c}}_{{$i}}" class="form-label">Loading Date</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['loading_date'])){ echo $groupedByContainer[$timestamp][$c][$i]['loading_date'];} @endphp</label>
                                                </div>
                                                <div class="col-lg-12 col-xl-12 p-4">
                                                        <?php
                                                    if(isset($groupedByContainer[$timestamp][$c][$i]['photos'])){
                                                    foreach($groupedByContainer[$timestamp][$c][$i]['photos'] as $photo){ ?>
                                                    <div id="img_container_{{$photo['lot_unique']}}_{{$photo['id']}}" class="float-start p-3">

                                                        <img src="{{url('/'.$photo['photo_url'])}}" style="max-width:200px; max-height:150px;">
                                                        <input type="hidden" name="photos[{{$photo['lot_unique']}}][]" id="photos_{{$photo['lot_unique']}}_{{$photo['id']}}" value="{{$photo['photo_url']}}">
                                                    </div>

                                                        <?php
                                                    }
                                                    } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2 border-1 p-2">
                                            <div class="row mb-2">
                                                <div class="col-lg-12 col-xl-12">
                                                    <label for="item_description_{{$c}}_{{$i}}" class="form-label">Description</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['item_description'])){ echo $groupedByContainer[$timestamp][$c][$i]['item_description'];} @endphp</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-xl-2 border-1 p-2">
                                            <div class="row mb-2">
                                                <div class="col-lg-12 col-xl-12">
                                                    <label for="lot_comment_{{$c}}_{{$i}}" class="form-label">Comments</label>
                                                    <br>
                                                    <label class="font-bold">@php if(isset($groupedByContainer[$timestamp][$c][$i]['lot_comment'])){ echo $groupedByContainer[$timestamp][$c][$i]['lot_comment'];} @endphp</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                @php } @endphp
                            @endfor
                        </div>
                    @endfor
                    <br><br>


            </div>
        </div>
    </section>
@endsection

@push('scripts')

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

@endpush
