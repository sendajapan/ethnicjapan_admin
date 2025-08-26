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
        background-color:rgba(199, 212, 226, 0.01);
        font-weight: bold;
    }

    .total-row td, .grand-row td{
        background-color:rgba(199, 212, 226, 0.01);

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
                <th>Product Pic</th>
                <th>Product Name</th>
                <th>Shipment Cost Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventory as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td>
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
                    <td>{{ $item->item->item_name ?? 'N/A' }}</td>
                    <td style="padding: 0;">
                        <table class="table table-bordered mb-0" style="border: 1px solid #000; table-layout: fixed; width: 100%;">
                            <thead>
                                <tr style="background-color:rgb(208, 234, 255);">
                                    <th style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 8%;">No.</th>
                                    <th style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%;">Cost Date</th>
                                    <th style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%;">Total Qty</th>
                                    <th style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 14%;">Cost Amount $</th>
                                    <th style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%;">Exchange Rate</th>
                                    <th style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 16%;">Total Cost in Yen ¥</th>
                                    <th style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 14%;">Other Costs</th>
                                    <th style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%;">Cost Per Kg</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($item['lots'] as $lotIndex => $lot)
                                    @php
                                        $lastTwo = substr($lot['lot_unique'], -2);
                                        $containerIndex = (int) substr($lastTwo, 0, 1);
                                        $lotNum = (int) substr($lastTwo, 1, 1);
                                    @endphp
                                    <tr>
                                        <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 8%; word-wrap: break-word;">{{ $lotIndex + 1 }}.</td>
                                        <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%; word-wrap: break-word;">{{ $lot->shipment->invoice_date ?? 'N/A' }}</td>
                                        <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%; word-wrap: break-word;">{{ number_format($lot['total_qty'], 0) }} Kg</td>
                                        <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 14%; word-wrap: break-word;">$ {{ number_format($lot['total_price'], 0) }}</td>
                                        <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%; word-wrap: break-word;">{{ $lot->shipment->exchange_rate ?? 'N/A' }}</td>
                                        <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 16%; word-wrap: break-word;">¥ {{ number_format($lot['cif'], 0) }}</td>
                                        <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 14%; word-wrap: break-word;">¥ {{ number_format($lot['lot_other_costs'], 0) }}</td>
                                        <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%; word-wrap: break-word;">¥ {{ number_format($lot['final_cost_per_kg'], 0) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="total-row" style="background-color: #ebebeb; font-weight: 600;">
                                    <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 8%; word-wrap: break-word;"></td>
                                    <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%; text-align: center; word-wrap: break-word;">Total:</td>
                                    <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%; word-wrap: break-word;">{{ number_format($item['product_totals']['qty'], 0) }} Kg</td>
                                    <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 14%; word-wrap: break-word;">$ {{ number_format($item['product_totals']['cost'], 0) }}</td>
                                    <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%; word-wrap: break-word;"></td>
                                    <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 16%; word-wrap: break-word;">¥ {{ number_format($item['product_totals']['cif_yen'], 0) }}</td>
                                    <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 14%; word-wrap: break-word;">¥ {{ number_format($item['product_totals']['other_costs'], 0) }}</td>
                                    <td style="border: 1px solid #000; padding: 4px 8px; font-size: 13px; width: 12%; word-wrap: break-word;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No inventory items found</td>
                </tr>
            @endforelse
            @if($inventory->count() > 0)
                <tr>
                    <td colspan="3"></td>
                    <td style="padding: 0;">
                        <table class="table table-bordered mb-0" style="border: 1px solid #000; table-layout: fixed; width: 100%;">
                            <tbody>
                                <tr class="grand-row" style="background-color:#cfcfcf; font-weight: 600;">
                                    <td style="border: 1px solid #000; font-size: 13px; text-align: center; width: 20%; word-wrap: break-word;">Purchase Grand Costs:</td>
                                    <td style="border: 1px solid #000; font-size: 13px; width: 12%; word-wrap: break-word;">{{ number_format($grandTotals['qty'], 0) }} Kg</td>
                                    <td style="border: 1px solid #000; font-size: 13px; width: 14%; word-wrap: break-word;">$ {{ number_format($grandTotals['cost'], 0) }}</td>
                                    <td style="border: 1px solid #000; font-size: 13px; width: 12%; word-wrap: break-word;"></td>
                                    <td style="border: 1px solid #000; font-size: 13px; width: 16%; word-wrap: break-word;">¥ {{ number_format($grandTotals['cif_yen'], 0) }}</td>
                                    <td style="border: 1px solid #000; font-size: 13px; width: 14%; word-wrap: break-word;">¥ {{ number_format($grandTotals['other_costs'], 0) }}</td>
                                    <td style="border: 1px solid #000; font-size: 13px; width: 12%; word-wrap: break-word;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            @endif
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
