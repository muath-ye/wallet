<?php

namespace Muathye\Wallet\Tests\Unit;

use Muathye\Wallet\Models\Wallet;
use Muathye\Wallet\Exceptions\UnacceptedTransactionException;
use Muathye\Wallet\Tests\TestCase;
use Muathye\Wallet\Tests\Models\User;
use Muathye\Wallet\Models\Transaction;
use Illuminate\Support\Collection;
use Muathye\Wallet\Jobs\RecalculateWalletBalance;
use Muathye\Wallet\DebouncedJob;
use Muathye\Wallet\Tests\Factories\WalletFactory;

class RecalculateWalletBalanceTest extends TestCase
{
    /** @test */
    public function dispatch()
    {
        config(['auto_recalculate_balance' => true]);
        $wallet = WalletFactory::new()->create();
        Transaction::flushEventListeners();
        $transaction = $wallet->transactions()->make(['type' => 'deposit', 'amount' => 10]);
        $transaction->hash = uniqid();
        $transaction->save();
        $this->assertNotEquals(10, $wallet->balance);
        RecalculateWalletBalance::dispatch($wallet);
        $this->assertEquals(10, $wallet->refresh()->balance);
    }

}

