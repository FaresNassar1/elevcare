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
@if(!empty($page->images))
    <div class="gallery" data-gal-id="{{ $page->id }}">
        <div class="row">
            @foreach($page->images as $key=>$image)
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="{{ upload_url($image) }}" title="{{ $page->title }}" class="gallery-item">
                        @php
                            $attr['alt'] = $page->title ;
                        @endphp
                        {!! lazyloadImage(upload_url($image),'280px','250px',$attr,false) !!}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
