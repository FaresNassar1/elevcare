<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\CMS\Support\Route\Auth;
use Juzaweb\Backend\Http\Controllers\Auth\LoginController;

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::post(
            'logout',
            [LoginController::class, 'logout']
        )
        ->name('logout');
    }
);




Route::group(
    [
        'middleware' => ['guest','csp'],
        'as' => 'admin.',
        'prefix' => config('juzaweb.admin_prefix'),
        'namespace' => 'Juzaweb\CMS\Http\Controllers',
    ],
    function () {
        Auth::routes();
    }
);
