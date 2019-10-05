<?php

namespace Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\Abilities;

use Illuminate\Foundation\Auth\User;

/**
 * Class     AbilityClass
 *
 * @package  Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\Abilities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AbilityClass
{
    public function __invoke(?User $user)
    {
        return true;
    }
}
