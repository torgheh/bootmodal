<?php namespace Torgheh\Bootmodal;

use Illuminate\Support\ServiceProvider;

class BootmodalServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('torgheh/bootmodal');
	}
	
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['torgheh.bootmodal'] = $this->app->share(function($app){
			
			
			return new \Torgheh\Bootmodal\Modal;
			
		});
	}

	
}
