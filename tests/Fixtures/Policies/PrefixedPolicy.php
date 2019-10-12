<?php

namespace Arcanedev\LaravelPolicies\Tests\Fixtures\Policies;

use Arcanedev\LaravelPolicies\Policy;
use Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\Abilities\DedicatedAbility;
use Illuminate\Foundation\Auth\User;

/**
 * Class     PrefixedPolicy
 *
 * @package  Arcanedev\LaravelPolicies\Tests\Fixtures\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PrefixedPolicy extends Policy
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Get the ability's prefix.
     *
     * @return string
     */
    protected static function prefix(): string
    {
        return 'policy::';
    }

    /* -----------------------------------------------------------------
     |  Mains Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the policy's abilities.
     *
     * @return \Arcanedev\LaravelPolicies\Ability[]|iterable
     */
    public function abilities(): iterable
    {
        return [

            $this->makeAbility('current-class'),

            $this->makeAbility('current-class-with-custom-method', 'custom'),

            $this->makeAbility('closure')->callback(function(?User $user, bool $condition = true) {
                return $condition;
            }),

            $this->makeAbility('dedicated-class')
                 ->setMethod(DedicatedAbility::class),

        ];
    }

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    public function currentClass(?User $user, bool $condition = true)
    {
        return $condition;
    }

    public function custom(?User $user, bool $condition = true)
    {
        return $condition;
    }
}
