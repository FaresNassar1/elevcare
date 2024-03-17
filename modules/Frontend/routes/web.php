<?php

use Juzaweb\CMS\Support\Route\Auth;
use Juzaweb\Frontend\Http\Controllers\FormController;
use Juzaweb\Frontend\Http\Controllers\HomeController;
use Juzaweb\Frontend\Http\Controllers\PostController;
use Juzaweb\Frontend\Http\Controllers\SitemapController;
use Progmix\FormBuilder\Http\Controllers\FormBuilderController;
use Progmix\FormBuilder\Http\Controllers\FormSubmissionController;

Auth::routes();

//SITEMAP
Route::get('{lang}/sitemap.xml', [SitemapController::class, 'index'])
    ->where('lang', '[a-zA-Z]{2}')
    ->name('sitemap.index');

Route::group([
    'prefix'     => '{locale?}',
    'where'      => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => ['frontend'],
], function () {
    Route::get('/', [HomeController::class, 'home'])->name('home');
    // Contact Form
    Route::resource('contact-us', FormController::class)->only(['index', 'store']);
    Route::get('/lp/{slug?}', [PostController::class, 'post'])->name('landing.page')->where('slug', '.+');
    Route::get('{slug?}', [PostController::class, 'post'])->name('post')->where('slug', '.+');
    Route::post('save-form-submission', [FormSubmissionController::class, 'saveFormJson'])->name('form.submission.save');
});

Route::get('get-form/{form}', [FormBuilderController::class, 'getFormJson'])->name('get.form');
Route::get('get-form-submissions', [FormBuilderController::class, 'saveFormJson'])->name('get.form.save');
