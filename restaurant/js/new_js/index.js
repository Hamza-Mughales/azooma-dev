$(document).ready(function() {

    $(".close-search").click(function() {
        $(".search-full").removeClass("open");
        $("body").removeClass("offcanvas");
    });
    $(".header-search").click(function() {
        $(".search-full").addClass("open");
    });
});