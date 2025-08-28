<div class="row mb-3">
    <div class="col-md-6">
        <h6><strong>Sale No:</strong> {{ $sale->sale_no }}</h6>
        <h6><strong>Customer:</strong> {{ $sale->customer->customer_name }}</h6>
    </div>
    <div class="col-md-6">
        <h6><strong>Sale Date:</strong> {{ $sale->sale_date }}</h6>
        <h6><strong>Total Items:</strong> {{ $sale->salesItems->count() }}</h6>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th class="text-center">No.</th>
                <th>Item</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Unit</th>
                <th class="text-end">Item Price</th>
                <th class="text-end">Amount</th>
                <th class="text-center">Lot Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->salesItems as $key => $item)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $item->item->item_name }}</td>
                <td class="text-center">{{ number_format($item->item_qty, 0) }}</td>
                <td class="text-center">{{ $item->item_unit ?? 'Package' }}</td>
                <td class="text-end">${{ number_format($item->item_unit_price, 2) }}</td>
                <td class="text-end">${{ number_format($item->item_line_price, 2) }}</td>
                <td class="text-center">
                    @if($item->lotTracking && $item->lotTracking->count() > 0)
                        @foreach($item->lotTracking as $tracking)
                            @if($tracking->lot_unique)
                                Lot {{ $tracking->lot_number ?? $tracking->lot_unique }}: {{ number_format($tracking->item_quantity, 0) }}kg
                                @if($tracking->lot_date)
                                    <br><small class="text-muted">({{ \Carbon\Carbon::parse($tracking->lot_date)->format('M d, Y') }})</small>
                                @endif
                                @if(!$loop->last)<br><br>@endif
                            @endif
                        @endforeach
                    @else
                        <span class="text-muted">No tracking</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="table-light">
            <tr>
                <td colspan="6" class="text-end fw-bold">Subtotal:</td>
                <td class="text-center fw-bold">${{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="6" class="text-end fw-bold">Tax 8%:</td>
                <td class="text-center fw-bold">${{ number_format($tax, 2) }}</td>
            </tr>
            <tr class="table-info">
                <td colspan="6" class="text-end fw-bold">Total:</td>
                <td class="text-center fw-bold">${{ number_format($totalWithTax, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
