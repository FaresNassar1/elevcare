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

use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\Notification;
use Juzaweb\CMS\Support\Theme\CustomMenuBox;
use Juzaweb\CMS\Support\Updater\CmsUpdater;
use Juzaweb\CMS\Version;
use Juzaweb\Frontend\Http\Controllers\PageController;
use Juzaweb\Frontend\Http\Controllers\PostController;
use Illuminate\Support\Facades\Schema;

class MenuAction extends Action
{
    public function handle()
    {
        $this->addAction(self::INIT_ACTION, [$this, 'addDatatableSearchFieldTypes']);
        $this->addAction(self::INIT_ACTION, [$this, 'addPostTypes']);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addBackendMenu']);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addSettingPage']);
        $this->addAction(self::BACKEND_INIT, [$this, 'addAdminScripts'], 10);
        $this->addAction(self::BACKEND_INIT, [$this, 'addAdminStyles'], 10);
        $this->addAction(self::INIT_ACTION, [$this, 'addMenuBoxs'], 50);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addTaxonomiesForm']);
        $this->addAction(self::INIT_ACTION, [$this, 'registerEmailHooks']);
    }


    public function addBackendMenu()
    {
        HookAction::addAdminMenu(
            trans_cms('cms::app.dashboard'),
            'dashboard',
            [
                'icon'     => 'fa fa-dashboard',
                'position' => 1,
            ]
        );

        if (config('juzaweb.plugin.enable_upload')) {
            HookAction::addAdminMenu(
                trans_cms('cms::app.dashboard'),
                'dashboard',
                [
                    'icon'     => 'fa fa-dashboard',
                    'position' => 1,
                    'parent'   => 'dashboard',
                ]
            );
        }

        HookAction::addAdminMenu(
            trans_cms('cms::app.media'),
            'media',
            [
                'icon'        => 'fa fa-photo',
                'position'    => 2,
                'permissions' => [
                    'media.index',

                ],
            ]
        );

        HookAction::addAdminMenu(
            trans_cms('cms::app.appearance'),
            'appearance',
            [
                'icon'        => 'fa fa-paint-brush',
                'position'    => 40,
                'permissions' => [
                    'menus.index',

                ],
            ]
        );

        HookAction::addAdminMenu(
            trans_cms('cms::app.menus'),
            'menus',
            [
                'icon'        => 'fa fa-list',
                'position'    => 2,
                'parent'      => 'appearance',
                'permissions' => [
                    'menus.index',
                ],
            ]
        );

        HookAction::addAdminMenu(
            trans_cms('cms::app.permalinks'),
            'permalinks',
            [
                'icon'        => 'fa fa-link',
                'position'    => 15,
                'parent'      => 'setting',
                'permissions' => [
                    'settings.permalinks',
                ],
            ]
        );

        HookAction::addAdminMenu(
            trans_cms('cms::app.plugins'),
            'plugins',
            [
                'icon'     => 'fa fa-plug',
                'position' => 50,
            ]
        );

        if (config('juzaweb.plugin.enable_upload')) {
            HookAction::addAdminMenu(
                trans_cms('cms::app.plugins'),
                'plugins',
                [
                    'icon'        => 'fa fa-plug',
                    'position'    => 1,
                    'parent'      => 'plugins',
                    'permissions' => [
                        'plugins.index',
                        'plugins.edit',
                        'plugins.create',
                        'plugins.delete',
                    ],
                ]
            );

            HookAction::addAdminMenu(
                trans_cms('cms::app.add_new'),
                'plugin.install',
                [
                    'icon'        => 'fa fa-plus',
                    'position'    => 1,
                    'parent'      => 'plugins',
                    'permissions' => [
                        'plugins.create',
                    ],
                ]
            );
        }

        HookAction::addAdminMenu(
            trans_cms('cms::app.setting'),
            'setting',
            [
                'icon'     => 'fa fa-cogs',
                'position' => 70,
            ]
        );

        HookAction::addAdminMenu(
            trans_cms('cms::app.managements'),
            'managements',
            [
                'icon'     => 'fa fa-cogs',
                'position' => 75,
            ]
        );

        HookAction::addAdminMenu(
            trans_cms('cms::app.general_setting'),
            'setting.system',
            [
                'icon'        => 'fa fa-cogs',
                'position'    => 1,
                'parent'      => 'setting',
                'permissions' => [
                    'settings.general',
                ],
            ]
        );

        HookAction::addAdminMenu(
            trans_cms('cms::app.users'),
            'users',
            [
                'icon'        => 'fa fa-user-circle-o',
                'position'    => 40,
                'parent'      => 'managements',
                'permissions' => [
                    'users.index',
                    'users.edit',
                    'users.create',
                    'users.delete',
                ],
            ]
        );

        HookAction::addAdminMenu(
            trans_cms('cms::app.email_templates'),
            'email-template',
            [
                'icon'        => 'fa fa-envelope',
                'position'    => 50,
                'parent'      => 'managements',
                'permissions' => [
                    'email_templates.index',
                    'email_templates.edit',
                    'email_templates.create',
                    'email_templates.delete',
                ],
            ]
        );

        if (!config('network.enable')) {
            HookAction::addAdminMenu(
                trans_cms('cms::app.email_logs'),
                'logs.email',
                [
                    'icon'        => 'fa fa-cogs',
                    'position'    => 51,
                    'parent'      => 'managements',
                    'permissions' => [
                        'email_logs.index',
                    ],

                ]
            );
        }
        HookAction::addAdminMenu(
            trans_cms('cms::app.actions_logs'),
            'logs.actions',
            [
                'icon'        => 'fa fa-cogs',
                'position'    => 52,
                'parent'      => 'managements',
                'permissions' => [
                    'actions_logs.index',
                ],
            ]
        );
    }

    public function addSettingPage()
    {
        HookAction::addSettingForm(
            'general',
            [
                'name'     => trans_cms('cms::app.general_setting'),
                'view'     => 'cms::backend.setting.system.form.general',
                'priority' => 1,
            ]
        );

        HookAction::addSettingForm(
            'email',
            [
                'name'     => trans_cms('cms::app.email_setting'),
                'view'     => 'cms::backend.email.setting',
                'header'   => false,
                'footer'   => false,
                'priority' => 50,
            ]
        );
    }

    public function addPostTypes()
    {

        $templates             = ThemeLoader::getTemplates(jw_current_theme());
        $landingPagesTemplates = ThemeLoader::getRegister(jw_current_theme(), 'landing_pages');
        $data                  = [
            'options' => ['' => trans_cms('cms::app.choose_template')],
        ];
        $landingPagesData      = [
            'options' => ['' => trans_cms('cms::app.choose_template')],
        ];
        foreach ($templates as $key => $template) {
            $data['options'][$key] = [
                'label' => $template['label'],
                'data'  => [
                    'has-block' => ($template['blocks'] ?? 0) ? 1 : 0,
                ],
            ];
        }

        foreach ($landingPagesTemplates as $key => $template) {
            $landingPagesData['options'][$key] = [
                'label' => $template['label'],
                'data'  => [
                    'has-block' => ($template['blocks'] ?? 0) ? 1 : 0,
                ],
            ];
        }

        HookAction::registerPostType(
            'pages',
            [
                'label'         => trans_cms('cms::app.pages'),
                'model'         => Post::class,
                'menu_icon'     => 'fa fa-edit',
                'rewrite'       => false,
                'callback'      => PageController::class,
                'menu_position' => 15,
                'metas'         => [
                    'ctemplate'     => [
                        'type'    => 'select',
                        'label'   => trans_cms('cms::app.template'),
                        'sidebar' => true,
                        'data'    => $data,
                    ],
                    'parent'        => [
                        'type'  => 'post',
                        'label' => trans_cms('cms::app.parent'),
                        'name'  => "pages",
                        'data'  => [
                            'type' => "pages",
                        ],
                    ],
                    'block_content' => [
                        'visible' => false,
                        'sidebar' => true,
                    ],
                ],
            ]
        );

        HookAction::registerPostType(
            'posts',
            [
                'label'         => trans_cms('cms::app.posts'),
                'model'         => Post::class,
                'menu_icon'     => 'fa fa-edit',
                'menu_position' => 16,
                'callback'      => PostController::class,
                'metas'         => [
                    'ctemplate'    => [
                        'type'    => 'select',
                        'label'   => trans_cms('cms::app.template'),
                        'sidebar' => true,
                        'data'    => $data,
                    ],
                    'pages'        => [
                        'type'  => 'post',
                        'label' => trans_cms('cms::app.pages'),
                        'name'  => "pages",
                        'data'  => [
                            'multiple' => true,
                            'type'     => "pages",
                        ],
                    ],
                    'primary_page' => [
                        'type'  => 'post',
                        'label' => trans_cms('cms::app.primary_page'),
                        'name'  => "primary_page",
                        'data'  => [
                            'multiple' => false,
                            'type'     => "pages",
                        ],
                    ],
                    'authors'      => [
                        'type'  => 'post',
                        'label' => trans_cms('cms::app.authors'),
                        'name'  => "authors",
                        'data'  => [
                            'multiple' => true,
                            'type'     => "authors",
                        ],
                    ],
                ],
                'supports'      => [
                    'tag',
                    'comment',
                ],
            ]
        );

        HookAction::registerPostType(
            'landing_pages',
            [
                'label'         => trans_cms('cms::app.landing_pages'),
                'model'         => Post::class,
                'menu_icon'     => 'fa fa-edit',
                'callback'      => PostController::class,
                'menu_position' => 17,
                'metas'         => [
                    'ctemplate'        => [
                        'type'          => 'select',
                        'label'         => trans_cms('cms::app.template'),
                        'sidebar'       => true,
                        'data'          => $landingPagesData,
                        'show_in_root'  => false,
                        'show_in_child' => true,
                    ],
                    'parent'           => [
                        'type'          => 'post',
                        'label'         => trans_cms('cms::app.parent'),
                        'name'          => "pages",
                        'sidebar'       => true,
                        'data'          => [
                            'type' => "landing_pages",
                        ],
                        'show_in_root'  => false,
                        'show_in_child' => true,
                    ],
                    'youtube_url'            => [
                        'type'          => 'text',
                        'show_in_root'  => false,
                        'show_in_child' => true,
                        'show_if_visible' => true,
                    ],
                    'is_slider'        => [
                        'type'            => 'checkbox',
                        'show_in_root'    => false,
                        'show_in_child'   => true,
                        'show_if_visible' => true,
                    ],
                    'hide_title'       => [
                        'type'          => 'checkbox',
                        'show_in_root'  => false,
                        'show_in_child' => true,
                    ],
                    'background_color' => [
                        'type'          => 'text',
                        'data'          => [
                            'type' => "color",
                        ],
                        'show_in_root'  => false,
                        'show_in_child' => true,
                    ],
                    'background_image' => [
                        'type'          => 'image',
                        'show_in_root'  => false,
                        'show_in_child' => true,
                    ],
                ],
            ]
        );

        HookAction::registerPostType(
            'authors',
            [
                'label'         => trans_cms('cms::app.authors'),
                'model'         => Post::class,
                'menu_icon'     => 'fa fa-user',
                'menu_position' => 17,
                'callback'      => PostController::class,
            ]
        );
        HookAction::registerPostType(
            'events',
            [
                'label'         => trans_cms('cms::app.events'),
                'model'         => Post::class,
                'menu_icon'     => 'fa fa-calendar',
                'menu_position' => 18,
                'callback'      => PostController::class,
                'metas'         => [
                    'ctemplate' => [
                        'type'    => 'select',
                        'label'   => trans_cms('cms::app.template'),
                        'sidebar' => true,
                        'data'    => @$edata,
                    ],
                    'address'   => [
                        'type'  => 'text',
                        'label' => trans_cms('cms::app.address'),
                    ],
                    'location'  => [
                        'type'  => 'text',
                        'label' => trans_cms('cms::app.location'),
                    ],
                ],
            ]
        );
        HookAction::registerPostType(
            'photos',
            [
                'label'         => trans_cms('cms::app.photos'),
                'model'         => Post::class,
                'menu_icon'     => 'fa fa-photo',
                'menu_position' => 18,
                'callback'      => PostController::class,
                'metas'         => [
                    'ctemplate' => [
                        'type'    => 'select',
                        'label'   => trans_cms('cms::app.template'),
                        'sidebar' => true,
                        'data'    => @$edata,
                    ],

                ],
            ]
        );
        HookAction::registerPostType(
            'videos',
            [
                'label'         => trans_cms('cms::app.videos'),
                'model'         => Post::class,
                'menu_icon'     => 'fa fa-play',
                'menu_position' => 18,
                'callback'      => PostController::class,
                'metas'         => [
                    'ctemplate' => [
                        'type'    => 'select',
                        'label'   => trans_cms('cms::app.template'),
                        'sidebar' => true,
                        'data'    => @$edata,
                    ],

                ],
            ]
        );
    }

    public function addMenuBoxs()
    {
        HookAction::registerMenuBox(
            'custom_url',
            [
                'title'    => trans_cms('cms::app.custom_url'),
                'group'    => 'custom',
                'menu_box' => new CustomMenuBox(),
            ]
        );
    }

    public function addTaxonomiesForm()
    {
        $types = HookAction::getPostTypes();
        foreach ($types as $key => $type) {
            add_action(
                "post_type.{$key}.form.right",
                function ($model) use ($key) {
                    echo view(
                        'cms::components.taxonomies',
                        [
                            'postType' => $key,
                            'model'    => $model,
                        ]
                    )->render();
                }
            );
        }
    }

    public function addAdminScripts()
    {
        $ver = Version::getVersion();
        HookAction::enqueueScript('core-vendor', 'jw-styles/juzaweb/js/vendor.min.js', $ver);
        HookAction::enqueueScript('core-table', 'jw-styles/juzaweb/js/juzaweb-table.js', $ver);
        HookAction::enqueueScript('core-list', 'jw-styles/juzaweb/js/list-view.js', $ver);
        HookAction::enqueueScript('core-tinymce', 'jw-styles/juzaweb/tinymce/tinymce.min.js', $ver);
    }

    public function addAdminStyles()
    {

    }

    public function addDatatableSearchFieldTypes()
    {
        $this->addFilter(
            Action::DATATABLE_SEARCH_FIELD_TYPES_FILTER,
            function ($items) {
                $items['text'] = [
                    'view' => view('cms::components.datatable.text_field'),
                ];

                $items['select'] = [
                    'view' => view('cms::components.datatable.select_field'),
                ];

                $items['taxonomy'] = [
                    'view' => view('cms::components.datatable.taxonomy_field'),
                ];
                $items['post']     = [
                    'view' => view('cms::components.datatable.post_field'),
                ];

                return $items;
            }
        );
    }

    public function registerEmailHooks()
    {
        HookAction::registerEmailHook(
            'register_success',
            [
                'label'  => trans_cms('cms::app.registered_success'),
                'params' => [
                    'name'        => trans_cms('cms::app.user_name'),
                    'email'       => trans_cms('cms::app.user_email'),
                    'verifyToken' => trans_cms('cms::app.verify_token'),
                ],
            ]
        );
    }
}
