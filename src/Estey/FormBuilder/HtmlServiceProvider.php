<?php namespace Estey\FormBuilder;

class HtmlServiceProvider extends \Illuminate\Html\HtmlServiceProvider {

	/**
	 * Register the form builder instance.
	 *
	 * @return void
	 */
	protected function registerFormBuilder()
	{
		$this->app['form'] = $this->app->share(function($app)
		{
			$form = new FormBuilder($app['html'], $app['url'], $app['session.store']->getToken(), $app['translator']);

			return $form->setSessionStore($app['session.store']);
		});
	}

}