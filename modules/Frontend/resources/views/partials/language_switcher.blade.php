@if(@$main_post->single_lang == 0)
    @foreach ($locales as $local_key => $locale_name)
        @if ($local_key === $current_locale)
            @continue
        @endif

        @php
            $routeParams = ['locale' => $local_key];
            $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();
            $navLink = '';
            if (isset($main_post) || isset($albums) || isset($events)) {
                if (isset($albums)) {
                    $routeParams['slug'] = $main_slug;
                } elseif (isset($events)) {
                    unset($routeParams['slug']);
                } else {
                    $routeParams['slug'] = path_link($main_post['path']);
                }
            }
            if (Route::has($currentRoute)) {
                $navLink = route($currentRoute, $routeParams);
            }
        @endphp

        <li><a href="{{ $navLink }}" title="{{ $locale_name['name'] }}" class="item">{{ $locale_name['key'] }}</a></li>
    @endforeach
@endif
