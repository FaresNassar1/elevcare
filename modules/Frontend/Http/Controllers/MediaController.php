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

class MediaController extends Controller
{
    protected $cacheTime;
    public function __construct()
    {
        $this->cacheTime = get_config('cache_duration', 0);
    }

    public function media()
    {
        return view('frontend::media.index');
    }

    public function albums($lang, $slug, Request $request)
    {
        //Get page posts
        $rpage = $request['page'] ? $request['page'] : 1;
        $albums = Cache::remember("media-$slug-$lang-$rpage", $this->cacheTime, function () use ($slug) {
            $query = Post::published()
                ->where('type', $slug)
                ->orderBy('display_order', 'asc')
                ->orderBy('date', 'desc');
            return $query->paginate(get_config('posts_per_page', 12));
        });
        $main_slug = $slug;
        $pagination_page = PostResourceCollection::make($albums)->response()->getData(true);
        return view('frontend::media.albums', compact('albums', 'pagination_page', 'main_slug'));
    }

    public function album($lang, $slug, Request $request)
    {
        $main_post = Cache::remember("post-$slug-$lang", $this->cacheTime, function () use ($slug, $lang) {
            return Post::PublishedOrDraft()->where('path', '/' . $slug . '/')
                ->where('lang', $lang)
                ->orderBy('date', 'desc')
                ->first();
        });
        if ($main_post) {
            if ($main_post->external_link != "") {
                return redirect($main_post->external_link);
            }
            if ($main_post->status == "draft" || $main_post->status == "preview") {
                $user = Auth::user();
                if (!$user) {
                    abort(404);
                }
            }
            if ($main_post['type'] == "photos" || $main_post['type'] == "videos") {
                event(new PostViewed($main_post));
                return $this->showAlbum($main_post);
            }
        } else {
            abort(404);
        }
    }

    public function showAlbum($main_post)
    {
        $pageID = $main_post['id'];
        $template = @$main_post->json_metas['ctemplate'];
        $post_metas = "";
        if ($main_post->json_metas) {
            $post_metas = $main_post->json_metas;
        }

        $fileTypes = [];
        if ($main_post->files) {
            foreach ($main_post->files as $file) {
                $fileInfo = MediaFile::where("path", $file)->first();
                $fileTypes[$fileInfo->type][] = $fileInfo;
            }
        }
        $related_posts = Cache::remember("related_posts-$pageID", $this->cacheTime, function () use ($main_post) {
            return Post::published()
                ->where('type', $main_post->type)
                ->where('id', '<>', $main_post->id)
                ->orderBy('display_order', 'asc')
                ->orderBy('date', 'desc')
                ->limit(6)
                ->get();
        });

        return view('frontend::media.album', compact('main_post', 'post_metas', 'template', 'related_posts', 'fileTypes'));
    }
}

