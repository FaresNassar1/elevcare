@php
    $productItems = $part->json_metas['repeater'];
@endphp
<section class="section mv-50">
    <div class="container text-center  ">
        <div class="section-info center">
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

                @foreach ($productItems as $item)
                    <div class="col-md-2 d-flex   ">
                        <div class="product">
                            <div class="product-img"><img src="{{ upload_url($item['image']) }}" alt="product-image">
                            </div>
                            <div class="product-info">
                                <div class="product--title">{{ $item['title'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            @if (!empty($part->external_link))
                <a class="btn btn-primary mt-3 " href="{{ $part->external_link }}">تسجيل الدخول</a>
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

