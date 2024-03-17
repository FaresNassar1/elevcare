<?php

namespace Juzaweb\Contacts\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Contacts\Actions\ContactsAction;

class ContactsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register([ContactsAction::class]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
