<section class="section">
    <div class="owl-main owl-carousel owl-theme owl-dots-style">
        {{-- {{dd($slide)}} --}}

        @foreach ($slide as $item)
            <div class="item">
                <div class="main-slider-item">
                    <img src="{{ upload_url($item['image']) }}" alt="">
                    <div class="container_slider_title">
                        <div class="container">
                            @if (!empty($item['title']))
                                <h2 class="main-slider--title">
                                    {{ $item['title'] }}

                                </h2>
                            @endif
                        </div>
                    </div>
                    </div>
                </div>
        @endforeach

    </div>
</section>
