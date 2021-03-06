<?php

namespace Joselfonseca\LaravelApiTools;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Joselfonseca\LaravelApiTools\Responders\JsonResponder;
use Joselfonseca\LaravelApiTools\Exceptions\ModelNotFoundExceptionUseSimpleResponder;
use Joselfonseca\LaravelApiTools\Exceptions\ValidationExceptionUseSimpleResponder;

class LaravelApiToolsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('joselfonseca/laravel-api-tools');
        /** Lets create an alias * */
        AliasLoader::getInstance()->alias('ApiToolsResponder', 'Joselfonseca\LaravelApiTools\ApiToolsResponder');
        /** Bind the default clases * */
        $this->app->bind('JsonResponder', function() {
            return new JsonResponder;
        });
        /** Validation Errors to be hande with simple responder * */
        \App::error(function(ValidationExceptionUseSimpleResponder $e) {
            return \ApiToolsResponder::validationError($e->validator);
        });
        \App::error(function(ModelNotFoundExceptionUseSimpleResponder $e) {
            return \ApiToolsResponder::resourceNotFound(\Config::get('laravel-api-tools::ResourceNotFound'));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
