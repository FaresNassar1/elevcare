<?php

namespace Juzaweb\Popup;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

class PopupAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'registerResource']);
        $this->addAction(
            'resource.popups.form_left',
            [$this, 'addFormBanner']
        );

        $this->addFilter(
            'resource.popups.parseDataForSave',
            [$this, 'parseDataForSave']
        );
    }

    public function registerResource()
    {
        HookAction::registerResource(
            'popups',
            null,
            [
                'label' => trans_cms('jpopups::content.popups'),
                'menu' => [
                    'icon' => 'fa fa-window-restore',
                    'position' => 6,
                    'parent' => 'appearance',
                    'permissions' => [
                        'resource_popups.index',
                    ]
                ],
                'metas' => [
                    'content' => [
                        'type' => 'textarea',
                        'data' => [
                            'hidden' => true,
                        ]
                    ]
                ],
            ]
        );
    }

    public function addFormBanner($model)
    {
        echo e(view('jpopups::popup.form', compact('model')));
    }

    public function parseDataForSave($attributes)
    {

        $links = $attributes['links'] ?? [];
        $images = $attributes['images'] ?? [];
        $descriptions = $attributes['descriptions'] ?? [];
        $newTab = $attributes['new_tabs'] ?? [];

        $content = [];
        foreach ($images as $key => $image) {
            $content[] = [
                'link' => $links[$key] ?? null,
                'image' => $images[$key] ?? null,
                'description' => $descriptions[$key] ?? null,
                'new_tab' => $newTab[$key] ?? 0,
            ];
        }

        $attributes['meta']['content'] = $content;

        return $attributes;
    }
}
