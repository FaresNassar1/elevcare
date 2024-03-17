<?php

namespace Juzaweb\Frontend\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Make sure current locale exists.
        $lang = $request->segment(1);
        //if not, redirect to /en
        if (!array_key_exists($lang, config('app.locales'))) {
            return redirect(config('app.fallback_locale'));
        }
        app()->setLocale($lang);
        URL::defaults(['locale' => app()->getLocale()]);
        return $next($request);
    }
}
