@php use App\Models\Provider; @endphp
@php use App\Models\Item; @endphp
@extends('admin.layouts.master')


@php
    $items = array();

    foreach (Item::orderBy('item_name')->get() as $p){
        $items[] = $p;
    }

    \Barryvdh\Debugbar\Facades\Debugbar::info($data);
@endphp

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Purchase</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter purchase information</h5>
                        <form action="{{ route('admin.purchase.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="provider_id" class="form-label">Provider Name</label>
                                        <select class="form-select" id="provider_id" name="provider_id"  value="{{ $data->provider_id }}" required>
                                            <option value="">Select</option>
                                            @foreach(Provider::orderBy('provider_name')->get() as $p)
                                                <option value="{{ $p->id }}" {{ $p->id == $data->provider->id ? 'selected' : '' }}>{{ $p->provider_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="purchase_no" class="form-label">Purchase No.</label>
                                        <input type="text" placeholder="ex. Purchase Invoice No." class="form-control" id="purchase_no" name="purchase_no"  value="{{ $data->purchase_no }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-4">
                                        <label for="purchase_date" class="form-label">Purchase Date</label>
                                        <input type="date" placeholder="ex. Purchase Date." class="form-control" id="purchase_date" name="purchase_date"  value="{{ empty($data->purchase_date) ? date("Y-m-d")  : $data->purchase_date }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-4">
                                        <label for="purchase_amount" class="form-label">Purchase Amount (USD)</label>
                                        <input type="text" placeholder="ex. 99.50" class="form-control" id="purchase_amount" name="purchase_amount"  value="{{ empty($data->purchase_amount) ? old('purchase_amount')  : $data->purchase_amount }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-4">
                                        <label for="purchase_invoice" class="form-label">Purchase Invoice</label>
                                        @if(!empty($data->purchase_invoice))
                                            <a target="_blank" href="'.url('/'.$data->purchase_invoice).'" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @endif
                                        <input type="file" class="form-control" id="purchase_invoice" name="purchase_invoice"  value="{{ $data->purchase_invoice }}">
                                    </div>
                                </div>
                            </div>

                            <section>&nbsp;</section>

                            <table class="table table-bordered table-nowrap table-part-category mb-0 mt-5" style="table-layout: auto">
                                <thead class="table-light border-1">
                                <tr>
                                    <th class="text-center px-4" width="60">S/N</th>
                                    <th class="text-left px-4">Item Name</th>
                                    <th class="text-left px-4">Item Description</th>
                                    <th class="text-left px-4">Item Qty</th>
                                    <th class="text-left px-4">Unit Price</th>
                                    <th class="text-left px-4">Total</th>
                                    <th class="text-left px-4">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($data->purchasedItems as $i => $v)
                                    <tr id="tr_{{$i}}" style="display:none;">
                                        <td class="border-1 fw-bolder text-primary-emphasis text-center py-0">{{ ($i+1) }}</td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <select class="form-select" id="item_id" name="item_id[]"  value="{{ old('item_id') }}">
                                                <option value="">Select</option>
                                                @foreach($items as $p)
                                                    <option value="{{ $p['id'] }}" {{ $data->purchasedItems[$i]['item_id'] == $p['id'] ? 'selected' : '' }} >{{ $p['item_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <textarea placeholder="ex. description" class="form-control" id="item_description_{{$i}}" name="item_description[]" style="min-height:50px !important;" >{{ !empty($data->purchasedItems[$i]['item_description']) ? $data->purchasedItems[$i]['item_description'] : old('item_description') }}</textarea>
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" placeholder="ex. 5" class="form-control" id="item_qty_{{$i}}" name="item_qty[]" onkeyup="update_line({{$i}});"  value="{{ !empty($data->purchasedItems[$i]['item_qty']) ? $data->purchasedItems[$i]['item_qty'] : old('item_qty') }}">
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" placeholder="ex. 19.50" class="form-control" onkeyup="update_line({{$i}});" id="item_unit_price_{{$i}}" name="item_unit_price[]"  value="{{ !empty($data->purchasedItems[$i]['item_unit_price']) ? $data->purchasedItems[$i]['item_unit_price'] : old('item_unit_price') }}">
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" placeholder="ex. 39.50" class="form-control" id="item_line_price_{{$i}}" name="item_line_price[]"  value="" readonly>
                                        </td>
                                        <td width="120" class="border-1 py-0">
                                            <div class="d-flex justify-content-evenly text-end">
                                                <a id="hide_line{{$i}}" onclick="hide_line({{$i}})" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                                                    <i class="material-icons md-delete_forever fs-6"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @for($i=0; $i<20; $i++)
                                    <tr id="tr_{{$i}}" style="display:none;">
                                        <td class="border-1 fw-bolder text-primary-emphasis text-center py-0">{{ ($i+1) }}</td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <select class="form-select" id="item_id" name="item_id[]"  value="{{ old('item_id') }}">
                                                <option value="">Select</option>
                                                @foreach($items as $p)
                                                    <option value="{{ $p['id'] }}">{{ $p['item_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <textarea placeholder="ex. description" class="form-control" id="item_description_{{$i}}" name="item_description[]" style="min-height:50px !important;" >{{ old('item_description') }}</textarea>
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" placeholder="ex. 5" class="form-control" id="item_qty_{{$i}}" name="item_qty[]" onkeyup="update_line({{$i}});"  value="{{ old('item_qty') }}">
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" placeholder="ex. 19.50" class="form-control" onkeyup="update_line({{$i}});" id="item_unit_price_{{$i}}" name="item_unit_price[]"  value="{{ old('item_unit_price') }}">
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" placeholder="ex. 39.50" class="form-control" id="item_line_price_{{$i}}" name="item_line_price[]"  value="" readonly>
                                        </td>
                                        <td width="120" class="border-1 py-0">
                                            <div class="d-flex justify-content-evenly text-end">
                                                <a id="hide_line{{$i}}" onclick="hide_line({{$i}})" class="btn btn-sm delete-part-category font-sm rounded btn-danger">
                                                    <i class="material-icons md-delete_forever fs-6"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endfor




                                </tbody>
                            </table>
                            <div class="d-flex justify-content-start">
                                <a id="add_btn" onclick="show_line()" class="btn btn-sm  font-sm rounded btn-outline-secondary">
                                    <i class="material-icons md-add fs-6"></i> Add Item
                                </a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary btn-block rounded" type="submit" name="submit">SUBMIT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>

        function show_line(){
            for(i=0; i<20; i++){
                if ($('#tr_'+i).length){
                    if($('#tr_'+i+':visible').length == 0) {
                        $('#tr_' + i).show();
                        if (i == 19) {
                            $('#add_btn').hide();
                        }
                        break;
                    }
                }
            }
        }

        function hide_line(i){
            if(i!=''){
                $('#tr_'+i).remove();
            }
        }

        show_line();
        show_line();
        show_line();
        show_line();
        show_line();

        function update_line(i){
            unit_price = parseFloat(document.getElementById('item_unit_price_'+i).value);
            item_qty = parseFloat(document.getElementById('item_qty_'+i).value);
            line_total = parseFloat(unit_price*item_qty).toFixed(2);

            if (!isNaN(line_total)) {
                document.getElementById('item_line_price_' + i).value = line_total;
            } else {
                document.getElementById('item_line_price_' + i).value = 0;
            }
        }

        @foreach($data->purchasedItems as $i => $v)
            update_line({{ $i }});
        @endforeach

    </script>
@endpush
