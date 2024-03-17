@if(!$page->getMeta('hide_title') or !empty($page->content))
    @if(!$page->getMeta('hide_title'))
        <div class="landing-section-title">{{ $page->title }}</div>
    @endif
    @if(!empty($page->content))
        <div class="landing-section-content">
            <div class="landing-section--desc">{!! $page->content !!}</div>
        </div>
    @endif
@endif
@if(!empty($page->getMeta('youtube_url')))
    <div class="landing-section-content">
        <div class="video-w" data-gal-id="video-{{ $page->id }}">
            <a href="{{ $page->getMeta('youtube_url') }}" title="{{ $page->title }}" class="video">
                @php
                    $attr['alt'] = $page->title;
                @endphp
                {!! lazyloadImage(getYoutubeImage($page->getMeta('youtube_url')),'1140px','500px',$attr,false) !!}
                <i class="icon-play-button"></i>
            </a>
        </div>
    </div>
@endif
