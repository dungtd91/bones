(function($){
    var $slider = $("#product-slider .slides");
    if ($slider.length) {
        $slider.bxSlider({
            pagerCustom: '#product-thumbnails',
            preloadImages: 'all',
            //mode: 'fade'
        });
        $("#product-thumbnails").bxSlider({
            slideWidth: 200,
            minSlides: 3,
            maxSlides: 3,
            slideMargin: 30,
            pager: false,
            preloadImages: 'all',
        });
    }
})(jQuery);