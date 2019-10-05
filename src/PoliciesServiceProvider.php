<?php

declare(strict_types=1);

namespace Arcanedev\LaravelPolicies;

use Arcanedev\Support\PackageServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class     PoliciesServiceProvider
 *
 * @package  Arcanedev\LaravelPolicies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PoliciesServiceProvider extends PackageServiceProvider implements DeferrableProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The package name.
     *
     * @var string
     */
    protected $package = 'policies';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        $this->singleton(Contracts\PolicyManager::class, PolicyManager::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            Contracts\PolicyManager::class,
        ];
    }
}
