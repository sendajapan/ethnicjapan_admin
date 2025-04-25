<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Exception;

class PaymentController extends Controller
{

    public function index(): View
    {
        return view('admin.stripe.index');
    }

    public function handlePayment(Request $request): JsonResponse
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment description',
            ]);

            return response()->json(['status' => 'Payment successful!', 'charge' => $charge]);
        } catch (Exception $e) {
            return response()->json(['status' => 'Payment failed!', 'error' => $e->getMessage()]);
        }
    }
}
