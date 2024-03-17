@extends('frontend::layouts.app')

@section('content')

    <h1 id="homepage-title">{{ get_config("sitename_".app()->getLocale()) }}</h1>
    <style nonce="{{ csp_nonce() }}">#homepage-title {
            display: none;
        }</style>

        @include('frontend::templates.homepage.main_slider')
        @include('frontend::templates.homepage.products_and_services')
        @include('frontend::templates.homepage.services')
        @include('frontend::templates.homepage.why_us')
        @include('frontend::templates.homepage.clients')
        @include('frontend::templates.homepage.partners')
        @include('frontend::templates.homepage.contact')


    @if(!empty($homepageBlocks))
        @foreach($homepageBlocks as $block)
            @if (!empty($block->json_metas['ctemplate']))
                @include('frontend::templates.homepage.'.$block->json_metas['ctemplate'],['block'=>$block])
            @endif
        @endforeach
    @endif
@endsection
