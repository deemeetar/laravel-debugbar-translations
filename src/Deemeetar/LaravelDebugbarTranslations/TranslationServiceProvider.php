<?php namespace Deemeetar\LaravelDebugbarTranslations;

use DebugBar\DebugBarException;
use Deemeetar\LaravelDebugbarTranslations\DataCollector\TranslationCollector;
use Deemeetar\LaravelDebugbarTranslations\Translation\Translator;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationServiceProvider;

class TranslationServiceProvider extends BaseTranslationServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{


		$this->registerLoader();

		$this->app->bindShared('translator', function($app)
		{
			$loader = $app['translation.loader'];

			// When registering the translator component, we'll need to set the default
			// locale as well as the fallback locale. So, we'll grab the application
			// configuration so we can easily get both of these values from there.
			$locale = $app['config']['app.locale'];

			$trans = new Translator($loader, $locale, $app['debugbar']);

			$trans->setFallback($app['config']['app.fallback_locale']);

			return $trans;
		});

	}

	public function boot()
	{
		try {
			$this->app['debugbar']->addCollector(new TranslationCollector());
		} catch (DebugBarException $e) {

		}

	}


}

