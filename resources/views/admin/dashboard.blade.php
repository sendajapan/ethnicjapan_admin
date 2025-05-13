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
        </div>
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <div class="row">
                    <div class="col-lg-6 col-xl-6">
                        <div class="card card-body mb-4 animate__animated animate__fadeInUp animate__fast">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-primary-light d-flex">
                                    <i class="text-primary-dark material-icons md-monetization_on"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">This Year Sale</h6>
                                    <span>$ {{ number_format(0) }}</span>
                                    <span class="text-sm">Sale from the year to date.</span>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-6">
                        <div class="card card-body mb-4 animate__animated animate__fadeInUp animate__fast">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-warning-subtle d-flex">
                                    <i class="text-warning-emphasis material-icons md-monetization_on"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">This Year Profit</h6>
                                    <span>$ {{ number_format(0) }}</span>
                                    <span class="text-sm">Profit from year to date</span>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-xl-6">
                        <div class="card card-body mb-4 animate__animated animate__fadeInUp animate__fast">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-danger-subtle d-flex">
                                    <i class="text-danger-dark material-icons md-monetization_on"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">This Month Sale</h6>
                                    <span>$ {{ number_format(0) }}</span>
                                    <span class="text-sm">Sale from the month to date.</span>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-6">
                        <div class="card card-body mb-4 animate__animated animate__fadeInUp animate__fast">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-info-subtle d-flex">
                                    <i class="text-info-emphasis material-icons md-monetization_on"></i>
                                </span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">This Month Profit</h6>
                                    <span>$ {{ number_format(0) }}</span>
                                    <span class="text-sm">Profit from month to date</span>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>



            </div>
            <div class="col-lg-4 col-xl-4 offset-1 ">
                <h1>Loan</h1>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Reference</th>
                        <th scope="col" class="text-end">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td>Ethnic Payable, Coke Expense</td>
                            <td class="text-end">$ 3,600</td>
                        </tr>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th>Total</th>
                        <th class="text-end">$ 3,600</th>
                    </tr>
                    </tfoot>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
