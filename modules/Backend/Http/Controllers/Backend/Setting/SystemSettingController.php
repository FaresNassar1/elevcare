<?php

namespace Juzaweb\Backend\Http\Controllers\Backend\Setting;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Juzaweb\Backend\Http\Requests\Setting\SettingRequest;
use Juzaweb\CMS\Contracts\GlobalDataContract;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Models\Language;

class SystemSettingController extends BackendController
{
    protected GlobalDataContract $globalData;

    protected HookActionContract $hookAction;

    public function __construct(
        GlobalDataContract $globalData,
        HookActionContract $hookAction
    ) {
        $this->globalData = $globalData;
        $this->hookAction = $hookAction;
    }

    public function index($page, $form = 'general'): View
    {
        global $jw_user;
        if (!$jw_user->can("settings.$form")) {
            abort(403);
        }

        $forms = $this->getForms($page);
        if (!isset($forms[$form])) {
            $form = $forms->first()->get('key');
        }
        $configs = $this->hookAction->getConfigs()->where('form', $form);
        $title = $forms[$form]['name'] ?? trans_cms('cms::app.system_setting');
   

        return view(
            'cms::backend.setting.system.index',
            [
                'title' => $title,
                'component' => $form,
                'forms' => $forms,
                'configs' => $configs,
                'page' => $page,
            ]
        );
    }

    public function save(SettingRequest $request): JsonResponse|RedirectResponse
    {

        $locales = config('locales');
        $configs = $request->only($this->hookAction->getConfigs()->keys()->toArray());
        if ($request['form'] == "seo") {
            if ($request['jw_enable_sitemap'] == null) {
                set_config("jw_enable_sitemap", 0);
            }
            if ($request['jw_enable_post_feed'] == null) {
                set_config("jw_enable_post_feed", 0);
            }
            if ($request['jw_enable_taxonomy_feed'] == null) {
                set_config("jw_enable_taxonomy_feed", 0);
            }
            if ($request['jw_auto_ping'] == null) {
                set_config("jw_auto_ping", 0);
            }
        }
        if ($request['form'] == "general") {
            if ($request['site_keywords'] == null) {
                set_config("site_keywords", []);
            }
            if ($request['cache_duration'] == null || $request['cache_duration'] == "") {
                set_config("cache_duration", 0);
            }
        }
        foreach ($configs as $key => $config) {
            if ($request->has($key)) {
                set_config($key, $config);
                if ($key == 'language') {
                    if (!Language::existsCode($config)) {
                        Language::create(
                            [
                                'code' => $config,
                                'name' => $locales[$config]['name'],
                            ]
                        );
                    }

                    Language::setDefault($config);
                }
            }
        }

        $content = [
            'method' => "PUT",
            'table' => "configs",
            'id' => "",
            'type' => $request['form'],
            'label' => "updated " . $request['form'] . " settings",
            'title' => "",
            'path' => "",
            'form_data' => $request->all(),
        ];
        log_action($content);

        return $this->success(
            [
                'message' => trans_cms('cms::app.saved_successfully'),
            ]
        );
    }

    protected function getForms(string $page): \Illuminate\Support\Collection
    {
        global $jw_user;

        $forms = collect($this->globalData->get('setting_forms'))
            ->where('page', $page)
            ->sortBy('priority');

        $allowed_forms = $forms->filter(function ($form) use ($jw_user) {
            return $jw_user->can("settings." . $form['key']);
        });

        return $allowed_forms;
    }
}
