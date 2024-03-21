@extends('frontend::layouts.app')
@section('title', get_page_title($main_post->title, $metas['meta_title_keywords']))
@section('metas')
    @include('frontend::Components.meta.meta', ['metas' => $metas])
@endsection
@section('content')
    <div class="inner-page">
        <div class="inner-body">
            @if (!empty($main_post->title))
                <div class="inner-body-title">
                    @include('frontend::partials.header-inner-page', [
                        'title' => $main_post->title,
                        'img' => $main_post->thumbnail,
                    ])

                </div>
            @endif
                <div class="inner-body-content">

                    {{-- @if (!empty($main_post->subtitle))
                        <div class="inner-body-subtitle">
                            {!! $main_post->subtitle !!}
                        </div>
                    @endif --}}
<div class="container"> @if (!empty($main_post->content))
                        <div class="inner-body-desc" id="content-form-builder">
                            {!! $main_post->content !!}
                        </div>
                    @endif
</div>

                    @if (!empty($template))
                        @include('frontend::templates.innerpage.' . $main_post->json_metas['ctemplate'], [
                            'content' => $main_post,
                        ])
                    @endif
                </div>
        </div>
    </div>

@endsection
