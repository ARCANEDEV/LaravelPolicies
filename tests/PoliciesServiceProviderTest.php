<?php

namespace Arcanedev\LaravelPolicies\Tests;

use Arcanedev\LaravelPolicies\PoliciesServiceProvider;

/**
 * Class     PoliciesServiceProviderTest
 *
 * @package  Arcanedev\LaravelPolicies\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PoliciesServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\LaravelPolicies\PoliciesServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = $this->app->get(PoliciesServiceProvider::class);
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\Providers\ServiceProvider::class,
            \Arcanedev\Support\Providers\PackageServiceProvider::class,
            \Arcanedev\LaravelPolicies\PoliciesServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            \Arcanedev\LaravelPolicies\Contracts\PolicyManager::class,
        ];

        static::assertEquals($expected, $this->provider->provides());
    }
}
