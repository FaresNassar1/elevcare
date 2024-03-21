@php
    $whyitem = $part->json_metas['repeater'];
@endphp
<section class="section mv-50 center">

    <div class="container  ">

        <div class="section-info ">
            @if (!empty($part->title))
                <div class="section--title ">{{ $part->title }}

                </div>
            @endif
            @if (!empty($part->subtitle))
                <h3 class="section--subtitle">{{ $part->subtitle }}
                </h3>
            @endif
            @if (!empty($part->description))
                <div class="section--desc ">{{ $part->description }}
                </div>
            @endif
        </div>
        <div class="section-content">

            <div class="row d-flex  justify-content-center ">
                @foreach ($whyitem as $item)
                    <div class="col-md-2 d-flex justify-content-center ">
                        <div class="why-us">
                            <div><img src="{{ upload_url($item['image']) }}" alt="why-us-image"></div>
                            <div class="why-us-info">
                                <div class="why-us--title">
                                    {{ $item['title'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>



        </div>
    </div>


</section>
