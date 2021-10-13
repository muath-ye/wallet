<?php

namespace Muathye\Wallet\Tests\Unit;

use Muathye\Wallet\Models\Wallet;
use Muathye\Wallet\Exceptions\UnacceptedTransactionException;
use Muathye\Wallet\Tests\TestCase;
use Muathye\Wallet\Models\Transaction;
use Illuminate\Support\Collection;
use Muathye\Wallet\Tests\Factories\TransactionFactory;
use Muathye\Wallet\Tests\Factories\UserFactory;
use Muathye\Wallet\Tests\Factories\WalletFactory;

class HasWalletTest extends TestCase
{
    /** @test */
    public function wallet()
    {
        $user = UserFactory::new()->create();
        $this->assertInstanceOf(Wallet::class, $user->wallet);
        $this->assertFalse($user->wallet->exists());
        $this->assertTrue(0.0 === $user->wallet->balance);
    }

    /** @test */
    public function wallet_transactions()
    {
        $user1 = UserFactory::new()->create();
        $wallet1 = WalletFactory::new()->create(['owner_id' => $user1->id]);
        $transactions1 = TransactionFactory::new()->count(10)->create(['wallet_id' => $wallet1->id]);
        $this->assertInstanceOf(Collection::class, $user1->walletTransactions);
        $this->assertEquals(10, $user1->walletTransactions()->count());
        $this->assertEmpty($wallet1->transactions->diff($user1->walletTransactions));
        $user2 = UserFactory::new()->create();
        $wallet2 = WalletFactory::new()->create(['owner_id' => $user2->id]);
        $transactions2 = TransactionFactory::new()->count(5)->create(['wallet_id' => $wallet2->id]);
        $this->assertInstanceOf(Collection::class, $user1->walletTransactions);
        $this->assertEquals(10, $user1->walletTransactions()->count());
        $this->assertEmpty($wallet2->transactions->diff($user2->walletTransactions));
        $this->assertInstanceOf(Collection::class, $user2->walletTransactions);
        $this->assertEquals(5, $user2->walletTransactions()->count());
        $this->assertEmpty($wallet2->transactions->diff($user2->walletTransactions));
    }

}
