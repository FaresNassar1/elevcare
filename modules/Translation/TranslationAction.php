<?php

namespace Juzaweb\Translation;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

class TranslationAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addBackendMenu']);
    }

    public function addBackendMenu()
    {
        HookAction::registerAdminPage(
            'translations',
            [
                'title' => trans_cms('cms::app.translations'),
                'menu' => [
                    'icon' => 'fa fa-language',
                    'position' => 90,
                    'permissions' => [
                        'translations.index',
                        'translations.edit',
                        'translations.create',
                        'translations.delete',
                    ],
                ],
            ]
        );
    }
}
