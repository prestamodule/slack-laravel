<?php

namespace Razorpay\Slack\Laravel;

use RuntimeException;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The actual provider.
     *
     * @var \Illuminate\Support\ServiceProvider
     */
    protected $provider;

    /**
     * Instantiate the service provider.
     *
     * @param mixed $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->provider = $this->getProvider();
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        return $this->provider->boot();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        return $this->provider->register();
    }

    /**
     * Return the service provider for the particular Laravel version.
     *
     * @return mixed
     */
    private function getProvider()
    {
        if (version_compare($this->app::VERSION, '5.8', '>=')) {
            return new ServiceProviderLaravel6($this->app);
        } elseif (version_compare($this->app::VERSION, '5.0', '>=')) {
            return new ServiceProviderLaravel5($this->app);
        } elseif (version_compare($this->app::VERSION, '4.0', '>=')) {
            return new ServiceProviderLaravel4($this->app);
        } else {
            throw new RuntimeException('Your version of Laravel is not supported');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['slack'];
    }
}
