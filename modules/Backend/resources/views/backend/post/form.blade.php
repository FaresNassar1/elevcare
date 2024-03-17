@extends('cms::layouts.editor')

@section('buttons')
    <div class="btn-group">
        <button type="submit" class="btn btn-success px-5">
            <i class="fa fa-save"></i> {{ trans_cms('cms::app.save') }}
        </button>
        <button type="submit" data-type="new" data-create="true" class="btn btn-primary px-5">
            <i class="fa fa-save"></i> {{ trans_cms('cms::app.save_and_create') }}
        </button>
        <a href="" id="preview-post" data-id="0" class="btn btn-info px-5">
            <i class="fa fa-eye"></i> {{ trans_cms('cms::app.preview') }}
        </a>
        <button type="button" class="btn btn-warning cancel-button px-3">
            <i class="fa fa-refresh"></i> {{ trans_cms('cms::app.reset') }}
        </button>
    </div>
@endsection

@section('content')
    @php
        $type = $setting['key'];
        if ($type === "landing_pages"){
            $isRoot = !isset($model->json_metas['parent']);
            $templates = Juzaweb\CMS\Facades\ThemeLoader::getRegister(jw_current_theme(), 'landing_pages');
            $templateFields = [];
            if($model->getMeta('ctemplate')){
                $templateFields = $templates[$model->getMeta('ctemplate')]['fields'];
            }
        }
    @endphp
    <div class="row">
        <div class="col-md-9">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab1">General</a>
                </li>
                @if($type !== 'landing_pages' or $isRoot)
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2">SEO</a>
                    </li>
                @endif
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div id="tab1" class="tab-pane active">
                    @component('cms::components.card', [
                        'label' => trans_cms('cms::app.information'),
                    ])
                        <input type="hidden" class="post_lang" value="{{ $model->lang }}">

                        <div class="row mb-2">
                            <div class="col-md-12">
                                {{ Field::text($model, 'title', [
                                    'required' => true,
                                    'class' => empty($model->slug) ? 'generate-slug' : '',
                                ]) }}
                            </div>
                        </div>

                        @if($type !== 'landing_pages' or !$isRoot)
                            @php
                                $subtitleLabel = trans_cms('cms::app.subtitle');
                                if($type === 'landing_pages'){
                                    $subtitleLabel = trans_cms('cms::app.menu_title');
                                }
                            @endphp
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    {{ Field::text($model, 'subtitle',['label'=>$subtitleLabel]) }}
                                </div>
                            </div>
                        @endif
                        @if($type !== 'landing_pages' or in_array('external_link',$templateFields))
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    {{ Field::text($model, 'external_link') }}
                                </div>
                            </div>
                        @endif
                        @if($type !== 'landing_pages' or in_array('latlng',$templateFields))
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    {{ Field::text($model, 'latlng') }}
                                </div>
                            </div>
                        @endif

                        @if($type !== 'landing_pages' or in_array('editor',$templateFields))
                            @include($editor)
                        @endif
                        @if($type !== 'landing_pages' or in_array('text',$templateFields))
                            {{ Field::editor($model, 'text') }}
                        @endif
                    @endcomponent

                    @if($type !== 'landing_pages' or in_array('items_repeater',$templateFields))
                        @component('cms::components.card', [
                            'label' => trans_cms('cms::app.items_repeater'),
                        ])
                            @include($repeater)
                        @endcomponent
                    @endif

                    @if($type === 'landing_pages' and $isRoot)
                        @component('cms::components.card', [
                            'label' => trans_cms('cms::app.blocks'),
                        ])
                            @include($blocks)
                        @endcomponent
                    @endif

                    @component('cms::components.card')
                        @php
                            $metas = collect_metas($setting->get('metas'))->where('sidebar', false)->where('visible', true)->toArray();
                        @endphp

                        @foreach ($metas as $name => $meta)
                            @if($type !== "landing_pages" or (isset($meta['show_in_root']) and $meta['show_in_root'] and $isRoot) or (isset($meta['show_in_child']) and $meta['show_in_child'] and !$isRoot))
                                @php
                                    $meta['name'] = "meta[{$name}]";
                                    $meta['data']['value'] = $model->getMeta($name);
                                    if ($meta['type'] === 'checkbox'){
                                        $meta['data']['checked'] = $model->getMeta($name)?1:0;
                                    }
                                @endphp
                                @if($type !== "landing_pages" or !isset($meta['show_if_visible']) or ($meta['show_if_visible'] and in_array($name,$templateFields)))
                                    {{ Field::fieldByType($meta) }}
                                @endif
                            @endif
                        @endforeach

                        {{ Field::render($setting->get('fields', []), $model) }}
                    @endcomponent

                    @do_action('post_type.' . $postType . '.form.left', $model)
                </div>

                @if($type !== 'landing_pages' or $isRoot)
                    <div id="tab2" class="tab-pane fade">
                        @if (!isset($seo_meta))
                            @do_action('post_types.form.left', $model)
                        @else
                            @php
                                $seo_meta->model = $model;
                            @endphp
                            @do_action('post_types.form.seo_form_create', $seo_meta)
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-3">
            @if (isset($model->sub_pages_count))
                <div class="row">
                    <div class="col-md-6">
                        @component('cms::components.card')
                            <a href="{{ route('admin.posts.index', ['pages', 'parent' => $model->id]) }}"
                               class="font-size-18 font-weight-bold text-center text-primary">
                                <div>{{ trans_cms('cms::app.sub_pages') }}</div>
                                <div>{{ $model->sub_pages_count }}</div>
                            </a>
                        @endcomponent
                    </div>
                    <div class="col-md-6">
                        @component('cms::components.card')
                            <a href="{{ route('admin.posts.index', ['posts', 'pages' => $model->id]) }}"
                               class="font-size-18 font-weight-bold text-center text-primary">
                                <div>{{ trans_cms('cms::app.posts') }}</div>
                                <div>{{ $model->posts_count }}</div>
                            </a>
                        @endcomponent
                    </div>
                </div>
            @endif

            @component('cms::components.card', [
                'label' => trans_cms('cms::app.side_bar'),
            ])
                {{ Field::select($model, 'lang', [
                    'options' => $langs,
                    'class' => 'lang-switch',
                ]) }}

                <input type="hidden" name="show_sitemap" value="0">

                {{ Field::checkbox(trans_cms('cms::app.show_sitemap'), 'show_sitemap', [
                    'value' => '1',
                    'checked' =>
                        (isset($model['show_sitemap']) && $model['show_sitemap'] == 1) || !isset($model['show_sitemap']) ? true : false,
                ]) }}

                @if (isset($related_ids))
                    @foreach ($related_ids as $lang => $id)
                        <input type="hidden" class="related_ids" value="{{ $id }}" id="{{ $lang }}">
                    @endforeach
                @endif

                {{ Field::slug($model, 'slug') }}
                @if ($model->oldslug != null && $model->oldslug != $model->slug)
                    <span>{{ trans_cms('cms::app.oldslug') }} {{ $model->oldslug }}</span>
                @endif

                {{ Field::select($model, 'status', ['options' => $model->getStatuses(),]) }}

                <div class="form-group" @if($type === 'landing_pages' and $isRoot) style="display: none" @endif>
                    <label class="col-form-label">{{ trans_cms('cms::app.display_order') }}</label>
                    <input type="number" name="display_order" class="form-control"
                           value="{{ $model->display_order ?? 100 }}"/>
                </div>

                <div class="form-group">
                    <label class="col-form-label">{{ trans_cms('cms::app.start_date') }}</label>
                    <input type="datetime-local" name="date" class="form-control"
                           value="{{ $date ? $date : now()->format('Y-m-d\TH:i') }}">
                </div>
                <div class="form-group">
                    <label class="col-form-label">{{ trans_cms('cms::app.end_date') }}</label>
                    <input type="datetime-local" name="end_date" class="form-control"
                           value="{{ $model->end_date ? $model->end_date : '' }}">
                </div>


                @if($type !== 'landing_pages' or in_array('thumbnail',$templateFields))
                    {{ Field::image($model, 'thumbnail') }}
                @endif

                @php
                    $metas = collect_metas($setting->get('metas'))->where('sidebar', true)->where('visible', true)->toArray();
                @endphp

                @foreach ($metas as $name => $meta)
                    @if($type !== "landing_pages" or (isset($meta['show_in_root']) and $meta['show_in_root'] and $isRoot) or (isset($meta['show_in_child']) and $meta['show_in_child'] and !$isRoot))
                        @php
                            $meta['name'] = "meta[{$name}]";
                            $meta['data']['value'] = $model->getMeta($name);
                            if ($meta['type'] === 'checkbox'){
                                $meta['data']['checked'] = $model->getMeta($name)?1:0;
                            }
                        @endphp
                        @if(isset($meta['show_in_child']) and $meta['show_in_child'] and !$isRoot)
                            <div style="display: none">
                                @endif
                                {{ Field::fieldByType($meta) }}
                                @if(isset($meta['show_in_child']) and $meta['show_in_child'] and !$isRoot)
                            </div>
                        @endif
                    @endif
                @endforeach
                @if(isset( $data['forms']) and ($type !== 'landing_pages' or in_array('form_block',$templateFields)))
                {{ Field::select($model, 'meta[form]', ['label'=>trans_cms('cms::app.insert_form'),'options' => $data['forms'],'value'=>$model->getMeta('form')]) }}
                @endif
            @endcomponent
            @if($type !== 'landing_pages' or in_array('images',$templateFields))
                {{ Field::images($model, 'images') }}
            @endif
            @if($type !== 'landing_pages' or in_array('files',$templateFields))
                <div class='multi-files'>
                    {{ Field::images($model, 'files') }}
                </div>
            @endif
            @do_action('post_types.form.right', $model)

            @do_action('post_type.' . $postType . '.form.right', $model)
        </div>
    </div>

@endsection
