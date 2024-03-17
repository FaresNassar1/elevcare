@extends('frontend::layouts.landing_page')
@section('title', get_page_title($main_post->title, $metas['meta_title_keywords']))
@section('metas')
    @include('frontend::Components.meta.meta', ['metas' => $metas])
@endsection

@section('content')
    @php
        $formScriptAppended = false;
    @endphp
    @foreach ($sub_pages as $page)
        @php
            $classes = 'landing-section';
            $bg_color = $page->getMeta('background_color');
            $bg_image = $page->getMeta('background_image');
            if (!empty($bg_color) and $bg_color != '#000000' or !empty($bg_image)) {
                $classes .= ' section-p white';
                if (!empty($bg_image)) {
                    $classes .= ' lazyload bg-image';
                }
            } else {
                $classes .= ' section-m';
            }

            $template = $page->getMeta('ctemplate');
            $column = 'col-12';
            if ((!empty($page->thumbnail) and !empty($page->content) and $template == 'plain_content') or !empty($page->thumbnail) and !empty($page->getMeta('form')) and $template == 'form_block') {
                $column = 'col-md-6';
            } else {
                $classes .= ' center';
            }
        @endphp


        <section id="section-{{ $page->id }}" class="{{ $classes }}"
                 @if (!empty($bg_image)) data-bg="{{ upload_url($bg_image) }}" @endif>
            <div class="container">
                @include('frontend::templates.landing_page.' . $template)
            </div>
        </section>

        @if (!empty($bg_color) and $bg_color != '#000000')
            <style nonce="{{ csp_nonce() }}">
                #section-{{ $page->id }}                               {
                    background-color: {{ $bg_color }};
                }
            </style>
        @endif

        @if(!empty($page->getMeta('form')) and !$formScriptAppended)
            {{ Vite::useBuildDirectory('front') }}
            @vite(['modules/Frontend/resources/assets/js/form-builder.js'])
            @php
                $formScriptAppended = true;
            @endphp
        @endif
    @endforeach
@endsection
