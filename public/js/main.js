$(function() {
    setInterval(function() {
        var $background       = $('.js-background:not(.hidden)'),
            $hiddenBackground = $('.js-background.hidden');

        $hiddenBackground.removeClass('disable-transition');
        $hiddenBackground.removeClass('hidden');

        setTimeout(function() {
            $background.addClass('disable-transition');
            $background.addClass('hidden');

            $background.css('z-index', 2);
            $hiddenBackground.css('z-index', 1);
        }, 3000);
    }, 6000);
});
