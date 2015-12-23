var url = window.location.pathname,
    urlRegExp = new RegExp(url.replace(/\/$/, '') + "$");
$('#main-menu a').each(function () {
    if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
        $(this).addClass('active-menu');
        $(this).parent().previoussibling().find('a').removeClass('active-menu');
    }
});