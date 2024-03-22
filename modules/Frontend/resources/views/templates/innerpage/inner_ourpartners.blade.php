@php
$posts = get_page_posts($content->id);

@endphp
{{-- {{dd($posts)}} --}}

<section class="section mv-50">
    <div class="container text-center  ">
        <div class="section-info center">
            @if (!empty($content->subtitle))
                <div class="section--title ">{{$content->subtitle}}
                </div>
            @endif
            @if (!empty($content->title))
                <h3 class="section--subtitle">{{ $content->title }}
                </h3>
            @endif

        </div>
        <div class="section-content">

            <div class="row d-flex justify-content-center ">
                @foreach ($posts as $partner)
                    <div class="col-md-4 d-flex justify-content-center ">
                        <div class="partner-img"> <img src="{{ upload_url($partner['thumbnail']) }}" alt="client image">
                            <div class="partner-title">
                                {{ $partner['title'] }}
                            </div>
                        </div>

                    </div>
                @endforeach



            </div>
            <a class="btn btn-primary mt-2 " href="">مهتمة بمنتجاتهم
?            </a>
        </div>
    </div>


</section>
