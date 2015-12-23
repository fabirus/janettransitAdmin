$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('#upArrow').fadeIn();
    } else {
        $('#upArrow').fadeOut();
    }
});

// scroll body to 0px on click
$('#upArrow').click(function () {
    $('body,html').animate({
        scrollTop: 0
    }, 800);
    return false;
});


