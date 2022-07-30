<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\WebhookClient\Models\WebhookCall;

class SetUpIntentSucceded implements ShouldQueue
{
    public function handle(WebhookCall $webhookCall)
    {
        $data = $webhookCall->payload['data']['object'];
        $user = User::where('stripe_id', $data['customer'])->first();
        $user->updateDefaultPaymentMethod($data['payment_method']);
        $user->setup_secret = $data['client_secret'];
        $user->setupintent_id = $data['id'];
        $user->save();
    }
}
