@extends('admin.layouts.master')

@section('content')

    <section class="content-main">
        <div class="content-header">
            <h4 class="content-title">Checkout</h4>
        </div>

        <div class="row">
            <div class="col-xl-6 col-xxl-4">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle table-nowrap mb-0"
                                    style="white-space: none">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase" width="10%">S/N</th>
                                            <th class="text-uppercase" width="40%">Product</th>
                                            <th class="text-uppercase text-center">Quantity</th>
                                            <th class="text-uppercase" width="20%" class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$cartContents->isEmpty())
                                            @foreach ($cartContents as $cartContent)
                                                <tr>
                                                    <td class="text-center fw-bold">{{ ++$loop->index }}</td>
                                                    <td>
                                                        <a class="itemside" href="#">
                                                            <div class="left">
                                                                <img src="{{ asset('/assets/imgs/car-parts/placeholder.jpg') }}"
                                                                    width="40" height="40" class="img-xs"
                                                                    alt="Item">
                                                            </div>
                                                            <div class="info">{{ $cartContent->name }}</div>
                                                        </a>
                                                    </td>
                                                    <td class="text-center">{{ $cartContent->qty }}</td>
                                                    <td class="text-end fw-bolder">${{ $cartContent->price }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4">
                                                    <form action="{{ route('admin.cart.proceed-checkout') }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="d-flex justify-content-end">
                                                            <article class="float-end">
                                                                <dl class="dlist">
                                                                    <dt>Subtotal:</dt>
                                                                    <dd class="fw-bold">$ <span
                                                                            id="subTotalAmount">{{ $totalPrice }}</span>
                                                                    </dd>
                                                                </dl>
                                                                <dl class="dlist">
                                                                    <dt>Discount:</dt>
                                                                    <dd>$ <input class="text-end text-danger fw-bold"
                                                                            type="number" id="discountAmountInput"
                                                                            name="checkout_discount" value="0"
                                                                            min="0"></dd>
                                                                </dl>
                                                                <dl class="dlist">
                                                                    <dt class="text-start text-black fw-bold"
                                                                        style="font-size: 12px">Grand total:</dt>
                                                                    <dd class="fw-bold text-primary-dark fw-bold"
                                                                        style="font-size: 14px">
                                                                        $ <span
                                                                            id="grandTotalAmount">{{ $totalPrice }}</span>
                                                                    </dd>
                                                                </dl>
                                                                <dl class="dlist">
                                                                    <dt>Date:</dt>
                                                                    <dd><input class="text-end fw-bold" type="date"
                                                                            name="checkout_date"
                                                                            value="{{ date('Y-m-d') }}"></dd>
                                                                </dl>
                                                            </article>
                                                        </div>
                                                        <hr>
                                                        <label for="comment">Comment</label>
                                                        <textarea name="comment" id="comment" rows="4" style="width: 100%"></textarea>
                                                        <div class="d-flex justify-content-end mt-2">
                                                            <button class="btn btn-xs text-center text-uppercase">Confirm
                                                                Checkout</button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="text-center text-danger" colspan="7">no cost type found!!!
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')
    <!-- Custom Scripts -->
    <script defer src="{{ asset('assets/js/checkout-cart.js') }}"></script>
@endpush
