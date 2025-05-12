@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h4 class="content-title card-title">Sale Data Report</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12 col-xxl-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive p-5">

                          @foreach($data as $year => $yearly_data)
                              <h1>{{$year}}</h1>
                                <div class="row">
                                    <div class="col-3">

                                        <table class="table table-striped table-hover" id="table_{{$year}}_01">
                                            <thead>
                                            <tr>
                                                <th scope="col">Month</th>
                                                <th class="text-end" scope="col" data-sortable="true">Total Sales</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $total_amount = 0;
                                            @endphp
                                            @foreach($yearly_data['by_month'] as $month => $line_total)
                                                <tr>
                                                    <td>{{$year." - ".date("F", strtotime("2025-".$month."-01"))}}</td>
                                                    <td class="text-end">$ {{ number_format($line_total) }}</td>
                                                </tr>
                                                @php
                                                    $total_amount += $line_total;
                                                @endphp
                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th class="text-end">$ {{ number_format($total_amount) }}</th>
                                            </tr>
                                            </tfoot>
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="col-3 offset-1">

                                            <table class="table table-striped table-hover" id="table_{{$year}}_02">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Month</th>
                                                    <th class="text-end" scope="col">Total Purchases</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php
                                                    $total_amount = 0;
                                                @endphp
                                                @foreach($yearly_data['by_item'] as $item => $line_total)
                                                    <tr>
                                                        <td nowrap>{{$item}}</td>
                                                        <td class="text-end">$ {{ number_format($line_total) }}</td>
                                                    </tr>
                                                    @php
                                                        $total_amount += $line_total;
                                                    @endphp
                                                @endforeach
                                                <tfoot>
                                                <tr>
                                                    <th>Total</th>
                                                    <th class="text-end">$ {{ number_format($total_amount) }}</th>
                                                </tr>
                                                </tfoot>
                                                </tbody>
                                            </table>
                                        </div>
                                    <div class="col-3 offset-1">

                                                <table class="table table-striped table-hover" id="table_{{$year}}_03">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Month</th>
                                                        <th class="text-end" scope="col">Total Purchases</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php
                                                        $total_amount = 0;
                                                    @endphp
                                                    @foreach($yearly_data['by_customer'] as $customer => $line_total)
                                                        <tr>
                                                            <td>{{$customer}}</td>
                                                            <td class="text-end">$ {{ number_format($line_total) }}</td>
                                                        </tr>
                                                        @php
                                                             $total_amount += $line_total;
                                                        @endphp
                                                    @endforeach
                                                    <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th class="text-end">$ {{ number_format($total_amount) }}</th>
                                                    </tr>
                                                    </tfoot>
                                                    </tbody>
                                                </table>

                                                <div class="pt-30">@php echo $yearly_data['chart'] @endphp</div>

                                            </div>
                                </div>
                                <br><hr><br>

                            @endforeach

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
        @foreach($data as $year => $yearly_data)
        new DataTable('#table_{{$year}}_01', {
            paging: false,
            search: false
        });
        new DataTable('#table_{{$year}}_02', {
            paging: false,
            search: false
        });
        new DataTable('#table_{{$year}}_03', {
            paging: false,
            search: false
        });
        @endforeach

    </script>
@endpush

<style>
    td{padding:0.2rem 0.5rem !important;}
    th{font-weight: bold !important;}
</style>
