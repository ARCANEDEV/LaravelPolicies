<?php

namespace Arcanedev\LaravelPolicies\Tests;

use Arcanedev\LaravelPolicies\Ability;
use Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\PostsPolicy;
use Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\PrefixedPolicy;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;

/**
 * Class     AuthorizationTest
 *
 * @package  Arcanedev\LaravelPolicies\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorizationTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_define()
    {
        static::assertEmpty(Gate::abilities());

        $abilities = [
            Ability::make('post-contact-form', function (?User $user) {
                // Authentication not required
                return true;
            }),
            Ability::make('post-comment', function (User $user) {
                // Authentication not required
                return true;
            }),
        ];

        foreach ($abilities as $ability) {
            // Assert before registering ability
            static::assertFalse(Gate::has($ability->key()));

            Gate::define($ability->key(), $ability->method());

            // Assert after registering ability
            static::assertTrue(Gate::has($ability->key()));
        }

        static::assertCount(count($abilities), Gate::abilities());

        static::assertTrue(Gate::allows('post-contact-form'));
        static::assertFalse(Gate::allows('post-comment'));
    }

    /** @test */
    public function it_can_define_with_prefixed_policy_class()
    {
        $abilities = (new PrefixedPolicy)->abilities();

        foreach ($abilities as $ability) {
            // Assert before registering ability
            static::assertFalse(Gate::allows($ability->key()));

            Gate::define($ability->key(), $ability->method());

            // Assert after registering ability
            static::assertTrue(Gate::allows($ability->key()));
        }

        static::assertCount(count($abilities), Gate::abilities());
    }
}
