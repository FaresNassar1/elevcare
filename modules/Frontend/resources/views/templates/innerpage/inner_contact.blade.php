@php

    $subpage = get_sub_pages($content->id);

@endphp
@foreach ($subpage as $item)
    @php
        $contactItem = $item->json_metas['repeater'];

    @endphp


    <div class=" section pv-50  bg-section-gray">
        <div class="container   ">
            <div class="row pv-50 justify-content-evenly ">
                <div class="contact-form col-md-6">
                    <form>
                        <div class="section--title form-title">نحن هنا من أجلك


                        </div>
                        <h2> تواصل معنا
                        </h2>
                        <input type="text " id="name " name="name " required placeholder="ادخل اسمك ">

                        <input type="email " id="email " name="email " required placeholder="البريد الالكتروني ">

                        <textarea id="message " name="message " rows="2 " required placeholder="اكتب رسالة "></textarea>

                        <button style="color: white" class="btn btn-primary " type="submit ">ارسال</button>
                    </form>
                </div>

                <div class="section-info col-md-5 ">
                    @if (!empty($item->title))
                        <h2 class="section--subtitle  ">
                            {{ $item->title }}
                        </h2>
                    @endif
                    @if (!empty($part->subtitle))
                        <div class="section-list-title">{{ $part->subtitle }}
                        </div>
                    @endif
                    <ul class="section-list">
                        @foreach ($contactItem as $item)
                            <div class="section-list--desc">{{ $item['description'] }}</div>
                            <li><img src="{{ upload_url($item['image']) }}" alt="Icon">{{ $item['title'] }}</li>
                        @endforeach

                    </ul>
                </div>

            </div>
        </div>

    </div>
@endforeach
<div class="location ">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13569.845638135374!2d35.239862!3d31.757899!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1503284f34a1bcb7%3A0x2efae3e527837570!2z2KfZhNiz2YjYp9it2LHYqSDYp9mE2LrYsdio2YrYqdiMINin2YTZgtiv2LM!5e0!3m2!1sar!2sus!4v1710992961735!5m2!1sar!2sus"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
