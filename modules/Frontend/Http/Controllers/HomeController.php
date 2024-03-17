<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Models\Post;

class HomeController extends Controller
{
    protected $cacheTime;

    public function __construct()
    {
        $this->cacheTime = get_config('cache_duration', 0);
    }

    public function home()
    {
        $limit = get_config('posts_per_page', 12);

        //Main Slider
        $mainSlider = Cache::remember("main-slider-" . app()->getLocale(), $this->cacheTime, function () {
            $slider = get_slider_by_id(1, "sliders");
            if ($slider) {
                return json_decode($slider['metas']['content'], true);
            }
            return [];
        });

        $homePageId = 1;

        $homepage = Cache::remember("home-" . app()->getLocale(), $this->cacheTime, function () use ($homePageId) {
            return Post::published()
                ->where("id", $homePageId)
                ->orWhere("rel_id", $homePageId)
                ->where("type", "pages")
                ->where("lang", app()->getLocale())->first();
        });

        $homepageBlocks = Cache::remember("home-blocks" . app()->getLocale(), $this->cacheTime, function () use ($homepage) {
            // $pageID = $homepage->id;
            // return Post::published()
            //     ->where(function ($query) use ($pageID) {
            //         $query->where('json_metas->parent', $pageID)
            //             ->orWhereJsonContains('json_metas->pages', "$pageID");
            //     })
            //     ->orderBy('display_order', 'asc')
            //     ->orderBy('date', 'desc')
            //     ->get();
        });

        return view('frontend::home', compact('mainSlider', 'homepageBlocks'));
    }
}
