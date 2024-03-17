<?php

use Juzaweb\CMS\Support\Email;
use Juzaweb\Backend\Models\Post;
use Illuminate\Database\Eloquent\Builder;

if (!function_exists('get_direction')) {
    function get_direction(): string
    {
        return config('app.locales.' . app()->getLocale() . '.dir');
    }
}

if (!function_exists('send_email_notification')) {
    function send_email_notification($form_name, $email_to, $dynamicLink, $formData)
    {
        unset($formData['form']);
        $data     = [
            'subject'  => "New $form_name Form Submission",
            'body'     => "A new submission for the $form_name form has been received.",
            'link'     => $dynamicLink,
            'formData' => $formData,
        ];
        $htmlBody = view('frontend::emails.forms', $data)->render();

        Email::make()
            ->setEmails($email_to)
            ->withTemplate('notification')
            ->setSubject($data['subject'])
            ->setBody($htmlBody)
            ->send();
    }
}

//POSTS RELATED FUNCTIONS
if (!function_exists('get_relID_page')) {
    function get_relID_page($pageID)
    {
        $cacheKey = "lang_pages:$pageID-" . app()->getLocale();
        return Cache::remember($cacheKey, get_config('cache_duration', 0), function () use ($pageID) {
            return Post::published()
                ->where(function ($query) use ($pageID) {
                    $query->where("id", $pageID)
                        ->orWhere("rel_id", $pageID);
                })
                ->where("lang", app()->getLocale())
                ->first();
        });
    }
}

if (!function_exists('get_page_posts')) {

    function get_page_posts($pageID, $limit = null, $statusLabel = "published")
    {
        $page_posts = Cache::remember("posts-$pageID-" . app()->getLocale(), get_config('cache_duration', 0), function () use ($pageID, $statusLabel, $limit) {
            $query = Post::{$statusLabel}()->whereJsonContains('json_metas->pages', "$pageID")
                ->where('type', 'posts')
                ->orderBy('display_order', 'asc')
                ->orderBy('date', 'desc')
                ->orderBy('title', 'asc');
            if ($limit !== null) {
                $query->limit($limit);
            }
            return $query->get();
        });
        return $page_posts;
    }
}

if (!function_exists('get_sub_pages')) {
    function get_sub_pages($pageID, $limit = null, $statusLabel = "published")
    {
        $sub_pages = Cache::remember("subpages-$pageID-" . app()->getLocale(), get_config('cache_duration', 0), function () use ($pageID, $statusLabel, $limit) {
            $query = Post::{$statusLabel}()->where('json_metas->parent', $pageID)
                ->whereIn('type', ['pages', 'landing_pages'])
                ->orderBy('display_order', 'asc')
                ->orderBy('date', 'desc')
                ->orderBy('title', 'asc');
            if ($limit !== null) {
                $query->limit($limit);
            }
            return $query->get();
        });

        return $sub_pages;
    }
}

function get_page_posts_pagination(int $pageID, $statusLabel = "published", $rpage = 0, $page_type = "", $request = null)
{
    $cacheKey  = "posts-$pageID-$page_type-$rpage-" . app()->getLocale();
    $cacheTime = get_config('cache_duration', 0);
    $result    = Cache::remember($cacheKey, $cacheTime, function () use ($pageID, $statusLabel, $request) {
        //Get Page Posts
        $query    = Post::{$statusLabel}()
            ->whereJsonContains('json_metas->pages', "$pageID");
        $category = $request->input('category', '');
        $country  = $request->input('country', '');

        if ($category && $category != "") {
            $query->whereJsonContains('json_metas->pages', $category);
        }
        if ($country && $country != "") {
            $query->whereJsonContains('json_metas->pages', $country);
        }
        $query->where('type', 'posts')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'asc');

        return $query->paginate(get_config('posts_per_page', 12));
    });

    return $result;
}

function breadcrumbs($path)
{
    $lang                         = app()->getLocale();
    $cacheTime                    = get_config('cache_duration', 0);
    $returns                      = [];
    $returns['breadcrumbs_array'] = [];
    $returns['tree_menu']         = false;
    $pages_tree                   = explode('/', trim($path, '/'));
    array_pop($pages_tree);

    foreach ($pages_tree as $crumb) {
        $crumbPage = Cache::remember("crumb_$path" . "_" . "$crumb" . "_" . app()->getLocale(), $cacheTime, function () use ($crumb, $lang) {
            return Post::where('slug', $crumb)
                ->where('lang', $lang)
                ->first();
        });
        if ($crumbPage) {
            if ($crumbPage->json_metas['ctemplate'] == "aside_children") {
                $returns['tree_menu'] = $crumbPage->id;
            }
            $crumbData                      = [
                "id"    => $crumbPage->id,
                'title' => $crumbPage->title,
                'path'  => $crumbPage->path,
            ];
            $returns['breadcrumbs_array'][] = $crumbData;
        }
    }
    return $returns;
}

if (!function_exists('get_page_title')) {
    function get_page_title($title, $keywords)
    {
        return ($title . '-' . implode(',', $keywords));
    }
}


if (!function_exists('getSocialMenu')) {
    function getSocialMenu()
    {
        $socialTitles = ['facebook', 'linkedin', 'twitter', 'instagram', 'youtube', 'tiktok'];
        $socialList   = [];

        foreach ($socialTitles as $socialTitle) {
            if (!empty(get_config($socialTitle))) {
                array_push($socialList, [
                    'title' => $socialTitle,
                    'url'   => get_config($socialTitle)
                ]);
            }
        }
        return $socialList;
    }
}

if (!function_exists('getContactInfo')) {
    function getContactInfo()
    {
        $inputs      = [
            ['name' => 'location', 'title' => 'Address', 'icon' => 'icon-pin', 'lingual' => true, 'type' => 'location'],
            ['name' => 'phone', 'title' => 'Phone', 'icon' => 'icon-phone', 'lingual' => false, 'type' => 'phone'],
            ['name' => 'direct_number', 'title' => 'Direct Number', 'icon' => 'icon-phone1', 'lingual' => false, 'type' => 'phone'],
            ['name' => 'contact_email', 'title' => 'Email', 'icon' => 'icon-mail1', 'lingual' => false, 'type' => 'mail']
        ];
        $contactInfo = [];

        foreach ($inputs as $input) {
            $field = $input['name'];
            if ($input['lingual']) {
                $field = $input['name'] . '_' . app()->getLocale();
            }
            $url = get_config($field);
            if ($input['type'] === 'location') {
                $url = !empty(get_config('map_link')) ? get_config('map_link') : '';
            } elseif ($input['type'] === 'phone') {
                $url = 'tel:' . get_config($field);
            } elseif ($input['type'] === 'mail') {
                $url = 'mailto:' . get_config($field);
            }
            if (!empty(get_config($field))) {
                $contactInfo[] = [
                    'title' => __('messages.' . $input['name']),
                    'input' => get_config($field),
                    'url'   => $url,
                    'icon'  => $input['icon']
                ];
            }
        }
        return $contactInfo;
    }
}

if (!function_exists('lazyloadImage')) {
    function lazyloadImage($path, $width, $height, $attrs, $srcSet, $disabled = false)
    {
        $pathEntities = explode('/', ltrim($path, '/'));
        if ($pathEntities[0] === 'storage') {
            $imageUrl = $path;
        } else {
            $imageUrl = upload_url($path);
        }
//        if (is_url($path)) {
//        } else {
//            $storage  = Storage::disk('public');
//            $imageUrl = $storage->url($path);
//        }

        if (!$disabled) {
            if (array_key_exists('class', $attrs)) {
                $attrs['class'] .= ' lazyload';
            } else {
                $attrs['class'] = 'lazyload';
            }
        }

        $htmlProps = [];
        foreach ($attrs as $key => $value) {
            $value       = htmlentities($value);
            $htmlProps[] = "$key=\"$value\"";
        }
        $htmlProps = implode(' ', $htmlProps);

        $lowImage = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

        $imageTag = "<img src='{$lowImage}' data-src='{$imageUrl}' width='{$width}' height='{$height}' {$htmlProps} />";

        return $imageTag;
    }
}

if (!function_exists('getYoutubeImage')) {
    function getYoutubeImage($url): string
    {
        return 'https://img.youtube.com/vi/' . get_youtube_id($url) . '/hqdefault.jpg';
    }
}
