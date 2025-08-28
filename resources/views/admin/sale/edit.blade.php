@php use App\Models\Customer; @endphp
@php use App\Models\Item; @endphp
@extends('admin.layouts.master')


@php
    $items = array();

    foreach (Item::orderBy('item_name')->get() as $p){
        $items[] = $p;
    }

   // \Barryvdh\Debugbar\Facades\Debugbar::info($data);
@endphp

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Create New Sale</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>Please enter sale information</h5>
                        <form action="{{ route('admin.sale.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="customer_id" class="form-label">Customer Name</label>
                                        <select class="form-select" id="customer_id" name="customer_id"  value="{{ $data->customer_id }}" required>
                                            <option value="">Select</option>
                                            @foreach(Customer::orderBy('customer_name')->get() as $p)
                                                <option value="{{ $p->id }}" {{ $p->id == $data->customer->id ? 'selected' : '' }}>{{ $p->customer_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label for="sale_no" class="form-label">Sale No.</label>
                                        <input type="text" placeholder="ex. Sale Invoice No." class="form-control" id="sale_no" name="sale_no"  value="{{ $data->sale_no }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="mb-4">
                                        <label for="sale_date" class="form-label">Sale Date</label>
                                        <input type="date" placeholder="ex. Sale Date." class="form-control" id="sale_date" name="sale_date"  value="{{ empty($data->sale_date) ? date("Y-m-d")  : $data->sale_date }}" required>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-2">
                                    <div class="mb-4">
                                        <label for="sale_amount" class="form-label">Sale Amount (USD)</label>
                                        <input type="text" placeholder="ex. 99.50" class="form-control" id="sale_amount" name="sale_amount"  value="{{ empty($data->sale_amount) ? old('sale_amount')  : $data->sale_amount }}" required>
                                    </div>
                                </div> --}}
                                <div class="col-lg-2">
                                    <div class="mb-4">
                                        <label for="sale_invoice" class="form-label">Sale Invoice</label>
                                        @if(!empty($data->sale_invoice))
                                            <a target="_blank" href="'.url('/'.$data->sale_invoice).'" class="btn btn-youtube font-sm btn-outline-danger">
                                                <i class="material-icons md-picture_as_pdf fs-6"></i>
                                            </a>
                                        @endif
                                        <input type="file" class="form-control" id="sale_invoice" name="sale_invoice"  value="{{ $data->sale_invoice }}">
                                    </div>
                                </div>
                            </div>

                            <section>&nbsp;</section>

                            <table class="table table-bordered table-nowrap table-part-category mb-0 mt-5" style="table-layout: auto">
                                <thead class="table-light border-1">
                                <tr>
                                    <th class="text-center px-4" width="60">S/N</th>
                                    <th class="text-left px-4">Item Name</th>
                                    <th class="text-left px-4">Item Qty</th>
                                    <th class="text-left px-4">Unit</th>
                                    <th class="text-left px-4">Item Price</th>
                                    <th class="text-left px-4">Total Price</th>
                                    <th class="text-left px-4">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($data->saledItems ?? [] as $i => $v)
                                    <tr id="tr_{{$i}}" style="display:none;">
                                        <td class="border-1 fw-bolder text-primary-emphasis text-center py-0">{{ ($i+1) }}</td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <!-- Hidden field to preserve sale item ID -->
                                            <input type="hidden" name="sale_item_id[]" value="{{ $data->saledItems[$i]['id'] ?? '' }}">
                                            <select class="form-select" id="item_id_{{$i}}" name="item_id[]" onchange="populate_price({{$i}})" value="{{ old('item_id') }}">
                                                <option value="">Select</option>
                                                @foreach($items as $p)
                                                    <option value="{{ $p['id'] }}" data-price="{{ $p['default_price'] }}" {{ $data->saledItems[$i]['item_id'] == $p['id'] ? 'selected' : '' }} >{{ $p['item_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" placeholder="ex. 5" class="form-control" id="item_qty_{{$i}}" name="item_qty[]" onkeyup="update_line({{$i}});"  value="{{ !empty($data->saledItems[$i]['item_qty']) ? $data->saledItems[$i]['item_qty'] : old('item_qty') }}">
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <select class="form-select" id="item_unit_{{$i}}" name="item_unit[]">
                                                <option value="Package" {{ (!empty($data->saledItems[$i]['item_unit']) && $data->saledItems[$i]['item_unit'] == 'Package') || empty($data->saledItems[$i]['item_unit']) ? 'selected' : '' }}>Package</option>
                                                <option value="Kg" {{ (!empty($data->saledItems[$i]['item_unit']) && $data->saledItems[$i]['item_unit'] == 'Kg') ? 'selected' : '' }}>Kg</option>
                                            </select>
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" placeholder="ex. 19.50" class="form-control" onkeyup="update_line({{$i}});" id="item_unit_price_{{$i}}" name="item_unit_price[]"  value="{{ !empty($data->saledItems[$i]['item_unit_price']) ? $data->saledItems[$i]['item_unit_price'] : old('item_unit_price') }}">
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" class="form-control" id="item_line_price_{{$i}}" name="item_line_price[]"  value="" readonly>
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
                                            <!-- Hidden field for new items (empty value) -->
                                            <input type="hidden" name="sale_item_id[]" value="">
                                            <select class="form-select" id="item_id_{{$i}}" name="item_id[]" onchange="populate_price({{$i}})" value="{{ old('item_id') }}">
                                                <option value="">Select</option>
                                                @foreach($items as $p)
                                                    <option value="{{ $p['id'] }}" data-price="{{ $p['default_price'] }}">{{ $p['item_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" class="form-control" id="item_qty_{{$i}}" name="item_qty[]" onkeyup="update_line({{$i}});"  value="{{ old('item_qty') }}">
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <select class="form-select" id="item_unit_{{$i}}" name="item_unit[]">
                                                <option value="Package" selected>Package</option>
                                                <option value="Kg">Kg</option>
                                            </select>
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text"  class="form-control" onkeyup="update_line({{$i}});" id="item_unit_price_{{$i}}" name="item_unit_price[]"  value="{{ old('item_unit_price') }}">
                                        </td>
                                        <td class="border-1 fw-bold py-0" style="font-size: 11px">
                                            <input type="text" class="form-control" id="item_line_price_{{$i}}" name="item_line_price[]"  value="" readonly>
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
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold border-1 py-2" style="background-color: #f8f9fa;">Subtotal:</td>
                                        <td class="border-1 fw-bold py-2 text-center" style="background-color: #f8f9fa;">
                                            <input type="text" id="subtotal" name="subtotal" class="form-control text-center fw-bold" value="0.00" readonly style="background-color: transparent; border: none;">
                                        </td>
                                        <td class="border-1" style="background-color: #f8f9fa;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold border-1 py-2" style="background-color: #e9ecef;"> Consumption tax 8%:</td>
                                        <td class="border-1 fw-bold py-2 text-center" style="background-color: #e9ecef;">
                                            <input type="text" id="tax_amount" name="tax_amount" class="form-control text-center fw-bold" value="0.00" readonly style="background-color: transparent; border: none;">
                                        </td>
                                        <td class="border-1" style="background-color: #e9ecef;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold border-1 py-2" style="background-color: #d1ecf1;">Total:</td>
                                        <td class="border-1 fw-bold py-2 text-center" style="background-color: #d1ecf1;">
                                            <input type="text" id="total_with_tax" name="total_with_tax" class="form-control text-center fw-bold" value="0.00" readonly style="background-color: transparent; border: none;">
                                        </td>
                                        <td class="border-1" style="background-color: #d1ecf1;"></td>
                                    </tr>
                                </tfoot>
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
                // Recalculate totals after removing a line
                calculate_totals();
            }
        }

        // Show existing sale items first
        @foreach($data->saledItems as $i => $v)
            $('#tr_{{ $i }}').show();
        @endforeach
        
        // Show additional empty lines for new items
       


        function populate_price(i) {
            var select = document.getElementById('item_id_' + i);
            var selectedOption = select.options[select.selectedIndex];
            var defaultPrice = selectedOption.getAttribute('data-price');
            
            if (defaultPrice && defaultPrice !== '') {
                document.getElementById('item_unit_price_' + i).value = defaultPrice;
                // Trigger calculation if quantity is already entered
                update_line(i);
            } else {
                document.getElementById('item_unit_price_' + i).value = '';
            }
        }

        function update_line(i){
            unit_price = parseFloat(document.getElementById('item_unit_price_'+i).value);
            item_qty = parseFloat(document.getElementById('item_qty_'+i).value);
            line_total = parseFloat(unit_price*item_qty).toFixed(2);

            if (!isNaN(line_total)) {
                document.getElementById('item_line_price_' + i).value = line_total;
            } else {
                document.getElementById('item_line_price_' + i).value = 0;
            }
            // Update totals after each line calculation
            calculate_totals();
        }

        function calculate_totals() {
            var subtotal = 0;
            
            // Calculate subtotal by summing all visible line totals
            for(var i = 0; i < 20; i++) {
                var lineTotal = document.getElementById('item_line_price_' + i);
                if(lineTotal && $('#tr_' + i + ':visible').length > 0) {
                    var lineValue = parseFloat(lineTotal.value) || 0;
                    subtotal += lineValue;
                }
            }
            
            // Calculate tax (8%)
            var taxAmount = subtotal * 0.08;
            
            // Calculate total with tax
            var totalWithTax = subtotal + taxAmount;
            
            // Update the display fields
            document.getElementById('subtotal').value = subtotal.toFixed(2);
            document.getElementById('tax_amount').value = taxAmount.toFixed(2);
            document.getElementById('total_with_tax').value = totalWithTax.toFixed(2);
        }

        @foreach($data->saledItems as $i => $v)
            update_line({{ $i }});
        @endforeach

        // Calculate initial totals when page loads
        calculate_totals();

    </script>
@endpush
