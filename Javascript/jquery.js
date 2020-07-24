let dropped_down = false;

$(document).ready(function () {
    $("#arrow-container").click(function () {
        if (dropped_down === false) {
            dropped_down = true;
            $(this).css("transform", "rotate(180deg)");
            $(this).animate({
                left: '0%'
            }, 'slow');
            $(".menu-item-container").animate({
                top: '0px'
            }, 500);
        }
        else {
            dropped_down = false;
            $(this).css("transform", "rotate(0deg)");
            $(this).animate({
                left: '-40%'
            });
            $(".menu-item-container").animate({
                top: '-10000px'
            }, 500);
        }
    });
});