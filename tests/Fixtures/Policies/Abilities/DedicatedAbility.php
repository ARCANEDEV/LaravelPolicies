<?php

namespace Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\Abilities;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\User;

/**
 * Class     AbilityClass
 *
 * @package  Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\Abilities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DedicatedAbility
{
    public function __invoke(?User $user, bool $condition = true)
    {
        return $condition
            ? Response::allow('Mi Casa Es Tu Casa')
            : Response::deny('You Shall Not Pass!!!');
    }
}
