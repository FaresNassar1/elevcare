<div class="row">
    @if(!$page->getMeta('hide_title'))
        <div class="{{ $column }}">
            @if(!$page->getMeta('hide_title'))
                <div class="landing-section-title">{{ $page->title }}</div>
            @endif
            @if($page->getMeta('form'))
                <div class="landing-section-content" id="content-form-builder-{{ $page->getMeta('form') }}">
                    {{ 'formBuilder2Yy#'.$page->getMeta('form') .'!!' }}
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
                {!! lazyloadImage($page->thumbnail,'540px','540px',$attr,false) !!}
            </div>
        </div>
    @endif
</div>
