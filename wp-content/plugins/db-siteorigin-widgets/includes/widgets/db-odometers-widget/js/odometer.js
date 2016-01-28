jQuery(function ($) {

    $('.db-odometers').waypoint(function (direction) {

        $(this).find('.db-odometer .db-number').each(function () {

            var odometer = $(this);

            setTimeout(function () {
                var data_stop = odometer.attr('data-stop');
                $(odometer).text(data_stop);

            }, 100);


        });

    }, { offset: $.waypoints('viewportHeight') - 100,
        triggerOnce: true});


});