@extends('frontend::layouts.app')
@section('title',get_page_title($main_post->title,$metas['meta_title_keywords']))
@section('metas')
    @include('frontend::Components.meta.meta', ['metas' => $metas])
@endsection

@section('content')
    <div class="inner-page">
        <div class="inner-body">
            <div class="container">
                <div class="inner-body-content">
                    @if (!empty($main_post->title))
                        <div class="inner-body-title">
                            {!! $main_post->title !!}
                            post
                        </div>
                    @endif
                    @if (!empty($main_post->subtitle))
                        <div class="inner-body-subtitle">
                            {!! $main_post->subtitle !!}
                        </div>
                    @endif

                    @if (!empty($main_post->content))
                        <div class="inner-body-desc" id="content-form-builder">
                            {!! $main_post->content !!}
                        </div>
                    @endif
                    {{-- {{ paginate_links($pagination_page, 'frontend::partials.pagination') }} --}}
                </div>
            </div>
        </div>
    </div>

@endsection
