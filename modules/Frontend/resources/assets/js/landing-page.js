import $ from './app.js';

import 'lazysizes';

import 'owl.carousel/dist/owl.carousel.min';
import 'owl.carousel/dist/assets/owl.carousel.min.css';
import 'owl.carousel/dist/assets/owl.theme.default.min.css';

import lightGallery from 'lightgallery';
import 'lightgallery/css/lightgallery-bundle.css';
import lgVideo from 'lightgallery/plugins/video';
import hash from 'lightgallery/plugins/hash';

import '../css/landing-page.css';

$(document).on('lazybeforeunveil', function (e) {
    const target = $(e.target);
    const bg = target.data('bg');
    if (bg) {
        target.append(`<style nonce="${window.functions.csp_nonce}">
            #${target.attr('id')} {
                background-image: url("${bg}");
            }
        </style>`);
    }
});

const isRtl = ($('html').attr('dir') === 'rtl');

((
    ($) => {
        const boxes = $(".owl-boxes");
        if (boxes.length) {
            // boxes.each(function (index, box) {
            boxes.owlCarousel({
                rtl: isRtl,
                margin: 20,
                items: 3,
                dots: true,
                autoplay: true,
                lazyLoad: true,
                loop: true,
                animate: 'ease',
                autoplayTimeout: 3000,
                onInitialized: function (event) {
                    const element = event.target;
                    $(element).closest('.loading').removeClass('loading');
                    $(element).removeAttr('style');
                    $(element).find('.owl-dot').each(function (index, dot) {
                        $(dot).attr('aria-label', 'go to slide #' + index);
                    });
                }, responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 3,
                    },
                }
            });
            // });
        }

        const videos = $('.video-w');
        if (videos.length) {
            videos.each(function (index, item) {
                lightGallery(item, {
                    selector: '.video',
                    download: false,
                    customSlideName: true,
                    galleryId: $(item).data('gal-id'),
                    plugins: [lgVideo, hash],
                });
            });
        }

        const galleries = $('.gallery');
        if (galleries.length) {
            galleries.each(function (index, gallery) {
                lightGallery(gallery, {
                    selector: '.gallery-item',
                    download: false,
                    customSlideName: true,
                    galleryId: $(gallery).data('gal-id'),
                    plugins: [hash],
                });
            });
        }

        const faq = $('.faq-item');
        if (faq.length) {
            faq.on('click', function (e) {
                e.preventDefault();
                const item = $(this)
                const body = item.find('.faq-item-content');
                if (!item.hasClass('active')) {
                    item.addClass('active');
                    body.stop().slideDown();
                } else {
                    item.removeClass('active');
                    body.stop().slideUp();
                }
            });
        }
    })
(jQuery));
