<?php

/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

class SocialLinksAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addConfigs']);
    }

    /**
     * Add social links configurations
     *
     *
     * @return void
     */
    public function addConfigs(): void
    {
        $this->hookAction->registerConfig(
            [
                'facebook' => [
                    'form' => 'social-links',
                    'label' => "Facebook",

                ],
                'twitter' => [
                    'form' => 'social-links',
                    'label' => "Twitter",

                ],
                'instagram' => [
                    'form' => 'social-links',
                    'label' => "Instagram",

                ],
                'youtube' => [
                    'form' => 'social-links',
                    'label' => "Youtube",

                ],
                'telegram' => [
                    'form' => 'social-links',
                    'label' => "Telegram",

                ],
                'linkedin' => [
                    'form' => 'social-links',
                    'label' => "Linkedin",

                ],
                'whatsapp' => [
                    'form' => 'social-links',
                    'label' => "Whatsapp",

                ],
                'tiktok' => [
                    'form' => 'social-links',
                    'label' => "Tiktok",

                ],

            ]
        );

        $this->hookAction->addSettingForm(
            'social-links',
            [
                'name' => trans_cms('cms::app.social_links'),
                'priority' => 2,
            ]
        );
    }
}
