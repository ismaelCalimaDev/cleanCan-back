<?php

namespace App\Http\Controllers;

use App\Models\FailedOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\EphemeralKey;
use Stripe\Stripe;
use Stripe\StripeClient;

class StoreController extends Controller
{
    public function getStripeKeys() {
        $stripe = new StripeClient((config('cleancan.stripe_key')));
        $setUpIntent = $stripe->setupIntents->create(
            [
                'customer' => auth()->user()->stripe_id,
                'payment_method_types' => ['card'],
            ]
        );
        $customer_id = auth()->user()->stripe_id;
        Stripe::setApiKey(config('cleancan.stripe_key'));
        $key = EphemeralKey::create(
            ['customer' => $customer_id],
            ['stripe_version' => '2020-08-27']
        );
        $ephemeral_key = ['id' => $key->id, 'secret' => $key->secret];

        return response()->json([
            'success' => true,
            'setup_secret' => $setUpIntent->client_secret,
            'customer_id' => $customer_id,
            'ephemeral_key' => $ephemeral_key,
        ]);
    }

    public function hasPaymentMethod()
    {
        $has_payment_method = false;
        if (auth()->user()->setup_secret) {
            $has_payment_method = true;
        }

        return response()->json([
            'success' => true,
            'has_payment_method' => $has_payment_method,
        ]);
    }

    public function confirmPayment(Request $request)
    {
        $stripe = new StripeClient((config('cleancan.stripe_key')));
        $product = Product::where('id', $request->product_id)->first();
        $setup_intent = $stripe->setupIntents->retrieve(auth()->user()->setupintent_id);
        $payment_method_id = $setup_intent->payment_method;
        auth()->user()->charge(
            $product->price, $payment_method_id, [
                'metadata' => [
                    'product_id' => $request->product_id, 'location_id' => $request->location_id,
                    'user_id' => auth()->user()->id, 'date' => $request->date, 'car_id' => $request->car_id,
                ],
            ]
        );
    }

    public function checkIfOperationSucceeded() {
        if (FailedOrder::where('user_id', auth()->user()->id)->first()) {
            FailedOrder::where('user_id', auth()->user()->id)->delete();

            return response()->json([
                'success' => true,
                'charge_succeeded' => false,
            ]);
        } else {
            return response()->json([
                'success' => true,
                'charge_succeeded' => true,
            ]);
        }
    }
}
