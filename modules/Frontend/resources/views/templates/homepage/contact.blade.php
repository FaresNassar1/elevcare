<style nonce="{{ csp_nonce() }}">
    .section-bg-img {
        background-image: linear-gradient(rgba(0, 0, 0, 0.33), rgba(0, 0, 0, 0.353)), url('{{ asset('front/assets/images/blure2.jpg') }}');
        background-size: cover;
        background-position: center;
        min-height: 500px;
        position: relative;
        display: flex;
        align-items: center;
        border-bottom:4px solid var(--secondary);
    }
</style>
<section class=" section mv-50  section-bg-img">
    <div class="container d-flex justify-content-between  align-items-center ">
        <div class="contact-form ">
            <form >

                <h2>ابقى على تواصل
                </h2>
                <input type="text " id="name " name="name " required placeholder="ادخل اسمك ">

                <input type="email " id="email " name="email " required placeholder="البريد الالكتروني ">

                <textarea id="message " name="message " rows="2 " required placeholder="اكتب رسالة "></textarea>

                <button style="color: white" class="btn btn-primary " type="submit ">ارسال</button>
            </form>
        </div>

        <div class="section-info">
            <h2 class="section--subtitle white ">
                 ترغب في أن تصبح شريكا؟ عميل محتمل؟ بحاجة إلى مساعدة أو لديك سؤال؟
            </h2>
            <div class="section-list-title">معلومات الاتصال
            </div>
            <ul class="section-list">
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
</section>
