<section class="section  mv-50">
    <div class="container">
        <div class="row">

            <div class="col-md-6 ">
                <div class="section-info ">
                    @if(!empty($part->title))
                    <h2 class="section--title    ">{{$part->title}}</h2>
                    @endif
                    @if(!empty($part->subtitle))
                    <h3 class="section--subtitle ">{{$part->subtitle}}</h3>
                    @endif
                    @if(!empty($part->content))
                    <div class="section--desc">
                        {!!$part->content!!}
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="section-img">
                    @if(!empty($part->thumbnail))
                    <img src="{{ upload_url($part->thumbnail) }}" alt="elevcare about us " />
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
