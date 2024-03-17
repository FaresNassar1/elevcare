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
    @php
        $wrapperClasses = 'row justify-content-center';
        $itemClasses = 'col-md-4 d-flex';
        if($page->getMeta('is_slider')){
            $wrapperClasses = 'owl-boxes owl-carousel owl-theme owl-default';
            $itemClasses = 'item';
        }
    @endphp
    <div class="landing-section-content">
        <div class="{{ $wrapperClasses }}">
            @foreach($page->getMeta('repeater') as $box)
                @if(!empty($box['title']))
                    <div class="{{ $itemClasses }}">
                        <div class="box">
                            @if(!empty($box['image']))
                                @php
                                    $attr['alt'] = $box['title'];
                                @endphp
                                <div class="box-image">
                                    {!! lazyloadImage($box['image'],'60px','60px',$attr,false) !!}
                                </div>
                            @endif
                            <div class="box-title">{{ $box['title'] }}</div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
