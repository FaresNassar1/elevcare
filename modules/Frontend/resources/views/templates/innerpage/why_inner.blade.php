
@php
        $why = $content->json_metas['repeater'];

@endphp

<div class="row d-flex   ">
    @foreach ($why as $item)



        <div class="col-md-4 d-flex justify-content-center ">
            <div class="why-us">
                <div><img src="{{ upload_url($item['image']) }}" alt="why-us-image"></div>
                <div class="why-us-info">
                    <div class="why-us--title">
                        {{ $item['title'] }}
                    </div>
                    <div class="why-us--desc">
                        {{ $item['description'] }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach


</div>
