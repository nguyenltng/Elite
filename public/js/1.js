$(function () {
    blockdish = $(".all-dish").isotope({
        itemSelector: ".one-dish",
        layoutMode: "masonry"
    })
    blockdish.imagesLoaded().progress(function () {
        blockdish.isotope("layout");
    });
    $(".dish-day a").click(function () {
        data = $(this).data("dish");
        blockdish.isotope({ filter: data });
        return false;
    });
    // click nut register
    $('.login button.btn-register').click(function () {
        $('.register').addClass('appear');
    });
    // click nut login
    $('.register button.btn-login').click(function () {
        $('.register').removeClass('appear');
    });
    new WOW().init();
});