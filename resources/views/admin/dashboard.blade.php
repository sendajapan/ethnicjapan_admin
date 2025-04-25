@php
    use App\Models\Part;
    use App\Models\PartCategory;
    use App\Models\Sale;
    use App\Models\Shipment;
    use App\Models\Vehicle;
    use Carbon\Carbon;
@endphp
@extends('admin.layouts.master')

@php
    $saleByDate = Sale::where('sold_at', '>=', Carbon::now()->subDays(10))->orderBy('sold_at', 'desc')->get()->groupBy(function ($sale){
        return $sale->sold_at;
    });

    $partCategories = PartCategory::all();
@endphp

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h3 class="content-title card-title">Dashboard</h3>
            </div>
            <div>
                <a href="{{ route('admin.cart.create') }}" class="btn btn-primary">
                    <i class="text-muted my-auto material-icons md-barcode"></i>
                    <span>START NEW SALE</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-xl-3">
                {{--bg-11 mb-4 animate__animated animate__fadeInUp animate__faster--}}
                <div class="card card-body mb-4 animate__animated animate__fadeInUp animate__fast">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-primary-light d-flex">
                            <i class="text-primary-dark material-icons md-monetization_on"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1 card-title">Total Sale</h6>
                            <span>$ {{ number_format($totalSale) }}</span>
                            <span class="text-sm">Sale from the beginning.</span>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3">
                {{--bg-11 mb-4 animate__animated animate__fadeInUp animate__faster--}}
                <div class="card card-body mb-4 animate__animated animate__fadeInUp animate__fast">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-info-subtle d-flex">
                            <i class="text-info-emphasis material-icons md-monetization_on"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1 card-title">This Month Sale</h6>
                            <span>$ {{ number_format($currentMonthSale) }}</span>
                            <span class="text-sm">Sale of current month.</span>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3">
                {{--bg-12 mb-4 animate__animated animate__fadeInUp animate__faster--}}
                <div class="card card-body mb-4 animate__animated animate__fadeInUp animate__fast">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-warning-subtle d-flex">
                            <i class="text-warning-emphasis material-icons md-local_shipping"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1 card-title">Vehicles</h6>
                            <span>{{ Vehicle::count() }}</span>
                            <span class="text-sm"> In {{ Shipment::count() }} shipmemt(s)</span>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3">
                {{--bg-8 mb-4 animate__animated animate__fadeInUp animate__faster--}}
                <div class="card card-body mb-4 animate__animated animate__fadeInUp animate__fast">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-danger-subtle d-flex">
                            <i class="text-danger-emphasis material-icons md-qr_code"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1 card-title">Parts</h6>
                            <span>{{ Part::count() }}</span>
                            <span class="text-sm"> In {{ Vehicle::count() }} vehicle(s)</span>
                        </div>
                    </article>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-7 col-xl-12">
                <div class="card mb-4">
                    <article class="card-body">
                        <h5 class="card-title">Sale By Part</h5>
                        <table class="table table-bordered table-sm mb-4">
                            <thead class="table-light">
                            <tr class="text-center border-1">
                                <th>S/N</th>
                                <th class="text-start">Part Name</th>
                                <th>Total Qty</th>
                                <th>Sold Qty</th>
                                <th>Remaining Qty</th>
                                <th>Sold Percentage</th>
                                <th>Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($partCategories as $partCategory)
                                <tr class="border-1">
                                    <td class="text-center border-1 fw-bold">{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="#" class="text-dark text-decoration-underline fw-bold" style="font-size: 11px">{{ strtoupper($partCategory->name) }}</a>
                                    </td>
                                    <td class="text-center">{{ $partCategory->getPartDetails()->total_quantity }}</td>
                                    <td class="text-center">{{ $partCategory->getPartDetails()->total_sold }}</td>
                                    <td class="text-center">{{ $partCategory->getPartDetails()->remaining_quantity }}</td>
                                    <td class="pe-4" width="25%">
                                        <div class="progress">
                                            <div
                                                class="progress-bar animate__animated animate__fadeInLeft animate__faster"
                                                role="progressbar"
                                                style="width: {{ $partCategory->getPartDetails()->total_quantity > 0 ? ($partCategory->getPartDetails()->total_sold / $partCategory->getPartDetails()->total_quantity) * 100 : 0 }}%">
                                                {{ $partCategory->getPartDetails()->total_quantity > 0 ? ($partCategory->getPartDetails()->total_sold / $partCategory->getPartDetails()->total_quantity) * 100 : 0 }}
                                                %
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $partCategory->getPartDetails()->total_sold_price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </article>
                </div>
            </div>
            <div class="col-xxl-5 col-xl-12">
                <div class="card mb-4">
                    <article class="card-body">
                        <h5 class="card-title">Recent Sales of last 10 days</h5>
                        <ul class="verti-timeline list-unstyled font-sm">
                            @php
                                $todayExists = $saleByDate->has(Carbon::today()->toDateString());
                            @endphp

                            @if (!$todayExists)
                                <li class="event-list active">
                                    <div class="event-timeline-dot">
                                        <i class="material-icons md-play_circle_outline font-xxl animation-fade-right"></i>
                                    </div>
                                    <div class="media">
                                        <div class="me-3">
                                            <h6 class="m-0 p-0">
                                                <span>Today</span>
                                                <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i>
                                            </h6>
                                        </div>
                                        <div class="media-body">
                                            <div>
                                                $ <span class="fw-bold fs-5">0</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif

                            @foreach($saleByDate as $day => $salesOnDay)
                                <li class="event-list @if(Carbon::parse($day)->isToday()) active @endif">
                                    <div class="event-timeline-dot">
                                        @if(Carbon::parse($day)->isToday())
                                            <i class="material-icons md-play_circle_outline font-xxl animation-fade-right"></i>
                                        @else
                                            <i class="material-icons md-play_circle_outline font-xxl"></i>
                                        @endif
                                    </div>
                                    <div class="media">
                                        <div class="me-3">
                                            <h6 class="m-0 p-0">
                                                <span>
                                                    @if(Carbon::parse($day)->isToday())
                                                        Today
                                                    @else
                                                        {{ Carbon::parse($day)->format('Y-m-d') }}
                                                    @endif
                                                </span>
                                                <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i>
                                            </h6>
                                        </div>
                                        <div class="media-body">
                                            <div>$ <span
                                                    class="fw-bold fs-5">{{ $salesOnDay->sum(function ($saleOnDay) { return $saleOnDay->price_at_sale; }) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </article>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5>Latest Shipments</h5>
                <div class="table-responsive">
                    <div class="table-responsive">
                        {{$dataTable->table()}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
