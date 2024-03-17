<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Juzaweb\Backend\Models\Post;
use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $keyword = $request->input('q');
        $title = $keyword ? __('Search results for') . " $keyword" : __('Search Results');
            $query = Post::where(function ($query) use ($keyword) {
                $query->whereSearch(['q' => $keyword])
                    ->where("lang", app()->getLocale())
                    ->orderBy('display_order', 'asc')
                    ->orderBy('date', 'desc')
                    ->where(function ($subquery) {
                        $subquery->published()
                            ->orWhere('type', 'events')
                            ->where('status', Post::STATUS_PUBLISH);
                    });
            });

        $posts = $query->paginate(get_config('posts_per_page', 12));
        $posts->appends($request->query());
        $page = PostResourceCollection::make($posts)->response()->getData(true);
        return view('frontend::search', compact('page', 'posts', 'title', 'keyword'));
    }
}
