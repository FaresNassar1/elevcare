<?php

/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Datatables;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\User;

class PostTypeDataTable extends DataTable
{
    protected array $postType;

    protected ?Collection $resourses = null;

    protected ?Collection $taxonomies = null;

    public function mount($postType)
    {
        if (is_string($postType)) {
            $postType = HookAction::getPostTypes($postType)->toArray();
        }

        $this->postType   = $postType;
        $this->taxonomies = HookAction::getTaxonomies($this->postType);

        $resourses = HookAction::getResource()->where('post_type', $postType['key'])->whereNull('parent');

        if ($resourses->isNotEmpty()) {
            $this->resourses = $resourses;
        }
    }

    public function columns(): array
    {
        if ($this->resourses) {
            $columns['actions'] = [
                'label'     => trans_cms('cms::app.actions'),
                'width'     => '10%',
                'align'     => 'center',
                'sortable'  => false,
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'cms::components.datatable.actions',
                        [
                            'row'       => $row,
                            'resourses' => $this->resourses,
                        ]
                    )->render();
                },
            ];
        }

        if ($this->postType['key'] != 'pages' and $this->postType['key'] != 'landing_pages') {
            $columns['thumbnail'] = [
                'label'     => trans_cms('cms::app.thumbnail'),
                'width'     => '5%',
                'sortable'  => false,
                'formatter' => function ($value, $row, $index) {
                    return '<img class="lazyload w-100" data-src="' . $row->getThumbnail('150xauto') . '"'
                        . ' src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="/>';
                },
            ];
        }

        $columns['title'] = [
            'label'     => trans_cms('cms::app.title'),
            'formatter' => [$this, 'rowActionsFormatter'],
        ];

        $taxonomies = $this->taxonomies->where('taxonomy', '!=', 'tags')->take(3);

        foreach ($taxonomies as $key => $taxonomy) {
            $columns["tax_{$key}"] = [
                'label'     => $taxonomy->get('label'),
                'width'     => '15%',
                'sortable'  => false,
                'formatter' => function ($value, $row, $index) use ($key) {
                    return $row->taxonomies
                        ->where('taxonomy', '=', $key)
                        ->take(5)
                        ->pluck('name')
                        ->join(', ');
                },
            ];
        }

        if ($this->postType['key'] == 'pages') {
            $columns['json_metas'] = [
                'label'     => trans_cms('cms::app.parent'),
                'width'     => '10%',
                'formatter' => function ($value, $row, $index) {
                    $metas = $row->json_metas;
                    if (isset($metas['parent']) && $metas['parent'] != "") {
                        $page = Post::find($metas['parent']);
                        if ($page) {
                            return $page->title;
                        }
                    }
                },
            ];
        }
        if ($this->postType['key'] == 'pages') {
            $columns['total_supages'] = [
                'label'     => trans_cms('cms::app.total_pages'),
                'width'     => '10%',
                'formatter' => function ($value, $row, $index) {
                    $count = Post::where('json_metas->parent', $row->id)
                        ->where('type', 'pages')
                        ->where('status', '!=', Post::STATUS_PREVIEW)
                        ->count();
                    return "<a href='" . route('admin.posts.index', ['type' => 'pages', "parent" => $row->id]) . "'>$count</a>";
                },
            ];
        }

        if ($this->postType['key'] == 'pages' || $this->postType['key'] == 'authors') {
            $columns['total_posts'] = [
                'label'     => trans_cms('cms::app.total_posts'),
                'width'     => '10%',
                'formatter' => function ($value, $row, $index) {
                    $key_type = $this->postType['key'];
                    $count    = Post::whereHas('metas', function ($query) use ($row, $key_type) {
                        $query->where('meta_key', "$key_type")
                            ->whereJsonContains('meta_value', "$row->id");
                    })
                        ->where('type', 'posts')
                        ->where('status', '!=', Post::STATUS_PREVIEW)
                        ->count();
                    return "<a href='" . route('admin.posts.index', ['type' => 'posts', $key_type => $row->id]) . "'>$count</a>";
                },
            ];
        }
        if ($this->postType['key'] == 'posts') {
            $columns['json_metas'] = [
                'label'     => trans_cms('cms::app.page'),
                'width'     => '10%',
                'formatter' => function ($value, $row, $index) {
                    $metas = $row->json_metas;
                    $pages = '';
                    if (isset($metas['pages'])) {
                        foreach ($metas['pages'] as $page) {
                            $page = Post::find($page);
                            if ($page) {
                                $pages .= $page->title . ',';
                            }
                        }
                    }
                    return rtrim($pages, ',');
                },
            ];
        }

        $columns['created_at'] = [
            'label'     => trans_cms('cms::app.created_at'),
            'width'     => '10%',
            'formatter' => function ($value, $row, $index) {
                return jw_date_format($row->created_at);
            },
        ];
        $columns['updated_at'] = [
            'label'     => trans_cms('cms::app.updated_at'),
            'width'     => '10%',
            'formatter' => function ($value, $row, $index) {
                $user        = User::find($row->updated_by);
                $updatedAt   = Carbon::parse($row->updated_at);
                $timeElapsed = $updatedAt->diffForHumans();

                return $timeElapsed . "<br/>by " . $user->name;
            },
        ];

        $columns['display_order'] = [
            'label' => trans_cms('cms::app.display_order'),
            'width' => '10%',
        ];

        $columns['status'] = [
            'label'     => trans_cms('cms::app.status'),
            'width'     => '10%',
            'align'     => 'center',
            'formatter' => function ($value, $row, $index) {
                $timeElapsed = "";
                if ($row->type != "events" && !is_null($row->date) && $row->date > Carbon::now()) {
                    $row['status'] = "scheduled";
                    $publishedAt   = Carbon::parse($row->date);
                    $timeElapsed   = $publishedAt->diffForHumans();
                }
                if ($row->type != "events" && !is_null($row->end_date) && $row->end_date < Carbon::now()) {
                    $row['status'] = "private";
                }
                return view(
                    'cms::components.datatable.status',
                    compact(
                        'row',
                        'timeElapsed'
                    )
                )->render();
            },
        ];

        return $columns;
    }

    public function actions(): array
    {
        $statuses = $this->makeModel()->getStatuses();

        $statuses['delete'] = trans_cms('cms::app.delete');

        return $statuses;
    }

    public function bulkActions($action, $ids)
    {
        $statuses = array_keys($this->makeModel()->getStatuses());
        $posts    = $this->makeModel()->whereIn('id', $ids)->get();

        foreach ($posts as $post) {
            DB::beginTransaction();
            try {
                if ($action == 'delete' && ($post->lang === null || $post->lang == get_config('language'))) {
                    if ($post->type == "pages" || $post->type == "authors") { //Alert for children
                        $countPages = 0;
                        $countPosts = Post::whereHas('metas', function ($query) use ($post) {
                            $query->where('meta_key', $post->type)
                                ->whereJsonContains('meta_value', "$post->id");
                        })
                            ->where('type', 'posts')
                            ->where('status', '!=', Post::STATUS_PREVIEW)
                            ->count();

                        if ($post->type == "pages") {
                            $countPages = Post::whereHas('metas', function ($query) use ($post) {
                                $query->where('meta_key', "parent")
                                    ->where('meta_value', "$post->id");
                            })
                                ->where('type', 'pages')
                                ->where('status', '!=', Post::STATUS_PREVIEW)
                                ->count();
                        }

                        if ($countPosts == 0 && $countPages == 0) {
                            $this->deleteRelatedLangPosts($post);
                        } else {
                            $del_error_msg = "";
                            if ($countPages > 0) {
                                $del_error_msg .= "$countPages sub pages,";
                            }
                            if ($countPosts > 0) {
                                $del_error_msg .= "$countPosts related posts,";
                            }
                            $data = [
                                "status"  => false,
                                "message" => "Page has $del_error_msg please delete them first.",
                            ];
                            return $data;
                        }
                    } else { //Direct delete primary and related
                        $this->deleteRelatedLangPosts($post);
                    }
                }

                if (in_array($action, $statuses)) {
                    $post->update(
                        [
                            'status' => $action,
                        ]
                    );
                }

                DB::commit();

                $content = [
                    'method' => $action,
                    'table'  => $post->table,
                    'id'     => $post->id,
                    'type'   => $post->type,
                    'label'  => "$action a " . Str::singular($post->type),
                    'title'  => $post->title,
                    'path'   => "",
                ];
                log_action($content);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }
    }

    public function deleteRelatedLangPosts($post)
    {
        $posts = POST::where("rel_id", $post->id)->get();
        foreach ($posts as $relatedPost) {
            $relatedPost->delete(); // Delete each related post
        }
        $post->delete();
    }

    public function searchFields(): array
    {
        $data = [
            'keyword' => [
                'type'        => 'text',
                'label'       => trans_cms('cms::app.keyword'),
                'placeholder' => trans_cms('cms::app.keyword'),
            ],
            'status'  => [
                'type'    => 'select',
                'width'   => '100px',
                'label'   => trans_cms('cms::app.status'),
                'options' => $this->makeModel()->getStatuses("posts", true),
            ],
        ];

        if ($this->postType['key'] == 'pages') {
            $pages         = Post::where("type", "pages")->get();
            $filter_parent = "";
            if (isset($_GET['parent'])) {
                $filter_parent = Post::where("type", "pages")
                    ->where("id", $_GET['parent'])->first();
            }
            foreach ($pages as $page) {
                $data['pages'] = [
                    'type'     => 'post',
                    'label'    => "Parents",
                    'post'     => $page,
                    'selected' => $filter_parent,
                ];
            }
        }
        if ($this->postType['key'] == 'posts') {
            $pages       = Post::where("type", "pages")->get();
            $filter_page = "";
            if (isset($_GET['pages'])) {
                $filter_page = Post::where("type", "pages")
                    ->where("id", $_GET['pages'])->first();
            }
            foreach ($pages as $page) {
                $data['pages'] = [
                    'type'     => 'post',
                    'label'    => "Pages",
                    'post'     => $page,
                    'selected' => $filter_page,
                ];
            }

            $authors       = Post::where("type", "authors")->get();
            $filter_author = "";
            if (isset($_GET['authors'])) {
                $filter_author = Post::where("type", "authors")
                    ->where("id", $_GET['authors'])->first();
            }
            foreach ($authors as $author) {
                $data['authors'] = [
                    'type'     => 'post',
                    'label'    => "Authors",
                    'post'     => $author,
                    'selected' => $filter_author,
                ];
            }
        }
        $taxonomies = HookAction::getTaxonomies($this->postType['key']);
        foreach ($taxonomies as $key => $taxonomy) {
            $data[$key] = [
                'type'     => 'taxonomy',
                'label'    => $taxonomy->get('label'),
                'taxonomy' => $taxonomy,
            ];
        }

        return $data;
    }

    public function rowAction($row): array
    {
        $data = parent::rowAction($row);
        if (in_array($row->status, ['publish', 'private'])) {
            $data['view'] = [
                'label'  => trans_cms('cms::app.view'),
                'url'    => $row->getLink(),
                'target' => '_blank',
            ];
        }
        if (in_array($row->status, ['draft'])) {
            $data['view'] = [
                'label'  => trans_cms('cms::app.preview'),
                'url'    => $row->getLink(),
                'target' => '_blank',
            ];
        }

        if ($this->postType['key'] == 'pages') {
            $data['add_post'] = [
                'label'  => trans_cms('cms::app.add_post'),
                'url'    => route('admin.posts.create', ['type' => 'posts', 'page' => $row->id]),
                'target' => '_blank',
            ];
        }

        return $data;
    }

    public function query($data): Builder
    {
        /**
         * @var Builder $query
         */
        $query = $this->makeModel()->with(['taxonomies']);
        $query->where(['type' => $this->postType['key']]);
        $data['q']    = Arr::get($data, 'keyword');
        $data['type'] = $this->postType['key'];

        if ($data['q'] == "") {
            if ($data['type'] == "pages" && !isset($data['pages'])) {
                $query->where('json_metas->parent', "");
            }
        }
        if (empty($data['status'])) {
            $query->where('status', '!=', 'trash')
                ->where('status', '!=', 'preview');
        }

        if (isset($data['status'])) {
            if ($data['status'] == "scheduled") {
                $query->where('date', '>=', Carbon::now())
                    ->where('status', "publish");
                $data['status'] = "publish";
            } elseif ($data['status'] == "publish") {
                $query->where('date', '<=', Carbon::now())
                    ->where('status', "publish");
            }
        }
        if (isset($data['pages'])) {
            if ($data['type'] == "pages") {
                $query->where('json_metas->parent', $data['pages']);
            } else {
                $query->whereJsonContains('json_metas->pages', $data['pages']);
            }
        }

        if (isset($data['authors'])) {
            $query->whereJsonContains('json_metas->authors', $data['authors']);
        }

        if ($data['type'] === "landing_pages") {
            $query->whereNull('json_metas->parent');
        }
        $query->where('lang', Lang::locale());
        $query->whereFilter($data);
        $query->orderBy('display_order', 'asc')
            ->orderBy('date', 'desc')
            ->orderBy('title', 'asc');
        return $query;
    }

    public function rowActionsFormatter($value, $row, $index): string
    {
        $title_table = $row->{$row->getFieldName()};
        if (isset($row->subtitle) && $row->subtitle != "") {
            $title_table = $row->{$row->getFieldName()} . ' / ' . $row->subtitle;
        }
        return view(
            'cms::backend.items.datatable_item',
            [
                'value'   => $title_table,
                'row'     => $row,
                'actions' => $this->rowAction($row),
                'editUrl' => $this->currentUrl . '/' . $row->id . '/edit',
            ]
        )
            ->render();
    }

    public function titleDetailFormater($index, $row, $taxonomies, $postTypeTaxonomies): string
    {
        return view(
            'cms::backend.items.quick_edit',
            compact('index', 'row', 'taxonomies', 'postTypeTaxonomies')
        )->render();
    }

    protected function makeModel()
    {
        return app($this->postType['model']);
    }
}
