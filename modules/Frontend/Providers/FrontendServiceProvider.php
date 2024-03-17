<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Frontend\Providers;

use Juzaweb\CMS\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $current_locale = app()->getLocale();

        // Share pages data with 'frontend::layouts.app' view
        view()->composer('frontend::layouts.app', function ($view) use ($current_locale) {
            // Retrieve menu along with its items
            $nav = jw_nav_menu([
                'container_before' => '',
                'container_after' => '',
                'theme_location' => 'primary',
                'item_view' => 'frontend::partials.menu_item',
            ]);

            $fbAppId = get_config('fb_app_id');
            $googleAnalytics = get_config('google_analytics');
            $bingKey = get_config('bing_verify_key');
            $googleKey = get_config('google_verify_key');
            $view->with(compact('fbAppId', 'googleAnalytics', 'bingKey', 'googleKey', 'nav','current_locale'));
        });

        // Share current locale and locales data with 'frontend::partials.language_switcher' view
        view()->composer('frontend::partials.language_switcher', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('locales', config('app.locales'));
        });
    }

    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'frontend');
    }
}
