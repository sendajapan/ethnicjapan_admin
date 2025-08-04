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
                <h4 class="content-title card-title">Create New Purchase</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Please enter purchase information</h5>
                        <form action="{{ route('admin.purchase.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-2 col-xl-2">
                                    <label for="invoice_number" class="form-label">Purchase/Invoice No.</label>
                                    <input type="text" placeholder="" class="form-control" id="invoice_number" name="invoice_number"  value="{{ old('invoice_number') }}" required>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="invoice_date" class="form-label">Purchase/Invoice Date</label>
                                    <input type="date" placeholder="" class="form-control" id="invoice_date" name="invoice_date"  value="{{ empty(old('invoice_date')) ? date("Y-m-d")  : old('invoice_date') }}" required>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="port_of_loading" class="form-label">Port of Loading</label>
                                    <select class="form-select" id="port_of_loading" name="port_of_loading"  >
                                        <option value="">Select</option>
                                        @foreach(Ports::orderBy('port_name')->whereNotIn('country_name', ['Japan'])->get() as $p)
                                            <option value="{{ $p->port_name }}"  >{{ $p->port_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="port_of_landing" class="form-label">Port of Landing</label>
                                    <select class="form-select" id="port_of_landing" name="port_of_landing"  >
                                        <option value="">Select</option>
                                        @foreach(Ports::orderBy('port_name')->whereIn('country_name', ['Japan'])->get() as $p)
                                            <option value="{{ $p->port_name }}"  >{{ $p->port_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="country_of_destination" class="form-label">Country of Destination</label>
                                    <select class="form-select" id="country_of_destination" name="country_of_destination"  >
                                        <option value="">Select</option>
                                        @foreach(Countries::orderBy('country_name')->whereIn('country_name', ['Japan'])->get() as $p)
                                            <option value="{{ $p->country_name }}"  >{{ $p->country_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="incoterm" class="form-label">IncoTerm</label>
                                    <select class="form-select" id="incoterm" name="incoterm"  >
                                        <option value="">Select</option>
                                        @foreach(DataIncoterm::orderBy('incoterm')->get() as $p)
                                            <option value="{{ $p->incoterm }}"  >{{ $p->incoterm }}</option>
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
                                            <option value="{{ $p->id }}">{{ $p->provider_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="container_type" class="form-label">Container Type</label>
                                    <select class="form-select" id="container_type" name="container_type"  >
                                        <option value="">Select</option>
                                        @foreach(DataContainerType::orderBy('container_type')->get() as $p)
                                            <option value="{{ $p->container_type }}"  >{{ $p->container_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="bl_number" class="form-label">BL Number</label>
                                    <input type="text" class="form-control" id="bl_number" name="bl_number"  value="{{ old('bl_number') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="shipping_line" class="form-label">Shipping Line</label>
                                    <input type="text" class="form-control" id="shipping_line" name="shipping_line"  value="{{ old('shipping_line') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="vessel" class="form-label">Vessel</label>
                                    <input type="text" class="form-control" id="vessel" name="vessel"  value="{{ old('vessel') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="commercial_invoice" class="form-label">Commercial Invoice</label>
                                    <input type="file" class="form-control" id="commercial_invoice" name="commercial_invoice"  value="{{ old('commercial_invoice') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2 col-xl-2">
                                    <label for="eta" class="form-label">ETA</label>
                                    <input type="date" class="form-control" id="eta" name="eta"  value="{{ old('eta') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="etd" class="form-label">ETD</label>
                                    <input type="date" class="form-control" id="etd" name="etd"  value="{{ old('etd') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="bl_telex_release" class="form-label">BL / Telex Release</label>
                                    <input type="file" class="form-control" id="bl_telex_release" name="bl_telex_release"  value="{{ old('bl_telex_release') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="packing_list" class="form-label">Packing List</label>
                                    <input type="file" class="form-control" id="packing_list" name="packing_list"  value="{{ old('packing_list') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="origin_certificate" class="form-label">Origin Certificate</label>
                                    <input type="file" class="form-control" id="origin_certificate" name="origin_certificate"  value="{{ old('origin_certificate') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="phytosanitary" class="form-label">Phytosanitary</label>
                                    <input type="file" class="form-control" id="phytosanitary" name="phytosanitary"  value="{{ old('phytosanitary') }}">
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="col-lg-2 col-xl-2">
                                    <label for="freight" class="form-label">Freight</label>
                                    <input type="text" class="form-control" id="freight" name="freight" onkeyup="calc_shipment()" value="{{ old('freight') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="insurance" class="form-label">Insurance</label>
                                    <input type="text" class="form-control" id="insurance" name="insurance"  onkeyup="calc_shipment()" value="{{ old('insurance') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="exchange_rate" class="form-label">Exchange Rate</label>
                                    <input type="text" class="form-control" id="exchange_rate" name="exchange_rate"  value="{{ old('exchange_rate') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="duties" class="form-label">Duties</label>
                                    <input type="text" class="form-control" id="duties" name="duties"  onkeyup="calc_shipment()" value="{{ old('duties') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="tax" class="form-label">Tax</label>
                                    <input type="text" class="form-control" id="tax" name="tax"  onkeyup="calc_shipment()" value="{{ old('tax') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="unpack" class="form-label">Unpack</label>
                                    <input type="text" class="form-control" id="unpack" name="unpack"  onkeyup="calc_shipment()" value="{{ old('unpack') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-2 col-xl-2">
                                    <label for="transport" class="form-label">Transport</label>
                                    <input type="text" class="form-control" id="transport" name="transport"  onkeyup="calc_shipment()" value="{{ old('transport') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="penalty" class="form-label">Penalty</label>
                                    <input type="text" class="form-control" id="penalty" name="penalty"  onkeyup="calc_shipment()" value="{{ old('penalty') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="other_fee" class="form-label">Other Fee</label>
                                    <input type="text" class="form-control" id="other_fee" name="other_fee"  onkeyup="calc_shipment()" value="{{ old('other_fee') }}">
                                </div>
                                <div class="col-lg-2 col-xl-2">
                                    <label for="total_shipment_cost" class="form-label">Total Cost</label>
                                    <input type="text" class="form-control" id="total_shipment_cost" name="total_shipment_cost"  value="0">
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <label for="other_fee" class="form-label">Comments</label>
                                    <input type="text" class="form-control" id="shipment_comment" name="shipment_comment"  value="{{ old('shipment_comment') }}">
                                </div>



                            </div>





                            <section>&nbsp;</section>


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
                                                            <input type="text" class="form-control" id="package_kg_{{$c}}_{{$i}}" name="package_kg[{{$c}}][{{$i}}]" onkeyup="calc_lot({{$c}},{{$i}});" value="">
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
                                                            <input type="text" class="form-control" id="total_packages_{{$c}}_{{$i}}" name="total_packages[{{$c}}][{{$i}}]" onkeyup="calc_lot({{$c}},{{$i}});" value="">
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
                                                            <input type="text" class="form-control  p-1" id="total_qty_{{$c}}_{{$i}}" name="total_qty[{{$c}}][{{$i}}]" onkeyup="calc_lot({{$c}},{{$i}});" value="">
                                                        </div>
                                                    </div>



                                                    <div class="row mb-2">
                                                        <div class="col-lg-2 col-xl-2">
                                                            <label for="price_per_unit_{{$c}}_{{$i}}" class="form-label">Price per Unit</label>
                                                            <input type="text" class="form-control" id="price_per_unit_{{$c}}_{{$i}}" name="price_per_unit[{{$c}}][{{$i}}]" onkeyup="calc_lot({{$c}},{{$i}});" value="">
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
                                <button class="btn btn-primary btn-block rounded" type="submit" name="submit">SAVE SHIPMENT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')



    <script src="{{url('assets/filepond/jquery.js')}}"></script>
    <script src="{{url('assets/filepond/filepond.min.js')}}"></script>
    <script src="{{url('assets/filepond/filepond.jquery.js')}}"></script>
    <script>
        for(c=1; c<=9; c++) {
            for(i=1; i<=9; i++){
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
                                console.log(c+'_'+i);
                                //console.log($('#lot_unique_'+c+'_'+i).val());
                                formData.append('lot_unique', '123');
                                return formData;
                            },
                        }
                    }
                });
            }
        }


    function show_line(c){
            for(i=1; i<=9; i++){
                if ($('#tr_'+c+'_'+i).length){
                    if($('#tr_'+c+'_'+i+':visible').length == 0) {
                        $('#tr_'+c+'_'+i).show();
                        if (i == 9) {
                            $('#add_btn_'+c).hide();
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
                    text: "Changes will be finalized when you submit page!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, remove it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#tr_'+c+'_'+i).remove();
                    }
                });
            }
        }

        function show_container(){
            for(i=1; i<=9; i++){
                if ($('#container_'+i).length){
                    if($('#container_'+i+':visible').length == 0) {
                        $('#container_' + i).show();
                        if (i == 9) {
                            $('#add_container').hide();
                        }
                        show_line(i);
                        break;
                    }
                }
            }
        }


        show_container();

        function update_line(i){
            unit_price = parseFloat(document.getElementById('item_unit_price_'+i).value);
            item_qty = parseFloat(document.getElementById('item_qty_'+i).value);
            line_total = parseFloat(unit_price*item_qty).toFixed(2);
            if(!isNaN(line_total)){
                document.getElementById('item_line_price_'+i).value = line_total;
            }
            else{
                document.getElementById('item_line_price_'+i).value = 0;
            }
            get_total();
        }

        function get_total(){
            var total_purchase_amount = 0;
            for(i=0; i<20; i++){
                if ($('#tr_'+i).length){
                    if($('#tr_'+i+':visible').length != 0) {
                        each_total = parseFloat(parseFloat(parseFloat(document.getElementById('item_unit_price_'+i).value)*parseFloat(document.getElementById('item_qty_'+i).value)).toFixed(2));
                        if(!isNaN(each_total)){
                            total_purchase_amount = parseFloat(total_purchase_amount) + parseFloat(each_total);
                        }
                    }
                }
            }
            document.getElementById('purchase_amount').value = total_purchase_amount;
        }



        function update_item_info(i){
            selected_item_id = document.getElementById('item_id_'+i).value

            @php
                foreach($items as $p){
            @endphp
            if(selected_item_id == {{$p['id']}}){
                item_description = '{{$p['item_description']}}';
                item_hts_code = '{{$p['hts_code']}}';
                default_price = '{{$p['default_price']}}';
                $('#item_description_'+i).html(item_description);
                $('#item_hts_code_'+i).html(item_hts_code);
                $('#item_unit_price_'+i).val(default_price);
            }
            @php
                }
            @endphp


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

            var total = parseFloat(freight) + parseFloat(insurance) + parseFloat(duties) + parseFloat(tax) + parseFloat(unpack) + parseFloat(transport) + parseFloat(penalty) + parseFloat(other_fee);
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
