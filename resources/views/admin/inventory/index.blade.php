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

    table tfoot tr td {
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
                <th>Product Pic</th>
                <th>Product Name</th>
                <th>Total Packages</th>
                <th>Total Quantity</th>
                <th>Purchase Cost</th>
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
                    <td>{{ number_format($item->total_packages) }} {{ $item->type_of_package }}</td>
                    <td>{{ number_format($item->total_qty, 0) }} Kg</td>
                    <td>${{ number_format($item->total_cost, 0) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No inventory items found</td>
                </tr>
            @endforelse
        </tbody>
        @if($inventory->count() > 0)
        <tfoot>
            <tr style="background-color: rgb(230, 230, 230); font-size: 15px; font-weight:600;">
                <td colspan="3" class="text-end">Total</td>
                <td><strong>{{ number_format($inventory->sum('total_packages')) }}</strong></td>
                <td><strong>{{ number_format($inventory->sum('total_qty'), 0) }} Kg</strong></td>
                <td><strong>${{ number_format($inventory->sum('total_cost'), 0) }}</strong></td>
            </tr>
        </tfoot>
        @endif
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
