
@php
    $posts = get_page_posts($part->id);

@endphp
<section class="section mv-50 center">

    <div class="container   ">

        <div class="section-info ">
            @if (!empty($part->title))
                <div class="section--title ">{{ $part->title }}
                </div>
            @endif
            @if (!empty($part->subtitle))
                <h3 class="section--subtitle">{{$part->subtitle}}
                </h3>
            @endif
            @if (!empty($part->description))
                <h3 class="section--desc">{{$part->description}}
                </h3>
            @endif

        </div>
        <div class="section-content">

            <div class="row d-flex justify-content-center ">
                @foreach ($posts as $item )
                <div class="col-md-4 d-flex justify-content-center ">
                    <div class="partner-img"> <img src="{{ upload_url($item["thumbnail"]) }}" alt="client image">
                    </div>

                </div>
                @endforeach



            </div>

        </div>
    </div>


</section>
