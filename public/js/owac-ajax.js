jQuery(document).ready(function($) {
    $('.owac-calendar-container').on("click", ".owac-next.owac-arrow", function() {
        $(".owac-slider").owacslider('owacAdd','<div><h3>' + "1" + '</h3></div>');
    });
});
