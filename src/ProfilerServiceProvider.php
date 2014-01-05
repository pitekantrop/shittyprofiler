<?php namespace Pitekantrop\ShittyProfiler;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class ProfilerServiceProvider extends ServiceProvider {

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
		AliasLoader::getInstance()->alias('Profiler', 'Pitekantrop\ShittyProfiler\Profiler');

		if ($this->profilerEnabled()) 
		{
			$app =& $this->app;
			$this->app->after(function($req, $res) use ($app)
			{
				$prof = new Profiler(microtime(true), $app);
				$prof->displayProfiler($res);
			});

			$this->package('pitekantrop/shittyprofiler', null, __DIR__);
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	/**
	 * Check if we should profile this request
	 * 
	 * @return boolean
	 */
	public function profilerEnabled()
	{
		return array_key_exists('profile', $_GET) && $this->app['config']->get('app.debug');
	}

}
