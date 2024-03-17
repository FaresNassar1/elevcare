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
@if(!empty($page->getMeta('repeater')))
    <div class="landing-section-content">
        <div class="row">
            @foreach($page->getMeta('repeater') as $box)
                @if(!empty($box['title']) and !empty($box['description']))
                    <div class="col-md-6">
                        <div class="faq-item">
                            <div class="faq-item-head">{{ $box['title'] }}</div>
                            <div class="faq-item-content" style="display: none">
                                {{ $box['description'] }}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
