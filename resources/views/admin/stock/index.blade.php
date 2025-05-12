@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Total Stock Report</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xl-6 col-xxl-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">



                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item Name</th>
                                    <th class="text-end" scope="col">Stock Qty</th>
                                    <th class="text-end" scope="col">Unit Est. Price</th>
                                    <th class="text-end" scope="col">Estimated Total Worth</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $total_item_qty = 0;
                                    $total_amount = 0;
                                @endphp

                                @foreach($data as $key=>$d)
                                <tr>
                                    <td scope="row">{{ ($key+1) }}</td>
                                    <td>{{$d['item_name']}}</td>
                                    <td class="text-end">{{ number_format($d['item_qty']) }}</td>
                                    <td class="text-end">$ {{ number_format($d['default_price'],2) }}</td>
                                    <td class="text-end">$ {{ number_format(round($d['item_qty']*$d['default_price']/100) *100, 0 ) }}</td>
                                </tr>
                                    @php
                                        $total_item_qty += $d['item_qty'];
                                        $total_amount += round($d['item_qty']*$d['default_price']/100) *100;
                                    @endphp
                                @endforeach
                                <tr>
                                    <th colspan="2">Total</th>
                                    <th class="text-end">{{ number_format($total_item_qty) }}</th>
                                    <th class="text-end"></th>
                                    <th class="text-end">$ {{ number_format($total_amount) }}</th>
                                </tr>
                                </tbody>
                            </table>




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>

    <script>

    </script>

@endpush
