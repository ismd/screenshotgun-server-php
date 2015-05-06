$(function() {
    var $background = $('.js-background');

    setInterval(function() {
        $background.removeClass('disable-transition');
        $background.toggleClass('alt-background');

        setTimeout(function() {
            $background.toggleClass('reverse-background');
            $background.toggleClass('alt-background');
            $background.addClass('disable-transition');
        }, 3000);
    }, 6000);
});
