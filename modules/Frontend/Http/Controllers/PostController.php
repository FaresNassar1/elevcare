<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Events\PostViewed;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;

class PostController extends Controller
{
    protected $cacheTime;

    public function __construct()
    {
        $this->cacheTime = get_config('cache_duration', 0);
    }

    public function post($lang, Request $request, $slug = null)
    {
        $main_post = Cache::remember("post-$slug-$lang", $this->cacheTime, function () use ($slug, $lang) {
            return Post::PublishedOrDraft()->where('path', '/' . $slug . '/')
                ->where('lang', $lang)
                ->whereIn('type', ["posts", "pages", "authors", "landing_pages"])
                ->orderBy('id', 'asc')
                ->firstOrFail();
        });

        if ($main_post->external_link) {
            return redirect($main_post->external_link);
        }
        if (in_array($main_post->status, ["draft", "preview"])) {
            if (!Auth::user()) {
                abort(404);
            }
        }
        event(new PostViewed($main_post));

        return $this->showPage($main_post, $request);
    }

    public function showPage($main_post, Request $request)
    {

        if ($main_post->show_sitemap == 0) {
            abort(404);
        }
        $template      = $main_post->json_metas['ctemplate'] ?? "default";
        $pageID        = $main_post['id'];
        $page_type     = $main_post['type'];
        $currentLocale = app()->getLocale();

        $statusLabel = $main_post->status === "draft" || $main_post->status === "preview" ? "PublishedOrDraft" : "published";

        // Get page sub pages
        $sub_pages = get_sub_pages($pageID, null, $statusLabel);

        //Pagination and query parameters
        $rpage = $request->input('page', 1);

        $posts           = get_page_posts_pagination($pageID, $statusLabel, $rpage, $page_type, $request);
        $pagination_page = PostResourceCollection::make($posts)->response()->getData(true);
        if ($posts->isEmpty()) {
            $posts           = [];
            $pagination_page = null;
        }
        $subject = 'Some value'; // Define or initialize $subject

        $metas = $main_post->json_metas['metas'];
        return view('frontend::posts.' . $page_type, compact('posts', 'sub_pages', 'main_post', 'pagination_page', 'template', 'metas'));
    }
}
