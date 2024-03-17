<div class="row align-items-center">
    @if(!$page->getMeta('hide_title') or !empty($page->content))
        <div class="{{ $column }}">
            @if(!$page->getMeta('hide_title'))
                <div class="landing-section-title">{{ $page->title }}</div>
            @endif
            @if(!empty($page->content))
                <div class="landing-section-content">
                    <div class="landing-section--desc">{!! $page->content !!}</div>
                </div>
            @endif
        </div>
    @endif
    @if(!empty($page->thumbnail))
        <div class="{{ $column }}">
            <div class="landing-section-img">
                @php
                    $attr['alt'] = get_image_meta($page->getThumbnail(), $page->title)['alt'];
                @endphp
                {!! lazyloadImage($page->thumbnail,'690px','690px',$attr,false) !!}
            </div>
        </div>
    @endif
</div>
