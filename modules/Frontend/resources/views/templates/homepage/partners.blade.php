<section class="section mv-50">

    <div class="container text-center  ">

        <div class="section-info center">
            @if (!empty($part->title))
                <div class="section--title ">{{ $part->title }}
                </div>
            @endif
            @if (!empty($part->subtitle))
                <h3 class="section--subtitle">{{$part->subtitle}}
                </h3>
            @endif

        </div>
        <div class="section-content">

            <div class="row d-flex justify-content-center ">
                @foreach ($part->images as $img )

                <div class="col-md-4 d-flex justify-content-center ">
                    <div class="partner-img"> <img src="{{ upload_url($img) }}" alt="client image">
                    </div>

                </div>
                @endforeach

                {{-- <div class="col-md-4 d-flex  justify-content-center  ">
                    <div class="partner-img"><img src="{{ asset('front/assets/images/p2.png') }}" alt="client image">
                    </div>
                </div> --}}

            </div>

        </div>
    </div>


</section>
