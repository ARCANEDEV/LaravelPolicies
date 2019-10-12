<?php

namespace Arcanedev\LaravelPolicies\Tests;

use Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\PostsPolicy;
use Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\PrefixedPolicy;

/**
 * Class     PolicyTest
 *
 * @package  Arcanedev\LaravelPolicies\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PolicyTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $policy = new PostsPolicy;

        $expectations = [
            \Arcanedev\LaravelPolicies\Contracts\Policy::class,
            \Arcanedev\LaravelPolicies\Policy::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $policy);
        }
    }

    /** @test */
    public function it_can_get_abilities()
    {
        $abilities = (new PostsPolicy)->abilities();

        static::assertCount(4, $abilities);

        $expected = [
            'key'    => 'list-posts',
            'method' => 'Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\PostsPolicy@listPosts',
            'metas'  => [
                'category'    => 'Blog',
                'name'        => 'List all the posts',
                'description' => 'Ability to list all the posts',
            ]
        ];

        static::assertEquals($expected, $abilities[0]->toArray());
    }

    /** @test */
    public function it_can_get_single_ability_key()
    {
        $expectations = [
            'list-posts'    => PostsPolicy::ability('list-posts'),
            'policy::index' => PrefixedPolicy::ability('index'),
        ];

        foreach ($expectations as $expected => $actual) {
            static::assertSame($expected, $actual);
        }
    }

    /** @test */
    public function it_can_get_multiple_ability_keys()
    {
        static::assertEquals(
            ['list-posts', 'create-posts'],
            PostsPolicy::ability(['list-posts', 'create-posts'])
        );

        static::assertEquals(
            ['policy::current-class', 'policy::closure', 'policy::dedicated-class'],
            PrefixedPolicy::ability(['current-class', 'closure', 'dedicated-class'])
        );
    }
}
