@php
    $productItems = $part->json_metas['repeater'];
   $posts = get_page_posts($part->id);

@endphp
{{-- {{dd($posts)}} --}}
<section class="section mv-50 center">
    <div class="container   ">
        <div class="section-info">
            @if (!empty($part->title))
                <div class="section--title ">{{ $part->title }}
                </div>
            @endif
            @if (!empty($part->subtitle))
                <h3 class="section--subtitle"> {{ $part->subtitle }}
                </h3>
            @endif
            @if (!empty($part->description))
                <div class="section--desc">{{ $part->description }}
                </div>
            @endif
        </div>
        <div class="section-content">

            <div class="row justify-content-center">

                @foreach ($posts as $item)
                    <div class="col-md-3 d-flex  ">
                        <div class="product">
                            <div class="product-img"><img src="{{ upload_url($item->thumbnail) }}" alt="product-image">
                            </div>
                            <div class="product-info">
                                <div class="product--title">{{ $item->title }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            @if (!empty($part->external_link))
                <a class="btn btn-primary mt-3 " href="{{ $part->external_link }}">تواصل معنا </a>
            @endif
        </div>
    </div>


</section>
<div id="f" class="call">
    <div class="call-info">
        <div class="whats"><span class="icon-whatsapp"></span></div>
        <div class="call-text">كن شريكنا</div>
    </div>
</div>

