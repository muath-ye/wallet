<?php

namespace Muathye\Wallet\Tests\Factories;

use Muathye\Wallet\Models\Wallet;
use Muathye\Wallet\Tests\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{

    protected $model = Wallet::class;

    public function definition()
    {
        return [
            'owner_id' => UserFactory::new(),
            'owner_type' => User::class
        ];
    }
}
