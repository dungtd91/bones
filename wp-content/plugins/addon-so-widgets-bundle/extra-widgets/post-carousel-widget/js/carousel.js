(function ($) {

    var items = $('.sow-carousel-wrapper').data('found-posts');


    var carousel = $('.sow-carousel-items').owlCarousel({
        loop: true,
        margin: 10,
        items: items,
        nav: false,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    })

    $('.sow-carousel-next').click(function (e) {
        e.preventDefault();
        carousel.trigger('next.owl.carousel');
    })

    $('.sow-carousel-previous').click(function (e) {
        e.preventDefault();
        carousel.trigger('prev.owl.carousel');
    })


})(jQuery);