@php
    use App\Models\Part;
    use App\Models\PartCategory;
    use App\Models\Sale;
    use App\Models\Shipment;
    use App\Models\Vehicle;
    use Carbon\Carbon;
@endphp
@extends('admin.layouts.master')



@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h3 class="content-title card-title">Dashboard</h3>
            </div>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
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
                            <span>$ {{ number_format(0) }}</span>
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
                            <span>$ {{ number_format(0) }}</span>
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
                            <span>{{ 0 }}</span>
                            <span class="text-sm"> In {{ 0 }} shipmemt(s)</span>
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
                            <span>{{ 0 }}</span>
                            <span class="text-sm"> In {{ 0 }} vehicle(s)</span>
                        </div>
                    </article>
                </div>
            </div>
        </div>


    </section>
@endsection
