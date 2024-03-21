
@php
    $posts=get_page_posts($content->id);
@endphp
<div class="row justify-content-center">
@foreach ($posts as $item)

    <div class="col-md-4 d-flex">
        <div class="product">
            <div class="product-img"><img src="{{ upload_url($item->thumbnail) }}" alt="product-image">
            </div>
            <div class="product-info">
                <div class="product--title">{{ $item['title'] }}
                </div>
                <div class="product--subtitle">{{ $item['subtitle'] }}
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
