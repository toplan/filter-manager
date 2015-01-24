<?php namespace Toplan\FilterManager;

use Illuminate\Support\ServiceProvider;

class FilterManagerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['FilterManager'] = $this->app->share(function(){
                return FilterManager::create(\Input::all())->setBlackList(['page']);
            });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('FilterManager');
	}

}
