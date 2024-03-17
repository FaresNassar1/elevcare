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
<section class=" section mv-50 email section-bg-img">
    <div class="container mail-container ">
        <div class="form ">
            <form >

                <h2>ابقى على تواصل
                </h2>
                <input type="text " id="name " name="name " required placeholder="Your Name: ">

                <input type="email " id="email " name="email " required placeholder="Your Email: ">

                <textarea id="message " name="message " rows="2 " required placeholder="Your Message: "></textarea>

                <button style="color: white" class="btn btn-primary " type="submit ">Submit</button>
            </form>
        </div>
        <div class="info ">
            <div class="email-items ff">
                <h3>ترغب في أن تصبح شريكا؟ عميل محتمل؟ بحاجة إلى مساعدة أو لديك سؤال؟

                </h3>
                <div class="contact-info ">
                    <div class="contact-info--title ">معلومات الاتصال

                    </div>
                    <ul>
                        <li>
                            <span> <i class="fa-solid fa-map-location-dot "></i>


                            </span>
                            <h4>السواحرة بالقرب من ابو ديس

                            </h4>
                        </li>
                        <li>
                            <span><i class="fa-solid fa-phone "></i></span>
                            <h4>(972)-526323058

                            </h4>
                        </li>
                        <li>
                            <span><i class="fa-solid fa-envelope "></i></span>
                            <h4>info@omdehmedical.com

                            </h4>
                        </li>
                    </ul>
                </div>



            </div>

        </div>



    </div>
</section>
