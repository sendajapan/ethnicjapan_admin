@extends('admin.layouts.master')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <h3 class="content-title">Stripe Payment</h2>
        </div>

        <div class="card col-4 mb-4">
            <header class="card-header">
                <h6 class="card-title">Payment Form</h6>
            </header>
            <div class="card-body">
                <div class="card-body">
                    <form action="{{ route('admin.handle.payment') }}" method="POST" id="payment-form">
                        @csrf

                        <div class="form-group">
                            <label for="card-amount" class="form-label">
                                Credit or Debit Card
                            </label>
                            <input id="card-amount" class="form-control" type="text" name="amount" value="100">
                        </div>

                        <div class="form-group mb-3">
                            <label for="card-element" class="form-label">
                                Credit or Debit Card
                            </label>
                            <div id="card-element" class="form-control">
                            </div>
                            <small id="card-errors" class="text-danger mt-2" role="alert"></small>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary">Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('services.stripe.public') }}');
        const elements = stripe.elements();

        const style = {
            base: {
                color: '#32325d',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const card = elements.create('card', {style: style});
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', result.token.id);
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            });
        });
    </script>
@endpush
