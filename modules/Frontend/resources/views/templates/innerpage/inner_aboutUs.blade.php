@php
    $aboutItem = $content->json_metas['repeater'];
@endphp
{{-- {{dd()}} --}}
<section class="section mv-50">
<div class="container">
@foreach ($aboutItem as $item)
<div class="about-content mv-50">
<div class="about--title">{{$item['title']}}</div>
<div class="about-desc">{{$item['description']}}</div>
</div>
@endforeach

</div>

</section>

