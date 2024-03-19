@extends('frontend::layouts.app')

@section('content')
    <h1 id="homepage-title">{{ get_config('sitename_' . app()->getLocale()) }}</h1>
    <style nonce="{{ csp_nonce() }}">
        #homepage-title {
            display: none;
        }
    </style>

    @include('frontend::templates.homepage.main_slider', ['slide' => $mainSlider])
    {{-- @include('frontend::templates.homepage.products_and_services')
    @include('frontend::templates.homepage.services')
    @include('frontend::templates.homepage.partners')
    @include('frontend::templates.homepage.contact') --}}
    {{-- @include('frontend::templates.homepage.clients') --}}



    @foreach ($homepages as $homepage)
        @if (!empty($homepage))
            @if ($homepage->json_metas['ctemplate'] != null)
                @include('frontend::templates.homepage.' . $homepage->json_metas['ctemplate'], [
                    'part' => $homepage,
                ])
            @endif
        @endif
    @endforeach
@endsection
