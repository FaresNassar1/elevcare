<section class="section bg-light-gray">
    <div class="container-fluid">
        <div class="row double no-padding">
            <div class="col-md-6 section-p offset-left">
                <div class="section-head">
                    @if(!empty($block->subtitle))
                        <h4 class="section--subtitle">{{ $block->subtitle }}</h4>
                    @endif
                    @if(!empty($block->title))
                        <h2 class="section--title">{{ $block->title }}</h2>
                    @endif
                </div>
                @if(!empty($block->content))
                    <div class="section--desc">{!! $block->content !!}</div>
                @endif
                @if(!empty($block->external_link))
                    @php
                        $more_label = __('messages.read_more');
                        if(!empty($block->latlng)){
                            $more_label = $block->latlng;
                        }
                    @endphp
                    <a href="{{ $block->external_link }}" title="{{ $more_label }}"
                       class="btn btn-primary mt-15px">{{ $more_label }}</a>
                @endif
            </div>
            <div class="col-md-6 d-flex">
                <div class="section-full-image">
                    @php
                        $attr['alt'] = get_image_meta($block->getThumbnail(), $block->title)['alt'];
                    @endphp
                    {!! lazyloadImage($block->thumbnail,'782px','420px',$attr,false) !!}
                </div>
            </div>
        </div>
    </div>
</section>
