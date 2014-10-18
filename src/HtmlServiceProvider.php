<?php

namespace Estey\FormBuilder;

use Illuminate\Html\HtmlServiceProvider as BaseHtmlServiceProvider;

class HtmlServiceProvider extends BaseHtmlServiceProvider
{
    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app['form'] = $this->app->share(function ($app) {
            $form = new FormBuilder(
                $app['html'],
                $app['url'],
                $app['session.store']->getToken(),
                $app['translator']
            );

            return $form->setSessionStore($app['session.store']);
        });
    }
}
