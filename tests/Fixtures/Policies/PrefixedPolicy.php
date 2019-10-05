<?php

namespace Arcanedev\LaravelPolicies\Tests\Fixtures\Policies;

use Arcanedev\LaravelPolicies\Policy;
use Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\Abilities\AbilityClass;
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

            $this->makeAbility('closure')->callback(function(?User $user) {
                return true;
            }),

            $this->makeAbility('dedicated-class')
                 ->setMethod(AbilityClass::class),
        ];
    }

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    public function currentClass(?User $user)
    {
        return true;
    }

    public function custom(?User $user)
    {
        return true;
    }
}
