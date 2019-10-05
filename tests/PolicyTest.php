<?php

namespace Arcanedev\LaravelPolicies\Tests;

use Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\PostsPolicy;

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
            'key'    => 'admin::blog.posts.index',
            'method' => 'Arcanedev\LaravelPolicies\Tests\Fixtures\Policies\PostsPolicy@index',
            'metas'  => [
                'name'        => 'List all the posts',
                'description' => 'Ability to list all the posts',
            ]
        ];

        static::assertEquals($expected, $abilities[0]->toArray());
    }
}
