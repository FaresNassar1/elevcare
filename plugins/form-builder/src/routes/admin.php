<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

use Progmix\FormBuilder\Http\Controllers\FormBuilderController;
use Progmix\FormBuilder\Http\Controllers\FormSubmissionController;

// FormBuilderController
Route::jwResource('form-builder', 'Progmix\FormBuilder\Http\Controllers\FormBuilderController');
Route::get('form-builder/create/form', [FormBuilderController::class, 'create'])->name('create.form');
Route::post('save-form', [FormBuilderController::class, 'store'])->name('form.save');
Route::post('save-form/{form}', [FormBuilderController::class, 'update'])->name('form.show.saved');
Route::get('show-edit-form/{id}',  [FormBuilderController::class, 'edit'])->name('form.edit');
Route::get('view-form/{id}',  [FormBuilderController::class, 'preview'])->name('form.view');
Route::post('submit-form/{id}',  [FormBuilderController::class, 'submitForm'])->name('form.submit');
// FormSubmissionController
Route::jwResource('form-submissions', 'Progmix\FormBuilder\Http\Controllers\FormSubmissionController');
Route::get('show-view-form/{id}',  [FormSubmissionController::class, 'view'])->name('form.view.disabled');
