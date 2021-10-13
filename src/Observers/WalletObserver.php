<?php

namespace Muathye\Wallet\Observers;

use Muathye\Wallet\Models\Wallet;
use Muathye\Wallet\Models\Transaction;
use Muathye\Wallet\Jobs\RecalculateWalletBalance;

class WalletObserver
{
    public function saved(Wallet $wallet)
    {
        if (
            $wallet->isDirty('balance')
            && \Wallet::autoRecalculationActive()
        ) {
            RecalculateWalletBalance::dispatch($wallet);
        }
    }
}
