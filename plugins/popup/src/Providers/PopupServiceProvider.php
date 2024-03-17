<?php

namespace Juzaweb\Popup\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Popup\PopupAction;

class PopupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(PopupAction::class);
    }
}
