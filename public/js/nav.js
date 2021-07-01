$(document).ready(function() {
    var url = window.location;
    console.log(url.href);
    $('.list-group a[href="'+ url.href +'"]').addClass('active');
    $('ul.nav a').filter(function() {
         return this.href == url;
    }).parent().addClass('active');
});
