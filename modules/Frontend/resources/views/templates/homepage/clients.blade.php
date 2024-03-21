@php
    $clientItem = $part->json_metas['repeater'];
@endphp
<section class="section pv-50 center bg-section-gray">

    <div class="container">
        <div class="section-info ">
            @if (!empty($part->title))
                <div class="section--title ">{{ $part->title }}
                </div>
            @endif
            @if (!empty($part->title))
                <h3 class="section--subtitle">{{ $part->subtitle }}
                </h3>
            @endif

        </div>
        @if (!empty($clientItem))

        <div class="section-content">
            <div class=" owl-carousel owl-client  owl-theme owl-dafault owl-loaded owl-drag">

                @foreach ($clientItem as $item)
                    <div class="item d-flex justify-content-center ">
                        <div class="client-item ">
                            <img src="{{ upload_url($item['image']) }}" alt="client image">
                            <div class="client">
                                <div class="client--name ">{{ $item['title'] }}
                                </div>

                                <h5 class="client-city">{{ $item['description'] }}

                                </h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="btn btn-primary mt-3 " href="">تواصل معنا </a>
        </div>
@endif
    </div>

</section>
