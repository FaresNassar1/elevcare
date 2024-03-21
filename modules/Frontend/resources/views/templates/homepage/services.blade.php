<style nonce="{{ csp_nonce() }}">
    .bg-services {
        background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3)), url('{{ upload_url($part['thumbnail']) }}');

    }
</style>
@php
    $listService = $part->json_metas['repeater'];
@endphp
<section class="section pv-50  bg-services">

    <div class="container">
        <div class="section-info white">
            @if (!empty($part->title))
                <h2 class="section--subtitle  "> {{$part->title}}
                </h2>
            @endif
            {{-- {{dd($part)}} --}}
            <ul class="services-list">
                @foreach ($listService as $item )
                <li><img  src="{{ upload_url($item['image']) }}" alt="Icon 1"> {{$item['title']}}
                </li>
                @endforeach

            </ul>
        </div>
    </div>

    <img class="image1" src="{{upload_url($part->images[0])}}" alt="services image">
</section>
