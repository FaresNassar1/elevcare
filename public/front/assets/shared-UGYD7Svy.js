import"./lazysizes-DD3GZUTg.js";import{$ as w}from"./jquery-m0X-EPcw.js";document.addEventListener("lazybeforeunveil",function(t){var n=t.target.getAttribute("data-bg");n&&(t.target.style.backgroundImage="url("+n+")")});const h=w("html").attr("dir")==="rtl";(t=>{const n=t(".header"),f=n.offset().top,d=()=>{t(window).scrollTop()>=f+n.height()+200&&t(window).width()>=992?n.addClass("sticky"):n.removeClass("sticky")},i=t("#upBtn");function l(){t(window).scrollTop()>300?i.addClass("show"):i.removeClass("show")}i.on("click",function(o){o.preventDefault(),t("html, body").stop().animate({scrollTop:0},300)}),t(window).on("scroll",function(){d(),l()}),d(),l();const a=t("body");t(".burger-menu").on("click",function(){const o=t(this),e=t(".menu-list");o.hasClass("open")?(o.removeClass("open"),e.removeClass("open"),a.removeAttr("style")):(o.addClass("open"),e.addClass("open"),a.css("overflow","hidden"))});function r(){t(window).width()<992&&t(".main-menu-list .has-dropdown > .item").on("click",function(o){o.preventDefault();const s=t(this).closest(".has-dropdown").find("> .dropdown-menu");s.hasClass("open")?(s.removeClass("open"),s.stop().slideUp()):(s.addClass("open"),s.stop().slideDown())})}r();const p=t(".container").first().width()||1400,c=()=>{const e=(t(window).width()-p)/2;t(window).width()>=1400&&(h?(t(".offset-right").css("padding-left",e),t(".offset-left").css("padding-right",e)):(t(".offset-left").css("padding-left",e),t(".offset-right").css("padding-right",e)))};c(),t(window).on("resize",function(){r(),c()})})(jQuery);