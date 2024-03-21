<style nonce="{{ csp_nonce() }}">
    .section-bg-img {
        background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.353)), url('{{ upload_url($part['thumbnail']) }}');

    }
</style>
@php
    $listcontact = $part->json_metas['repeater'];
@endphp
<section class=" section mv-50  section-bg-img">
    <div class="container d-flex justify-content-between  align-items-center ">
        <div class="contact-form ">
            <form>

                <h2>كن شريكًا معنا
                </h2>
                <input type="text " id="name " name="name " required placeholder="ادخل اسمك ">

                <input type="email " id="email " name="email " required placeholder="البريد الالكتروني ">

                <textarea id="message " name="message " rows="2 " required placeholder="اكتب رسالة "></textarea>

                <button style="color: white" class="btn btn-primary " type="submit ">اتصل بنا الآن</button>
            </form>
        </div>

        <div class="section-info white ms-40">
            @if (!empty($part->title))
                <h2 class="section--subtitle  ">
                    {{ $part->title }}
                </h2>
            @endif
            @if (!empty($part->description))
                <div class="section--desc white ">
                    {{ $part->description }}
                </div>
            @endif
            @if (!empty($part->subtitle))
                <div class="section-list-title">{{$part->subtitle}}
                </div>
            @endif
            <ul class="section-list">
                @foreach ($listcontact as $item)
            <li><img  src="{{ upload_url($item['image']) }}" alt="Icon">{{$item['title']}}</li>
                @endforeach

            </ul>
        </div>





    </div>
</section>
