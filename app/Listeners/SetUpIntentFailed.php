<?php

namespace App\Listeners;

use App\Models\FailedOrder;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\WebhookClient\Models\WebhookCall;

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
