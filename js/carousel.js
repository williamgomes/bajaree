$(document).ready(function() {

    // home page



    // category page

    $("#categorySlider").tnmCarousel({
        navigation: false,
        lazyLoad: true,
        items: 4,
        itemsTablet: [768, 3],
        itemsTabletSmall: [580, 2]
    });

    $("#categorySlider2").tnmCarousel({
        navigation: false,
        items: 4,
        itemsTablet: [768, 3],
        itemsTabletSmall: [580, 2]
    });

    $("#categorySlider3").tnmCarousel({
        navigation: false,
        items: 4,
        itemsTablet: [768, 3],
        itemsTabletSmall: [580, 2]
    });


    // brand slider 

    $("#brandCarousel").tnmCarousel({
        navigation: false,
        pagination: false,
        stopOnHover: true,
        rewindSpeed: 1000,
        autoPlay: true,
        items: 6
    });




});