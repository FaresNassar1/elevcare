<?php

namespace Progmix\FormBuilder\Actions;


use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

class FormBuilderAction extends Action
{
    /**
     * Execute the actions.
     *
     * @return void
     */
    public function handle()
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'registerResource']);
        $this->addAction(Action::BACKEND_INIT, [$this, 'addAdminMenu']);

    }

    public function registerResource()
    {
        HookAction::addAdminMenu(
            trans('cms::app.form_builder'),
            'form-builder',
            [
                'icon'        => 'fa fa-columns',
                'position'    => 30,
                'permissions' => [
                    'form.index',
                ],

            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.translations_form'),
            'translations/progmix_form_builder',
            [
                'icon'        => 'fa fa-arrow-right',
                'position'    => 2,
                'parent'      => 'form-builder',
                'permissions' => [
                    'form.index',
                ],

            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.forms_builder'),
            'form-builder',
            [
                'icon'        => 'fa fa-arrow-right',
                'position'    => 1,
                'parent'      => 'form-builder',
                'permissions' => [
                    'form.index',
                ],
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.forms_Submissions'),
            'form-submissions',
            [

                'icon'        => 'fa fa-arrow-right',
                'position'    => 2,
                'parent'      => 'form-builder',
                'permissions' => [
                    'form.index',
                ],
            ]
        );
    }


    public function addAdminMenu()
    {
        $this->hookAction->registerPermissionGroup(
            'form',
            [
                'name' => "form",
                'description' => "Form Builder",
                'key' => "form",
            ]
        );
        $this->hookAction->registerPermission(
            "form_index",
            [
                'name' => "form.index",
                'group' => "form",
                'description' => "View List Form Builder",
                'key' => "form",

            ]
        );
        $this->hookAction->registerPermission(
            "form_edit",
            [
                'name' => "form.edit",
                'group' => "form",
                'description' => "Edit List Form Builder",
                'key' => "form",

            ]
        );
        $this->hookAction->registerPermission(
            "form_create",
            [
                'name' => "form.create",
                'group' => "form",
                'description' => "Create List Form Builder",
                'key' => "form",

            ]
        );
        $this->hookAction->registerPermission(
            "form_delete",
            [
                'name' => "form.delete",
                'group' => "form",
                'description' => "Delete List Form Builder",
                'key' => "form",

            ]
        );
        // $this->hookAction->registerPermission(
        //     "form-builder_edit",
        //     [
        //         'name' => "form_builder.edit",
        //         'group' => "form_builders",
        //         'description' => "View form_builder",
        //         'key' => "form_builder",

        //     ]
        // );
    }

}
