@php

    $subpage = get_sub_pages($content->id);


@endphp
@foreach ($subpage as $item)


    <div class="section mv-50 center">
        <div class="container   ">
            <div class="section-info">
                @if (!empty($item->subtitle))
                    <div class="section--title ">{{ $item->subtitle }}
                    </div>
                @endif
                @if (!empty($item->title))
                    <h3 class="section--subtitle"> {{ $item->title }}
                    </h3>
                @endif
                @if (!empty($item->description))
                    <div class="section--desc">{{ $item->description }}
                    </div>
                @endif
            </div>
            <div class="section-content">

                <div class="row justify-content-center">

                    @if (!empty($template)||!empty($repeater))
                    @include('frontend::templates.innerpage.' . $item->json_metas['ctemplate'], [
                        'content' =>$item
                    ])
                @endif

                </div>
                @if ($item->json_metas['ctemplate']=='product_inner')
                <a class="btn btn-primary inner-btn" href="">تواصل معنا
                </a>

                @endif

            </div>
        </div>
    </div>
@endforeach
