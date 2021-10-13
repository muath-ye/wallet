<?php

namespace Muathye\Wallet\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as AuthUser;
use Muathye\Wallet\Traits\HasWallet;

class User extends AuthUser
{
    use HasWallet;
    use HasFactory;
}