<?php

namespace Habib\Payout\Events;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HyperSplitWebhookEvent
{
    use Dispatchable, SerializesModels;

    public array $transaction;

    public function __construct(array $transaction = [])
    {
        $this->transaction = $transaction;
    }
}
