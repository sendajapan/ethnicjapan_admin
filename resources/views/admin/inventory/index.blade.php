@extends('admin.layouts.master')

@section('content')
<style>
    .inventory-image {
        max-width: 60px;
        max-height: 60px;
        object-fit: cover;
        border-radius: 5px;
    }
    .inventory-table {
        border: 2px solid #000;
        border-collapse: collapse;
    }
    .inventory-table th,
    .inventory-table td {
        border: 1px solid #000;
        padding: 8px 12px;
    }
    .inventory-table th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    table tfoot tr td, {
    background-color: transparent !important;
}

</style>

<section class="content-main">
    <div class="content-header">
        <div>
            <h4 class="content-title card-title">Inventory</h4>
        </div>
    </div>

    <table class="table inventory-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Cost Date</th>
                <th>Product Pic</th>
                <th>Product Name</th>
                <th>Total Qty</th>
                <th>Cost Amount $</th>
                <th>Exchange Rate</th>
                <th>Cost in Yen ¥</th>
                <th>Cost Per Kg</th>
                <th>Container / Lot</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventory as $index => $item)
                @foreach($item['lots'] as $lotIndex => $lot)
                    <tr>
                        @if($lotIndex == 0)
                            <td rowspan="{{ count($item['lots']) }}">{{ $index + 1 }}.</td>
                            <td rowspan="{{ count($item['lots']) }}">{{ $lot->shipment->invoice_date ?? 'N/A' }}</td>
                            <td rowspan="{{ count($item['lots']) }}">
                                @if(isset($item['photo']) && $item['photo'])
                                    <img src="{{ url('/storage/'.$item['photo']->photo_url) }}" 
                                         alt="Product Image" 
                                         class="inventory-image">
                                @else
                                    <img src="{{ url('/assets/imgs/item_placeholder.jpg') }}" 
                                         alt="No Image" 
                                         class="inventory-image">
                                @endif
                            </td>
                            <td rowspan="{{ count($item['lots']) }}">{{ $item->item->item_name ?? 'N/A' }}</td>
                        @endif
                        <td>{{ number_format($lot['total_qty'], 0) }} Kg</td>
                        <td>$ {{ number_format($lot['total_price'], 0) }}</td>
                        <td>{{ $lot->shipment->exchange_rate ?? 'N/A' }}</td>
                        <td>¥ {{ number_format($lot['cif'], 0) }}</td>
                        <td>
                            @if($lot['extra_shipment_charges'] > 0)
                                ¥ ({{ number_format($lot['cifyen'], 0) }} + {{ number_format($lot['extra_shipment_charges'], 0) }}) = {{ number_format($lot['final_cost_per_kg'], 0) }}
                            @else
                                ¥ {{ number_format($lot['cifyen'], 0) }}
                            @endif
                        </td>
                        <td>Cont. {{ $lot['container_index'] }} / Lot {{ $lot['lot_index_num'] }}</td>
                    </tr>
                @endforeach
                @if($index == count($inventory) - 1)
                    <tr class="td-footer" style="background-color: rgb(168, 168, 168); font-weight: 600;">
                        <td colspan="4" class="text-end">Purchase Costs:</td>
                        <td>{{ number_format($totals['total_qty'], 0) }} Kg</td>
                        <td>$ {{ number_format($totals['total_cost'], 0) }}</td>
                        <td></td>
                        <td>¥ {{ number_format($totals['total_cif_yen'], 0) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="10" class="text-center">No inventory items found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Summary Cards -->
    <!-- @if($inventory->count() > 0)
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-inventory"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Products</h6>
                        <span>{{ $inventory->count() }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success material-icons md-local_shipping"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Packages</h6>
                        <span>{{ number_format($inventory->sum('total_packages')) }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light">
                        <i class="text-warning material-icons md-scale"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Weight</h6>
                        <span>{{ number_format($inventory->sum('total_qty'), 2) }} Kg</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-info-light">
                        <i class="text-info material-icons md-monetization_on"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Total Value</h6>
                        <span>${{ number_format($inventory->sum('total_cost'), 2) }}</span>
                    </div>
                </article>
            </div>
        </div>
    </div>
    @endif -->
</section>
@endsection
