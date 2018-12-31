<?php

namespace Roocketir\BankGateway;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class BankGatewayServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        $config = __DIR__ . '/../config/bankgateway.php';
        $migrations = __DIR__ . '/../migrations/';
        $views = __DIR__ . '/../views/';

        //php artisan vendor:publish --provider=Roocketir\BankGateway\GatewayServiceProvider --tag=config
        $this->publishes([
            $config => config_path('bankgateway.php'),
        ], 'config');

        // php artisan vendor:publish --provider=Roocketir\BankGateway\GatewayServiceProvider --tag=migrations
        $this->publishes([
            $migrations => base_path('database/migrations')
        ], 'migrations');



        if (
            File::glob(base_path('/database/migrations/*create_gateway_status_log_table\.php'))
            && !File::exists(base_path('/database/migrations/2017_04_05_103357_alter_id_in_transactions_table.php'))
        ) {
            @File::copy($migrations.'/2017_04_05_103357_alter_id_in_transactions_table.php',base_path('database/migrations/2017_04_05_103357_alter_id_in_transactions_table.php'));
        }


        $this->loadViewsFrom($views, 'bankgateway');

        // php artisan vendor:publish --provider=Roocketir\BankGateway\GatewayServiceProvider --tag=views
        $this->publishes([
            $views => base_path('resources/views/vendor/bankgateway'),
        ], 'views');

        //$this->mergeConfigFrom( $config,'bankgateway')
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('bankgateway', function () {
			return new BankGatewayResolver();
		});

	}
}
