import"./lazysizes-3jfVfppK.js";import"./shared-BDc9q3uT.js";import"./owl.theme.default.min-BclBOZ0u.js";import{$ as g}from"./jquery-JkAoMJ1f.js";import"./_commonjsHelpers-BosuxZz1.js";const n=g("html").attr("dir")==="rtl";(t=>{t(".owl-main").owlCarousel({rtl:n,loop:!0,autoplay:!1,autoplayTimeout:5e3,autoplaySpeed:1500,nav:!0,dots:!1,smartSpeed:800,responsive:{0:{items:1},600:{items:1},1e3:{items:1}}}),t(".owl-carousel").owlCarousel({rtl:n,margin:20,items:1,dots:!0,dotsEach:!0,loop:!0,margin:10,nav:!0,responsive:{0:{items:4},600:{items:4},1e3:{items:4}}}),t(".owl-values").owlCarousel({rtl:n,margin:0,items:1,dots:!1,center:!0,autoplayHoverPause:!0,autoWidth:!0,autoplay:!0,loop:!0,slideTransition:"linear",autoplayTimeout:4e3,autoplaySpeed:4e3,onInitialized:function(s){const r=s.target;t(r).closest(".loading").removeClass("loading")}});let a=t(".js-lazyload");if(a.length){let s={root:null,rootMargin:"0px",threshold:.5},r=new IntersectionObserver((i,f)=>{i.forEach(e=>{if(e.isIntersecting&&!t(e.target).hasClass("activated")){if(t(e.target).hasClass("statistic")){const m=t("[data-count]"),p=1e3;m.each(function(h,d){const u=()=>{const o=t(d),l=parseInt(o.attr("data-count")),c=parseInt(o.text()),v=l/p;c<l?(o.text(Math.ceil(c+v)),setTimeout(u,1)):o.text(l)};u()})}t(e.target).addClass("activated")}})},s);a.each(i=>{r.observe(a[i])})}})(jQuery);
