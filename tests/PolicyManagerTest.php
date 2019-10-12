<?php

namespace Arcanedev\LaravelPolicies\Tests;

use Illuminate\Support\Facades\Gate;

/**
 * Class     PolicyManagerTest
 *
 * @package  Arcanedev\LaravelPolicies\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PolicyManagerTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\LaravelPolicies\Contracts\PolicyManager */
    private $manager;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = $this->app->make(\Arcanedev\LaravelPolicies\Contracts\PolicyManager::class);
    }

    protected function tearDown(): void
    {
        unset($this->manager);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Arcanedev\LaravelPolicies\Contracts\PolicyManager::class,
            \Arcanedev\LaravelPolicies\PolicyManager::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->manager);
        }

        static::assertInstanceOf(\Illuminate\Support\Collection::class, $this->manager->policies());
        static::assertTrue($this->manager->policies()->isEmpty());

        static::assertInstanceOf(\Illuminate\Support\Collection::class, $this->manager->abilities());
        static::assertTrue($this->manager->abilities()->isEmpty());
    }

    /** @test */
    public function it_can_parse_policy_class()
    {
        $classes = [
            Fixtures\Policies\PrefixedPolicy::class,
            Fixtures\Policies\PostsPolicy::class,
        ];

        foreach ($classes as $class) {
            static::assertInstanceOf($class, $this->manager->parsePolicy($class));
            static::assertInstanceOf(
                \Arcanedev\LaravelPolicies\Contracts\Policy::class,
                $this->manager->parsePolicy($class)
            );
        }
    }

    /** @test */
    public function it_can_parse_multiple_policy_classes()
    {
        $policies = $this->manager->parsePolicies([
            Fixtures\Policies\PrefixedPolicy::class,
            Fixtures\Policies\PostsPolicy::class,
        ]);

        static::assertInstanceOf(\Illuminate\Support\Collection::class, $policies);
        static::assertCount(2, $policies);

        foreach ($policies as $policy) {
            static::assertInstanceOf(\Arcanedev\LaravelPolicies\Contracts\Policy::class, $policy);
        }
    }

    /** @test */
    public function it_can_register_policy_class()
    {
        static::assertCount(0, Gate::abilities());

        $this->manager->registerClass(Fixtures\Policies\PostsPolicy::class);

        static::assertCount(1, $this->manager->policies());
        static::assertCount(4, $abilities = $this->manager->abilities());
        static::assertCount(4, Gate::abilities());

        foreach ($abilities as $ability) {
            static::assertTrue(Gate::has($ability->key()));
        }
    }

    /** @test */
    public function it_can_register_multiple_policy_classes()
    {
        static::assertCount(0, Gate::abilities());

        $this->manager->registerClass(Fixtures\Policies\PostsPolicy::class);
        $this->manager->registerClass(Fixtures\Policies\PrefixedPolicy::class);

        static::assertCount(2, $this->manager->policies());
        static::assertCount(8, $abilities = $this->manager->abilities());
        static::assertCount(8, Gate::abilities());

        foreach ($abilities as $ability) {
            static::assertTrue(Gate::has($ability->key()));
        }
    }

    /** @test */
    public function it_can_register_policy_instance()
    {
        static::assertCount(0, Gate::abilities());

        $this->manager->register(new Fixtures\Policies\PostsPolicy);

        $abilities = $this->manager->abilities();

        static::assertSame(
            $abilities->count(),
            count(Gate::abilities())
        );

        foreach ($abilities as $ability) {
            static::assertTrue(Gate::has($ability->key()));
        }
    }

    /** @test */
    public function it_can_check_authorizations()
    {
        $this->manager->registerClass(Fixtures\Policies\PostsPolicy::class);
        $this->manager->registerClass(Fixtures\Policies\PrefixedPolicy::class);

        foreach ($this->manager->abilities() as $ability) {
            $key = $ability->key();

            static::assertTrue(Gate::allows($key), 'Failed to allows ability on: '.$key);
            static::assertFalse(Gate::denies($key), 'Failed to allows ability on: '.$key);

            static::assertTrue(Gate::denies($key, [false]), 'Failed to denies on ability: '.$key);
            static::assertFalse(Gate::allows($key, [false]), 'Failed to denies on ability: '.$key);
        }
    }

    /** @test */
    public function it_can_inspect_authorization()
    {
        $this->manager->registerClass(Fixtures\Policies\PrefixedPolicy::class);

        $ability = Fixtures\Policies\PrefixedPolicy::ability('dedicated-class');

        $response = Gate::inspect($ability);

        static::assertTrue($response->allowed());
        static::assertSame('Mi Casa Es Tu Casa', $response->message());

        $response = Gate::inspect($ability, [false]);

        static::assertTrue($response->denied());
        static::assertSame('You Shall Not Pass!!!', $response->message());
    }
}
