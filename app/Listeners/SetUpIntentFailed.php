<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetUpIntentFailed
{
    public function handle(WebhookCall $webhookCall)
    {
        $charge = $webhookCall->payload['data']['object'];
        $user = User::where('stripe_id', $charge['customer'])->first();
        if ($user) {
            FailedOrder::create([
                'user_id' => $user->id,
            ]);
        }
    }
}
