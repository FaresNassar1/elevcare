<?php

/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Actions;

use Juzaweb\CMS\Abstracts\Action;

class MediaAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'addMediaConfigs']);
        $this->addAction(Action::BACKEND_INIT, [$this, 'addAdminMenu']);
    }

    public function addAdminMenu()
    {
        $this->hookAction->registerAdminPage(
            'options-media',
            [
                'title' => trans_cms('cms::app.media'),
                'menu' => [
                    'icon' => 'fa fa-list',
                    'position' => 30,
                    'parent' => 'setting',
                    'permissions' => [
                        'settings.options-media',
                    ],
                ]
            ]
        );
    }

    public function addMediaConfigs()
    {
        $this->hookAction->registerConfig(
            [
                'thumbnail_defaults',
            ]
        );
    }
}
