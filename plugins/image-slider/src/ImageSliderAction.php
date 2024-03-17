<?php

namespace Juzaweb\ImageSlider;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

class ImageSliderAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'registerResource']);
        $this->addAction(
            'resource.sliders.form_left',
            [$this, 'addFormBanner']
        );

        $this->addFilter(
            'resource.sliders.parseDataForSave',
            [$this, 'parseDataForSave']
        );
    }

    public function registerResource()
    {
        HookAction::registerResource(
            'sliders',
            null,
            [
                'label' => trans_cms('juim::content.sliders'),
                'menu' => [
                    'icon' => 'fa fa-sliders',
                    'position' => 6,
                    'parent' => 'appearance',
                    'permissions' => [
                        'resource_sliders.index',
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
        echo e(view('juim::slider.form', compact('model')));
    }

    public function parseDataForSave($attributes)
    {

        $titles = $attributes['titles'] ?? [];
        $links = $attributes['links'] ?? [];
        $images = $attributes['images'] ?? [];
        $descriptions = $attributes['descriptions'] ?? [];
        $newTab = $attributes['new_tabs'] ?? [];
        $date = $attributes['s_date'] ?? [];
        $end_date = $attributes['s_end_date'] ?? [];
        $content = [];
        foreach ($titles as $key => $title) {

            $content[] = [
                'title' => $title,
                'link' => $links[$key] ?? null,
                'image' => $images[$key] ?? null,
                'description' => $descriptions[$key] ?? null,
                'new_tab' => $newTab[$key] ?? 0,
                'date' => $date[$key] ?? null,
                'end_date' => $end_date[$key] ?? null,
            ];
        }

        $attributes['meta']['content'] = $content;

        return $attributes;
    }
}
