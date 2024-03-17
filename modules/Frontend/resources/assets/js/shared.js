import $ from './app.js';

import 'lazysizes';

document.addEventListener('lazybeforeunveil', function (e) {
    var bg = e.target.getAttribute('data-bg');
    if (bg) {
        e.target.style.backgroundImage = 'url(' + bg + ')';
    }
});

const isRtl = ($('html').attr('dir') === 'rtl');

((
    ($) => {
        const header = $('.header');
        const headerOffset = header.offset().top;

        const stickyHeader = () => {
            if (($(window).scrollTop() >= headerOffset + header.height() + 200) && $(window).width() >= 992) {
                header.addClass('sticky');
            } else {
                header.removeClass('sticky');
            }
        }

        const UpBtn = $('#upBtn');

        function toTop() {
            if ($(window).scrollTop() > 300) {
                UpBtn.addClass('show');
            } else {
                UpBtn.removeClass('show');
            }
        }

        UpBtn.on('click', function (e) {
            e.preventDefault();
            $('html, body').stop().animate({scrollTop: 0}, 300);
        });

        $(window).on('scroll', function () {
            stickyHeader();
            toTop();
        });

        stickyHeader();
        toTop();

        const body = $('body');

        $('.burger-menu').on('click', function () {
            const btn = $(this);
            const menu = $('.menu-list');
            if (!btn.hasClass('open')) {
                btn.addClass('open');
                menu.addClass('open');
                body.css('overflow', 'hidden');
            } else {
                btn.removeClass('open');
                menu.removeClass('open');
                body.removeAttr('style');
            }
        });

        function mobileMenu() {
            if ($(window).width() < 992) {
                $('.main-menu-list .has-dropdown > .item').on('click', function (e) {
                    e.preventDefault();
                    const parent = $(this).closest('.has-dropdown');
                    const menu = parent.find('> .dropdown-menu');
                    if (!menu.hasClass('open')) {
                        menu.addClass('open');
                        menu.stop().slideDown();
                    } else {
                        menu.removeClass('open');
                        menu.stop().slideUp();
                    }
                })
            }
        }

        mobileMenu();

        const containerWidth = $('.container').first().width() || 1400;
        const containerFluidOffset = () => {
            const windowWidth = $(window).width();
            const padding = (windowWidth - containerWidth) / 2;
            if ($(window).width() >= 1400) {
                if (isRtl) {
                    $('.offset-right').css('padding-left', padding);
                    $('.offset-left').css('padding-right', padding);
                } else {
                    $('.offset-left').css('padding-left', padding);
                    $('.offset-right').css('padding-right', padding);
                }
            }
        }

        containerFluidOffset();

        $(window).on('resize', function () {
            mobileMenu();
            containerFluidOffset();
        });
    }
)
(jQuery));
