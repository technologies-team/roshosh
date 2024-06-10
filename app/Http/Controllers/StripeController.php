<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Customer;

class StripeController extends Controller
{
    public function checkout(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('checkout');
    }

    /**
     * @throws ApiErrorException
     */
    public function payment(Request $request): string
    {
        Stripe::setApiKey(config('stripe.secret'));

        $customer = Customer::create([
            'email' => $request->stripeEmail,
            'source'  => $request->stripeToken,
        ]);

        $charge = Charge::create([
            'customer' => $customer->id,
            'amount' => 5000, // Amount in cents
            'currency' => 'AED',
        ]);

        return 'Payment successful!';
    }
}
