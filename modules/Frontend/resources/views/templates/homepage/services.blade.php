<style nonce="{{ csp_nonce() }}">
    .bg-services {
        position: relative;
        background-image: linear-gradient(rgba(0, 0, 0, 0.33), rgba(0, 0, 0, 0.353)), url('{{ asset('front/assets/images/blure.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 40vh;
        padding: 20px; /* Add padding to the container for spacing */
    }




    .services-list {
        list-style-type: none; /* Remove default list styles */
        padding: 0;
    }

    .services-list li {
        margin-bottom: 20px;
        font-size: 20px
    }


    .image1 {
        position: absolute;
    left: 5%;
    top: -20px;
    height: 500px;
    filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.309));
    }

</style>

<section class="section mv-50 white">
    <div class="bg-services">
        <div class="container">
            <div class="section-info">
                <h2 class="section--subtitle white ">الخدمات التي نقدمها
                </h2>
                <ul class="services-list">
                    <li>استيراد المنتجات الطبية المتميزة</li>
                    <li>تسويق وتوزيع المنتجات الطبية
                    </li>
                    <li>خدمات التدخل للمتخصصين الصحيين
                    </li>
                    <li>الخدمات الاستشارية للمهنيين الصحيين
                    </li>
                </ul>
            </div>
        </div>
        <img class="image1" src="{{ asset('front/assets/images/abov.jpg') }}" alt="services image">
    </div>
</section>
