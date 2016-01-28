(function ($) {
    $('.db-accordion-title').click(function (j) {
        var dropDown = $(this).closest('.db-accordion').find('.db-accordion-content');

        $(this).closest('.db-accordion').find('.db-accordion-content').not(dropDown).slideUp();

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).closest('.db-accordion').find('.db-accordion-title .active').removeClass('active');
            $(this).addClass('active');
        }

        dropDown.stop(false, true).slideToggle();

        j.preventDefault();
    });

    $('.db-accordion').matchHeight();
})(jQuery);