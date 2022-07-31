<?php

namespace App\Listeners;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Cashier;
use Spatie\WebhookClient\Models\WebhookCall;

class ChargeSucceeded
{
    public function handle(WebhookCall $webhookCall)
    {
        $charge = $webhookCall->payload['data']['object'];
        $intentId = $charge['payment_intent'];
        $intent = Cashier::stripe()->paymentIntents->retrieve($intentId);
        $user = User::where('stripe_id', $charge['customer'])->first();
        if ($user) {
            Order::create([
                'user_id' => $user->id,
                'product_id' => $intent->metadata->product_id,
                'location_id' => $intent->metadata->location_id,
                'car_id' => $intent->metadata->car_id,
                'date' => $intent->metadata->date,
            ]);
        }
    }
}
