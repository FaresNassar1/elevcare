import $ from "./app.js";

import "./shared";

import "owl.carousel/dist/owl.carousel.min";
import "owl.carousel/dist/assets/owl.carousel.min.css";
import "owl.carousel/dist/assets/owl.theme.default.min.css";

import "../css/home.css";

const isRtl = $("html").attr("dir") === "rtl";

(($) => {
    $(".owl-main").owlCarousel({
        rtl: isRtl,
        loop: true,
        autoplay: false,
        autoplayTimeout: 5000,
        autoplaySpeed: 1500,
        nav: true,
        dots: false,
        smartSpeed: 800,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            },
        },
    });
    $(".owl-carousel").owlCarousel({
        rtl: isRtl,
        items: 1,
        dots: true,
        dotsEach: true,

        loop: true,
        margin: 1,
        nav: true,
        responsive: {
            0: {
                items: 4,
            },
            600: {
                items: 4,
            },
            1000: {
                items: 4,
            },
        },
    });

    // $(window).on('scroll', function () {
    //     if (isInViewport($(".owl-main")[0])) {
    //         $(".owl-main").trigger('stop.owl.autoplay');
    //         $(".owl-main").trigger('play.owl.autoplay', [5000]);
    //     } else {
    //         $(".owl-main").trigger('stop.owl.autoplay');
    //     }
    // });

    $(".owl-values").owlCarousel({
        rtl: isRtl,
        margin: 0,
        items: 1,
        dots: false,
        center: true,
        autoplayHoverPause: true,
        autoWidth: true,
        autoplay: true,
        loop: true,
        slideTransition: "linear",
        autoplayTimeout: 4000,
        autoplaySpeed: 4000,
        onInitialized: function (event) {
            const element = event.target;
            $(element).closest(".loading").removeClass("loading");
            // $(element).removeAttr('style');
            // $(element).find('.owl-dot').each(function (index, dot) {
            //     $(dot).attr('aria-label', 'go to slide #' + index);
            // });
        },
    });

    let targets = $(".js-lazyload");

    if (targets.length) {
        let options = {
            root: null,
            rootMargin: "0px",
            threshold: 0.5,
        };

        let observer = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    if (!$(entry.target).hasClass("activated")) {
                        if ($(entry.target).hasClass("statistic")) {
                            const counters = $("[data-count]");
                            const speed = 1000;

                            counters.each(function (index, item) {
                                const updateCount = () => {
                                    const counter = $(item);
                                    const value = parseInt(
                                        counter.attr("data-count")
                                    );
                                    const data = parseInt(counter.text());

                                    const increment = value / speed;

                                    if (data < value) {
                                        counter.text(
                                            Math.ceil(data + increment)
                                        );
                                        setTimeout(updateCount, 1);
                                    } else {
                                        counter.text(value);
                                    }
                                };
                                updateCount();
                            });
                        }
                        $(entry.target).addClass("activated");
                    }
                }
            });
        }, options);

        targets.each((target) => {
            observer.observe(targets[target]);
        });
    }
})(jQuery);
