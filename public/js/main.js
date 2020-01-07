(function ($) {
    "use strict";

    /* Preloader */
    var topbar = $('.topbar');
    var navWrapper = $('.nav-wrapper');
    var headerSection = $('#header-section');
    var slider = $('#slider-section');
    var breadcrumb = $('#breadcrumb');

    var topbarHeight = $('.topbar').height();
    var navWrapperHeight = $('.nav-wrapper').height();
    var headerSectionHeight = $('#header-section').height();
        
$(document).ready(function() {

    $('body').imagesLoaded( function() {
        $('body').addClass('loaded');
    });

    /*=============[ Back to top ]==============*/
    
    var windowH = $(window).height()/2;

    $(window).on('scroll',function(){
        if ($(this).scrollTop() > windowH) {
            $("#scroll-top").css('display','flex');
        } else {
            $("#scroll-top").css('display','none');
        }
    });

    $('#scroll-top').on("click", function(){
        $('html, body').animate({scrollTop: 0}, 1000);
    });

    /* Product Details Images Loaded */

    $('#product .quick-view-gallery').imagesLoaded( function() {
        var loadTime = setTimeout(function(){
                            $('#product .quick-view-gallery').addClass('pd-loaded');
                        }, 1000);

        $('#product .quick-item-img > img').on('click',function(){
            var clickedThumb = $(this);
            changeLargeImage(clickedThumb);
        });
    });


    /* Products Quick View Images Loaded */


    $('.qty-minus').each(function(){
        $(this).on('click', function(){
            var quantity = $(this).siblings('.qty-text').val();
            if (!isNaN( quantity ) && quantity > 1) {
                quantity--;
                $(this).siblings('.qty-text').val(quantity);
            }
        });
    });

    $('.qty-plus').each(function(){
        $(this).on('click', function(){
            var quantity = $(this).siblings('.qty-text').val();
            if (!isNaN( quantity )) {
                quantity++;
                $(this).siblings('.qty-text').val(quantity);
            }
        });
    });

    /*====================================================
                Checkout Page js
    ====================================================*/ 

    /* Checkout Method Collapse */

    // $('.form-group input[type=checkbox]:checked').attr('data-target')


    $('#checkout .form-group input[type=checkbox]:checked, #checkout .form-group input[type=radio]:checked').each(function(){

        if ($('#checkout .form-group input[type=checkbox], #checkout .form-group input[type=radio]').is(':checked') == true) {

            var panelTarget =  $(this).attr('data-target');
            var panelId = panelTarget.substr(1);
            $('#checkout div[id=' + panelId + ']').addClass('show');

        }        
    });
        
});

    // animate on scroll
    $(function () {
        new WOW().init();
    });

    // Jquery Nice Select
    $(function () {
        $('#cart-table .nice-select, .calculate_shoping_area .nice-select, #shop .nice-select').niceSelect();
    });
    
     /*[ Fixed Header ]
    ===========================================================*/

    $(window).on('scroll',function(){

        // $(headerSection).removeClass('fixed-top');

        if ($(window).width() > 991.99) {

            if ($(this).scrollTop() <= topbarHeight){

                $(navWrapper).removeClass('fixed-top').css('height','');
                $(slider).css('margin-top','0');
                $(breadcrumb).css('margin-top','0');
                $('#login').css('margin-top','0');

            } else {

                $(navWrapper).addClass('fixed-top').css('height','70px');
                $(slider).css('margin-top',navWrapperHeight);
                $(breadcrumb).css('margin-top',navWrapperHeight);
                $('#login').css('margin-top',navWrapperHeight);

            }

        } else if ($(window).width() > 575.99 && $(window).width() < 992) {
            
            if($(this).scrollTop() <= topbarHeight){

                $(navWrapper).removeClass('fixed-top');
                $(slider).css('margin-top','0'); 
                $(breadcrumb).css('margin-top','0');
                $('#login').css('margin-top','0');

            } else {

                $(navWrapper).addClass('fixed-top');
                $(slider).css('margin-top',navWrapperHeight); 
                $(breadcrumb).css('margin-top',navWrapperHeight);
                $('#login').css('margin-top',navWrapperHeight);

            }

        } else {

            $(navWrapper).addClass('fixed-top');
            $(slider).css('margin-top',navWrapperHeight); 
            $(breadcrumb).css('margin-top',navWrapperHeight);
            $('#login').css('margin-top',navWrapperHeight);
        } 
        
    });


     /*[ Show header dropdown ]
    ===========================================================*/
    $('.js-show-header-dropdown').on('click', function(){
        $(this).parent().find('.header-dropdown')
    });

    var menu = $('.js-show-header-dropdown');
    var sub_menu_is_showed = -1;

    for(var i=0; i<menu.length; i++){
        $(menu[i]).on('click', function(){ 
            
                if(jQuery.inArray( this, menu ) == sub_menu_is_showed){
                    $(this).parent().find('.header-dropdown').toggleClass('show-header-dropdown');
                    sub_menu_is_showed = -1;
                }
                else {
                    for (var i = 0; i < menu.length; i++) {
                        $(menu[i]).parent().find('.header-dropdown').removeClass("show-header-dropdown");
                    }

                    $(this).parent().find('.header-dropdown').toggleClass('show-header-dropdown');
                    sub_menu_is_showed = jQuery.inArray( this, menu );
                }
        });
    }

    $(".js-show-header-dropdown, .header-dropdown").click(function(event){
        event.stopPropagation();
    });

    $(window).on("click", function(){
        for (var i = 0; i < menu.length; i++) {
            $(menu[i]).parent().find('.header-dropdown').removeClass("show-header-dropdown");
        }
        sub_menu_is_showed = -1;
    });


    /*====================================================
                    Product list image show
    ====================================================*/

    $('.p_listing_inner li').mouseenter(function(){
        var subcategory = $(this).attr('data-target');
        var category = $(this).closest('div[id]').attr('id');
        // var category = $(this).parent().parent().parent().parent().parent().attr('id');

        $('#'+category +' img#active, #' +category + ' img' + subcategory).toggleClass('d-none');
    });

    $('.p_listing_inner li').mouseleave(function(){
        var subcategory = $(this).attr('data-target');
        var category = $(this).closest('div[id]').attr('id');

        $('#'+category +' img#active, #' +category + ' img' + subcategory).toggleClass('d-none');
    });


    /*====================================================
                        Deals Slider
    ====================================================*/

    $(function () {

        if($('.deals_slider').length) {
            var dealsSlider = $('.deals_slider');
            dealsSlider.owlCarousel(
            {
                items:1,
                loop:false,
                navClass:['deals_slider_prev', 'deals_slider_next'],
                nav:false,
                dots:false,
                smartSpeed:1200,
                margin:20,
                autoplay:false,
                autoplayTimeout:5000
            });

            if($('.deals_slider_prev').length)
            {
                var prev = $('.deals_slider_prev');
                prev.on('click', function()
                {
                    dealsSlider.trigger('prev.owl.carousel');
                }); 
            }

            if($('.deals_slider_next').length)
            {
                var next = $('.deals_slider_next');
                next.on('click', function()
                {
                    dealsSlider.trigger('next.owl.carousel');
                }); 
            }
        }

    });

    /*====================================================
                        Timer
    ====================================================*/

    $(function () {
        if($('.deals_timer_box').length)
        {
            var timers = $('.deals_timer_box');
            timers.each(function()
            {
                var timer = $(this);

                var targetTime;
                var target_date;

                // Add a date to data-target-time of the .deals_timer_box
                // Format: "Feb 17, 2018"
                if(timer.data('target-time') !== "")
                {
                    targetTime = timer.data('target-time');
                    target_date = new Date(targetTime).getTime();
                }
                else
                {
                    var date = new Date();
                    date.setDate(date.getDate() + 2);
                    target_date = date.getTime();
                }

                // variables for time units
                var days, hours, minutes, seconds;

                var h = timer.find('.deals_timer_hr');
                var m = timer.find('.deals_timer_min');
                var s = timer.find('.deals_timer_sec');

                setInterval(function ()
                {
                    // find the amount of "seconds" between now and target
                    var current_date = new Date().getTime();
                    var seconds_left = (target_date - current_date) / 1000;
                 
                    // do some time calculations
                    days = parseInt(seconds_left / 86400);
                    seconds_left = seconds_left % 86400;
                    
                    hours = parseInt(seconds_left / 3600);
                    hours = hours + days * 24;
                    seconds_left = seconds_left % 3600;
                    
                     
                    minutes = parseInt(seconds_left / 60);
                    seconds = parseInt(seconds_left % 60);

                    if(hours.toString().length < 2)
                    {
                        hours = "0" + hours;
                    }
                    if(minutes.toString().length < 2)
                    {
                        minutes = "0" + minutes;
                    }
                    if(seconds.toString().length < 2)
                    {
                        seconds = "0" + seconds;
                    }

                    // display results
                    h.text(hours);
                    m.text(minutes);
                    s.text(seconds); 
                 
                }, 1000);
            }); 
        }   
    });
    
    function l_product_slider(){
        if ( $('.l_product_slider').length ){
            $('.l_product_slider').owlCarousel({
                loop:true,
                margin: 12,
                items: 4,
                nav:true,
                autoplay: true,
                smartSpeed: 1500,
                dots:false,
                navContainerClass: 'l_product_slider',
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                responsiveClass: true,
                responsive: {
                    0:{items:1},
                    575:{items:3},
                    991:{items:4}
                }
            })
        }
    }
    
    l_product_slider();
    /*====================================================
                19. Init Single Product View Slider
    /*====================================================*/
    function initProdcutSlider()
    {
        if($('#product .quick_view_slider').length)
        {
            var quickSlider = $('#product .quick_view_slider');

            quickSlider.owlCarousel(
            {
                slideBy:1,
                loop:false,
                autoplay:false,
                nav:false,
                dots:false,
                autoWidth:true,
                margin:6,
                mouseDrag:false,
                smartSpeed:500,
                responsive:
                {
                    0:{items:1},
                    575:{items:2},
                    1199:{items:3}
                }
            });

            if($('.quick_prev').length)
            {
                var prev = $('.quick_prev');
                prev.on('click', function()
                {
                    quickSlider.trigger('prev.owl.carousel');
                });
            }

            if($('.quick_next').length)
            {
                var next = $('.quick_next');
                next.on('click', function()
                {
                    quickSlider.trigger('next.owl.carousel');
                });
            }
        }
    }

    initProdcutSlider();


    $('#product .quick-item-img > img').on('click',function(){
        var clickedThumb = $(this);
        changeLargeImage(clickedThumb);
    });

    $('#product').on('attribute:changed', '.quick-view-main-gallery', function(){

        initImageSlider();

        $('#product .quick-item-img > img').on('click',function(){
            var clickedThumb = $(this);
            changeLargeImage(clickedThumb);
        });

        $('#product .quick-view-main-gallery').one('mouseenter',function(){
            resetZoomImage();
        });
        
    });

    $('#product .quick-view-main-gallery').one('mouseenter',function(){
        resetZoomImage();
    });

    function resetZoomImage(){
        var zoomImage = $('.quick-view-gallery').find('.zoomImg');
        var imgContainer = $('.quick-view-gallery').find('.quick-view-main-gallery > img');
        var largeImg = imgContainer.attr('src');
        zoomImage.attr('src', largeImg);
    }


    $('#product input[name=sku]').change(function() { 
        var product = $('#product'),
            largeImageField = product.find('.image-popup'),
            sliderField = product.find('.quick_view_slider'),
            shareLinksField = product.find('.share-links'),
            facebookShare = shareLinksField.find('.share-facebook'),
            twitterShare = shareLinksField.find('.share-twitter'),
            linkedinShare = shareLinksField.find('.share-linkedin'),
            googleplusShare = shareLinksField.find('.share-googleplus'),
            pinterestShare = shareLinksField.find('.share-pinterest'),
            ratingField = product.find('.rating_r'),
            stockField = product.find('.stock'),
            skuField = product.find('.sku'),
            addWishButton = product.find('.wish-btn'),
            currentWishUrl = addWishButton.attr('href'),
            addCompareButton = product.find('.add-to-compare'),
            model = $('input[name=model]').val(), 
            sku = $(this).val(),
            url = 'http://www.logicbag.com.bd/product/attribute/'+model+'/'+sku;
        
        $.ajax({
            type: "GET",
            url: url,
            datType: 'json',
            success: function(attribute){
                // Remove previous slider
                destroyImageSlider();

                if (attribute.stock > 10) {
                    stockField.addClass('in-stock');
                }

                if (attribute.stock > 0) {
                    stockField.html(attribute.stock);
                } else {
                    stockField.removeClass('in-stock');
                    stockField.html('Out of stock');
                }
                skuField.html(attribute.sku);
                largeImageField.attr({
                    src: 'http://www.logicbag.com.bd/public/storage/backend/products/'+attribute.model+'/'+attribute.sku+'/medium/'+attribute.images[0],
                    'data-mfp-src': 'http://www.logicbag.com.bd/public/storage/backend/products/'+attribute.model+'/'+attribute.sku+'/original/'+attribute.images[0],
                    // Maginifier Js
                    // 'data-large-img-url': 'http://www.logicbag.com.bd/public/storage/backend/products/'+product.model+'/'+attribute.sku+'/original/'+attribute.images[0],
                });
                var sliderThumbImage = ''
                $.each(attribute.images, function(index, image){
                    var imageName = image.split('.');
                    var nameOnly = imageName.shift();
                    sliderThumbImage = '<div class="quick-item-img"><img class="" src="http://www.logicbag.com.bd/public/storage/backend/products/'+attribute.model+'/'+attribute.sku+'/thumbnail/'+image+'" data-mfp-src="http://www.logicbag.com.bd/public/storage/backend/products/'+attribute.model+'/'+attribute.sku+'/original/'+image+'" alt="'+nameOnly+' image" title="'+nameOnly+' image"/></div>';
                    sliderField.append(sliderThumbImage);
                });
                var currentUrl = window.location.href,
                    newUrl = currentUrl.substring(0, currentUrl.indexOf('color=') + 'color='.length)+convertToSlug(attribute.color),
                    newWishUrl = currentWishUrl.substring(0, currentWishUrl.lastIndexOf('/')+1, currentWishUrl.length)+attribute.sku+'?color='+convertToSlug(attribute.color);
                addWishButton.attr('href', newWishUrl);
                window.history.pushState('data', '', newUrl);
                // Restart zoom master and slider
                $('#product .quick-view-main-gallery').trigger('attribute:changed');
            }
        });
    });

    /*====================================================
                          Image Zoom
    ====================================================*/

    $('#product .quick-view-main-gallery').zoom();

    /*====================================================
          19. Quick View & Product View page scripts
    ====================================================*/
    
    $('body').on('click', '.quick-view', function(e){
        e.preventDefault();
        var url = $(this).attr("href");
        quickView(url);
    });

    $("body").on('shown.bs.modal', '#single-product-modal', function (e) {
        
        initImageSlider();
        $('.quick-item-img > img').on('click',function(){
            var clickedThumb = $(this);
            changeLargeImage(clickedThumb);
        });

        $('.quick-view-main-gallery').one('mouseenter',function(){
            var zoomImage = $('.quick-view-gallery').find('.zoomImg');
            var imgContainer = $('.quick-view-gallery').find('.quick-view-main-gallery > img');
            var largeImg = imgContainer.attr('src');
            zoomImage.attr('src', largeImg);
        });

        changeAttribute();
        
    });

    function changeAttribute(){
        $('body').on('change', 'input[name=sku]', function() { 
            var modal = $('#single-product-modal'),
                largeImageField = modal.find('.image-popup'),
                sliderField = modal.find('.quick_view_slider'),
                shareLinksField = modal.find('.share-links'),
                facebookShare = shareLinksField.find('.share-facebook'),
                twitterShare = shareLinksField.find('.share-twitter'),
                linkedinShare = shareLinksField.find('.share-linkedin'),
                googleplusShare = shareLinksField.find('.share-googleplus'),
                pinterestShare = shareLinksField.find('.share-pinterest'),
                ratingField = modal.find('.rating_r'),
                stockField = modal.find('.stock'),
                skuField = modal.find('.sku'),
                addCartButton = modal.find('.add-to-cart'),
                addWishButton = modal.find('.wish-btn'),
                currentWishUrl = addWishButton.attr('href'),
                addCompareButton = modal.find('.add-to-compare'),
                model = $('input[name=model]').val(), 
                sku = $(this).val(),
                url = 'http://www.logicbag.com.bd/product/attribute/'+model+'/'+sku;

            $.ajax({
                type: "GET",
                url: url,
                datType: 'json',
                success: function(attribute){
                    // Remove previous slider
                    $("#single-product-modal").trigger('hidden.bs.modal');

                    if (attribute.stock > 10) {
                        stockField.addClass('in-stock');
                    }

                    if (attribute.stock > 0) {
                        stockField.html(attribute.stock);
                    } else {
                        stockField.removeClass('in-stock');
                        stockField.html('Out of stock');
                    }
                    skuField.html(attribute.sku);
                    largeImageField.attr({
                        src: 'http://www.logicbag.com.bd/public/storage/backend/products/'+attribute.model+'/'+attribute.sku+'/medium/'+attribute.images[0],
                        'data-mfp-src': 'http://www.logicbag.com.bd/public/storage/backend/products/'+attribute.model+'/'+attribute.sku+'/original/'+attribute.images[0],
                        // Maginifier Js
                        // 'data-large-img-url': 'http://www.logicbag.com.bd/public/storage/backend/products/'+product.model+'/'+attribute.sku+'/original/'+attribute.images[0],
                    });

                    var sliderThumbImage = ''
                    $.each(attribute.images, function(index, image){
                        var imageName = image.split('.');
                        var nameOnly = imageName.shift();
                        sliderThumbImage = '<div class="quick-item-img"><img class="" src="http://www.logicbag.com.bd/public/storage/backend/products/'+attribute.model+'/'+attribute.sku+'/thumbnail/'+image+'" data-mfp-src="http://www.logicbag.com.bd/public/storage/backend/products/'+attribute.model+'/'+attribute.sku+'/original/'+image+'" alt="'+nameOnly+' image" title="'+nameOnly+' image"/></div>';
                        sliderField.append(sliderThumbImage);
                    });

                    var newWishUrl = currentWishUrl.substring(0, currentWishUrl.lastIndexOf('/')+1, currentWishUrl.length)+attribute.sku+'?color='+convertToSlug(attribute.color);
                    addWishButton.attr('href', newWishUrl);
                    
                    // Restart zoom master and slider
                    $("#single-product-modal").trigger('shown.bs.modal');
                },

                error: function(error){
                    responseError(error);
                }
            });
        });

    }

    changeAttribute();

    function initImageSlider() {
    
        // Maginifier Js
        // var evt = new Event(),
        // m = new Magnifier(evt);
        // m.attach({thumb: '#thumb'});
        var quickSlider = $('.quick_view_slider');
        quickSlider.addClass('owl-carousel');
        initQuickSlider();
        $('.quick-view-main-gallery').zoom();
    }

    function changeLargeImage(elem){

        var imgContainer = $('.quick-view-gallery').find('.quick-view-main-gallery > img');
        var imageSource = elem.data('mfp-src');
        var imageTitle = elem.attr('title');
        var imageAlt = elem.attr('alt');
        
        imgContainer.attr({
            src: imageSource,
            alt: imageAlt,
            title: imageTitle,
            'data-mfp-src': imageSource,
            // Maginifier Js
            // 'data-large-img-url': imageSource,
        });
        // Maginifier Js
        // var magnifierLarge = $('#thumb-large');
        // magnifierLarge.attr('src', imageSource);

    }
    
    $("body").on('hide.bs.modal', '#single-product-modal', function (e) {

    });  

    $("body").on('hidden.bs.modal', '#single-product-modal', function (e) {
        
        destroyImageSlider();
        
    });

    function destroyImageSlider() {
        // Maginifier Js
        // var previewContainer = $('#preview');
        // previewContainer.html('');
        var zoomImage = $('.zoomImg');
        var quickSlider = $('.quick_view_slider');
        quickSlider.trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
        quickSlider.html('');
        zoomImage.remove();
    }

    function initQuickSlider()
    {
        if($('.quick_view_slider').length)
        {
            var quickSlider = $('.quick_view_slider');

            quickSlider.owlCarousel(
            {
                slideBy:1,
                loop:false,
                autoplay:false,
                nav:false,
                dots:false,
                autoWidth:true,
                margin:6,
                mouseDrag:false,
                smartSpeed:500,
                responsive:
                {
                    0:{items:1},
                    575:{items:2},
                    1199:{items:3}
                }
            });

            if($('.quick_prev').length)
            {
                var prev = $('.quick_prev');
                prev.on('click', function()
                {
                    quickSlider.trigger('prev.owl.carousel');
                });
            }

            if($('.quick_next').length)
            {
                var next = $('.quick_next');
                next.on('click', function()
                {
                    quickSlider.trigger('next.owl.carousel');
                });
            }
        }
    }

    /*====================================================
                        Image Zoom
    ====================================================*/
        
    $('.product-gallery-trigger').on('click', function () {
        var currentItem = $(this).next().attr('src');
        $('.image-popup').magnificPopup('open');
    });

    $('.image-popup').magnificPopup({
        // delegate: 'a',
        type: 'image',
        gallery: {
                enabled: true,
                navigateByImgClick: true
            },
        fixedContentPos: false,
        closeOnContentClick: true,
        closeBtnInside: false,
        mainClass: 'mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300 // don't foget to change the duration also in CSS
        }
    });
        
    /*====================================================
                  portfolio_isotope
    ====================================================*/

    function main_gallery(){
        if ( $('.fillter_slider_inner').length ){
            // Activate isotope in container
            $(".fillter_slider_inner").imagesLoaded( function() {
                $(".fillter_slider").isotope({
                    layoutMode: 'masonry',
                    percentPosition:true,
                    columnWidth: 1,
                    // masonry: {
                    //     columnWidth: '.grid-sizer, .grid-sizer_two'
                    // }            
                }); 
            }); 
        }
    }
    
    main_gallery();

    /*====================================================
                  Isotope Fillter js
    ====================================================*/

    function portfolio_isotope(){
        if ( $('.portfolio_filter li').length ){
            // Add isotope click function
            $(".portfolio_filter li").on('click',function(){
                $(".portfolio_filter li").removeClass("active");
                $(this).addClass("active");

                var selector = $(this).attr("data-filter");
                $(".quick_view_slider .owl-item").isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 450,
                        easing: "linear",
                        queue: false,
                    }
                });
                return false;
            });
        }
    }
    
    portfolio_isotope();

    /*----------------------------------------------------*/
    /*  Explor Room Slider
    /*----------------------------------------------------*/

     /* 12. Init Banner 2 Slider */

    function initFeaturedLeftSlider_1() {
        if($('.f_product_inner').length)
        {
            var banner2Slider = $('.f_product_inner');
            banner2Slider.owlCarousel(
            {
                items:1,
                loop:true,
                autoplay:true,
                nav:true,
                dots:false,
                autoplayHoverPause: true,
                navContainer: '.f_product_left',
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                smartSpeed:1200,
                autoplayTimeout:5000
            });
        }
    }

    initFeaturedLeftSlider_1();
    
    /* 12. Init Banner 2 Slider */

    function initTopSlider_1()
    {
        if($('.products_widget_1').length)
        {
            var banner2Slider = $('.products_widget_1');
            banner2Slider.owlCarousel(
            {
                items:1,
                loop:true,
                autoplay:true,
                nav:true,
                dots:false,
                autoplayHoverPause: true,
                navContainer: '.products_widget_1_nav',
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                smartSpeed:1200,
                autoplayTimeout:5000
            });
        }
    }

    initTopSlider_1();

    function initTopSlider_2()
    {
        if($('.products_widget_2').length)
        {
            var banner2Slider = $('.products_widget_2');
            banner2Slider.owlCarousel(
            {
                items:1,
                loop:true,
                autoplay:true,
                nav:true,
                dots:false,
                autoplayHoverPause: true,
                navContainer: '.products_widget_2_nav',
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                smartSpeed:1200,
                autoplayTimeout:5000
            });
        }
    }

    initTopSlider_2();

    function initTopSlider_3()
    {
        if($('.products_widget_3').length)
        {
            var banner2Slider = $('.products_widget_3');
            banner2Slider.owlCarousel(
            {
                items:1,
                loop:true,
                autoplay:true,
                nav:true,
                dots:false,
                autoplayHoverPause: true,
                navContainer: '.products_widget_3_nav',
                navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>','<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
                smartSpeed:1200,
                autoplayTimeout:5000
            });
        }
    }

    initTopSlider_3();

    /* 

    16. Init Trends Slider

    */

    function initTrendsSlider()
    {
        if($('.trends_slider').length)
        {
            var trendsSlider = $('.trends_slider');
            trendsSlider.owlCarousel(
            {
                loop:true,
                margin:15,
                nav:false,
                dots:false,
                autoplayHoverPause:true,
                autoplay:false,
                responsive:
                {
                    0:{items:1},
                    575:{items:3},
                    768:{items:3},
                    992:{items:4}

                }
            });

            trendsSlider.on('click', '.trends_fav', function (ev)
            {
                $(ev.target).toggleClass('active');
            });

            if($('.trends_prev').length)
            {
                var prev = $('.trends_prev');
                prev.on('click', function()
                {
                    trendsSlider.trigger('prev.owl.carousel');
                });
            }

            if($('.trends_next').length)
            {
                var next = $('.trends_next');
                next.on('click', function()
                {
                    trendsSlider.trigger('next.owl.carousel');
                });
            }
        }
    }

    initTrendsSlider();

    /* 

    18. Init Recently Viewed Slider

    */

    function initViewedSlider()
    {
        if($('.viewed_slider').length)
        {
            var viewedSlider = $('.viewed_slider');

            viewedSlider.owlCarousel(
            {
                loop:true,
                margin:15,
                autoplay:false,
                autoplayTimeout:6000,
                nav:false,
                dots:false,
                responsive:
                {
                    0:{items:1},
                    575:{items:3},
                    768:{items:4},
                    992:{items:5}
                }
            });

            if($('.viewed_prev').length)
            {
                var prev = $('.viewed_prev');
                prev.on('click', function()
                {
                    viewedSlider.trigger('prev.owl.carousel');
                });
            }

            if($('.viewed_next').length)
            {
                var next = $('.viewed_next');
                next.on('click', function()
                {
                    viewedSlider.trigger('next.owl.carousel');
                });
            }
        }
    }

    initViewedSlider();


    /* 

    19. Init Brands Slider

    */

    function initBrandsSlider()
    {
        if($('.brands_slider').length)
        {
            var brandsSlider = $('.brands_slider');

            brandsSlider.owlCarousel(
            {
                slideBy:4,
                loop:true,
                autoplay:true,
                autoplayTimeout:5000,
                nav:false,
                dots:false,
                autoWidth:true,
                margin:32,
                mouseDrag:true,
                smartSpeed:500,
                responsive:
                {
                    0:{items:1},
                    575:{items:2},
                    768:{items:3},
                    991:{items:4},
                    1199:{items:6}
                }
            });

            if($('.brands_prev').length)
            {
                var prev = $('.brands_prev');
                prev.on('click', function()
                {
                    brandsSlider.trigger('prev.owl.carousel');
                });
            }

            if($('.brands_next').length)
            {
                var next = $('.brands_next');
                next.on('click', function()
                {
                    brandsSlider.trigger('next.owl.carousel');
                });
            }
        }
    }

    initBrandsSlider();

    /*====================================================
                Shop Isotope Filter js
    ====================================================*/

    $(function(){
        if ( $('.category-man li').length ){
            // Add isotope click function
            $(".category-man li, .category-woman li").on('click',function(){
                $(".category-man li, .category-woman li").removeClass("active");
                $(this).addClass("active");

                var selector = $(this).attr("data-filter");
                $("#products .grid").isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 450,
                        easing: "linear",
                        queue: false,
                    }
                });
                return false;
            });
        }
    });

     /*====================================================
                Shop panel collapse js
    ====================================================*/   
    
    /* 

    19. Init Characteristics Slider

    */

    function initCharSlider()
    {
        if($('.characteristics_slider').length)
        {
            var charsSlider = $('.characteristics_slider');

            charsSlider.owlCarousel(
            {
                slideBy:1,
                loop:true,
                autoplay:true,
                autoplayTimeout:5000,
                nav:false,
                dots:false,
                autoWidth:true,
                margin:50,
                mouseDrag:true,
                smartSpeed:1000,
                responsive:
                {
                    0:{items:1},
                    768:{items:2},
                    1199:{items:3}
                }
            });

            if($('.chars_prev').length)
            {
                var prev = $('.chars_prev');
                prev.on('click', function()
                {
                    charsSlider.trigger('prev.owl.carousel');
                });
            }

            if($('.chars_next').length)
            {
                var next = $('.chars_next');
                next.on('click', function()
                {
                    charsSlider.trigger('next.owl.carousel');
                });
            }
        }
    }

    initCharSlider();


})(jQuery);

/*====================================================
                Compare page scripts
====================================================*/   

function addWish(){

    $('body').on('click', '.wish-btn', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            datType: 'json',
            success: function(response){
                if (response['success']) {
                    swal({
                        title: "Success!",
                        text: response['success'],
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: '#5EBA7D',
                        confirmButtonText: "Wish List",
                        cancelButtonText : "Close",
                    })
                    .then((value) => {

                        if (value.value) {
                            window.location.replace("http://www.logicbag.com.bd/user/wishes");
                            return;
                        }
                    });
                } else {
                    swal({
                        title: "Oops!",
                        text: response['warning'],
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#5EBA7D',
                        confirmButtonText: "Wish List",
                        cancelButtonText : "Close",
                    })
                    .then((value) => {

                        if (value.value) {
                            window.location.replace("http://www.logicbag.com.bd/user/wishes");
                            return;
                        }
                    });
                }
            },
            error: function (error) {
                if (error.status == 403) {
                    responseError(error);
                    swal({
                        title: "Oops!",
                        text: "You are not logged in.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#5EBA7D',
                        confirmButtonText: "OK",
                        cancelButtonText : "Close",
                    })
                    .then((value) => {

                        if (value.value) {
                            window.location.replace("http://www.logicbag.com.bd/login");
                            return;
                        }
                    });
                } else {
                    swal({
                        title: "Oops!",
                        text: error.responseJSON.message,
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#5EBA7D',
                        confirmButtonText: "OK",
                        cancelButtonText : "Close",
                    })
                    .then((value) => {

                        if (value.value) {
                            window.location.replace("http://www.logicbag.com.bd");
                            return;
                        }
                    });
                }
            }
        });
    });
}

addWish();

$('#wishlist').on('click', '.wish-item-img', function(e){
    e.preventDefault();
    var url = $(this).children('.quick-view').attr('href');
    quickView(url);
});

function removeWish(){

    $('#wishlist').on('click', '.wish-table .remove-item', function(e){
        e.preventDefault();
        var url = $(this).attr('href'),
            wishItem = $(this).closest('.wish-item');

        $.ajax({
            type: "GET",
            url: url,
            datType: 'json',
            success: function(response){
                swal({
                    title: "Success!",
                    text: response['success'],
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: '#5EBA7D',
                    confirmButtonText: "Home Page",
                    cancelButtonText : "Close",
                })
                .then((value) => {

                    wishItem.hide(500);

                    if (value.value) {
                        window.location.replace("http://www.logicbag.com.bd");
                        return;
                    } else {

                        if (response.wishes.length < 1) {
                            location.reload();
                        }
                    }

                });
            },
            error: function (error) {
                responseError(error);
            }
        });
    });
}

removeWish();

function wishPagination()
{

    $('#wishlist').on('click', '.pagination-links .pagination .page-link', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: "get",
            datatype: "html",
        }).done(function(data){

            var deferred = $('#wishlist .wish-table').toggleClass('slideInDown slideOutLeft');
            $.when(deferred).done(function(){
                setTimeout(function(){
                    $(".wish-table-area").empty().html(data);
                    window.history.pushState('data', '', url);
                }, 300);
            });

        }).fail(function(jqXHR, ajaxOptions, thrownError){
            swal({
                title: jqXHR.status,
                text: jqXHR.statusText,
                type: "error",
                showCancelButton: true,
                confirmButtonColor: '#5EBA7D',
                confirmButtonText: "Home page",
                cancelButtonText : "Close",
            })
            .then((value) => {

                if (value.value) {
                    window.location.replace("http://www.logicbag.com.bd");
                    return;
                }
            });
        });
    });
}

wishPagination();

function orderPagination()
{

    $('#orders').on('click', '.pagination-links .pagination .page-link', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: "get",
            datatype: "html",
        }).done(function(data){

            var deferred = $('#orders .order-table').toggleClass('slideInDown slideOutLeft');
            $.when(deferred).done(function(){
                setTimeout(function(){
                    $(".order-table-area").empty().html(data);
                    window.history.pushState('data', '', url);
                }, 300);
            });

        }).fail(function(jqXHR, ajaxOptions, thrownError){
            swal({
                title: jqXHR.status,
                text: jqXHR.statusText,
                type: "error",
                showCancelButton: true,
                confirmButtonColor: '#5EBA7D',
                confirmButtonText: "Home page",
                cancelButtonText : "Close",
            })
            .then((value) => {

                if (value.value) {
                    window.location.replace("http://www.logicbag.com.bd");
                    return;
                }
            });
        });
    });
}

// orderPagination();

/*====================================================
                Compare page scripts
====================================================*/   

function addCompare(){
    $('body').on('click', '.compare-btn', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            datType: 'json',
            success: function(response){
                if (response['warning']) {
                 
                    swal('Oops..!', response['warning'], 'warning', {
                        buttons: [
                            false, true
                        ]
                    });

                    return;
                }

                swal({
                    title: "Success",
                    text: response['success'],
                    type: "success",
                    showCancelButton: true,
                    cancelButtonColor: '#5EBA7D',
                    // confirmButtonColor: '#DD6B55',
                    confirmButtonText: "Compare table",
                    cancelButtonText : "Continue Surfing",
                })
                .then((value) => {
                    if (value.value) {
                        window.location.replace("http://www.logicbag.com.bd/compare-table");
                    }
                });

                return;
            },

            error: function (error) {
                responseError(error);
            }
        });
    });
}

addCompare();

function removeCompareItem(){
    $('.compare-table .remove-item').each(function(){
        $(this).click(function(e){
            e.preventDefault();
            var url = $(this).attr('href'),
                column = $(this).data('column');
            $.ajax({
                type: "GET",
                url: url,
                datType: 'json',
                success: function(response){
                    updateCompareTable(column, response);
                },
                error: function (error) {
                    responseError(error);
                }
            });
        });
    });
}

removeCompareItem();

function updateCompareTable(column, response) {
    if (response['success']) {
        swal({
            title: "Success",
            text: response['success'],
            type: "success",
            showCancelButton: true,
            confirmButtonColor: '#5EBA7D',
            confirmButtonText: "Home Page",
            cancelButtonText : "Close",
        })
        .then((value) => {

            if (value.value) {
                window.location.replace("http://www.logicbag.com.bd");
                return;
            }

            $('td:nth-child('+column+'), th:nth-child('+column+')').hide(500);

        });
    } else {
        swal({
            title: "Success",
            text: response['warning'],
            type: "success",
            showCancelButton: true,
            confirmButtonColor: '#5EBA7D',
            confirmButtonText: "Home page",
            cancelButtonText : "Close",
        })
        .then((value) => {

            if (value.value) {
                window.location.replace("http://www.logicbag.com.bd");
                return;
            }

            var deferred = $('td:nth-child('+column+'), th:nth-child('+column+')').hide(500);
            $.when(deferred).done(function(){
                location.reload();
            });
        });
    }
}

/*====================================================
                Cart page scripts
====================================================*/   

$('body').on('click', '.cart-btn', function(e){
    e.preventDefault();
    var url = $(this).attr('href'), 
        type = "GET";

    addCart(type ,url);
});

function addCart(type, url, data){
    data = data || '';
    $.ajax({
        type: type,
        url: url,
        data: data,
        datType: 'json',
        success: function(response){

            if (response['warning']) {

                addCartSwal('warning', 'Oops..', response['warning']);
                return;
            }

            upgradeCart(response['data']);
            addCartSwal('success', 'Success', response['success']);
            return;
        },

        error: function (error) {
            responseError(error);
        }
    });
}

function storeCart(){
    $('body').on('submit', '.add-cart-form', function (e){
        e.preventDefault();
        var url = $(this).attr('action'), 
            type = $(this).attr('method'),
            data = $(this).serialize();
        addCart(type ,url, data);
    });
}

storeCart();

function addCartSwal(type, title, response){
    if (response) {
             
        swal({
            title: title,
            text: response,
            type: type,
            showCancelButton: true,
            cancelButtonColor: '#5EBA7D',
            // confirmButtonColor: '#DD6B55',
            confirmButtonText: "View Cart",
            cancelButtonText : "Continue Surfing",
        })
        .then((value) => {
            if (value.value) {
                window.location.replace("http://www.logicbag.com.bd/user/cart");
            }
        });

        return;
    }
}

function upgradeCart(data) {
    var product = data,
        attribute = data['attribute'],
        attributes = data['attributes'];
        updateHeaderCart(product, attribute, attributes);

    if ($('#cart-table').length > 1) {
        updateCartTable(product, attribute, attributes);
    }
}

function updateCartTable(product, attribute, attributes){
    var cartTable = $('#cart-table'),
        totalRow = $('.cart-summary').find('.total'),
        subtotalRow = $('.cart-summary').find('.subtotal'),
        deliveryRow = $('.cart-summary').find('.delivery-fee');
}

function updateHeaderCart(product, attribute, attributes){

    var headerCart = $('.header-cart'),
        headerEmptyCart = headerCart.find('.empty-cart'),
        headerCartBtns = headerCart.find('.header-cart-buttons'),
        headerCartWrapper = headerCart.find('.header-cart-wrapitem'),
        headerCartTotal = headerCart.find('.header-cart-total'),
        headerCartSubtotal = headerCart.find('.subtotal'),
        headerCartCounterIcon = $('.header-icons-noti'),

        subtotal = parseFloat(headerCartSubtotal.html()),
        items = parseFloat(headerCartCounterIcon.html()),
        template = '<li class="header-cart-item cart-item" data-item="{{$item->sku}}"><div class="header-cart-item-img"><a class="remove" title="Remove Item" href="http://www.logicbag.com.bd/user/cart/remove/'+product.model+'/'+attribute.sku+'" title="Remove Item"><img class="img-fluid" src="http://www.logicbag.com.bd/public/storage/backend/products/'+product.model+'/'+attribute.sku+'/thumbnail/'+attribute.images[0]+'" alt="IMG"></a></div><div class="header-cart-item-txt"><a href="#" class="header-cart-item-name">'+product.title+'</a><span class="header-cart-item-info">'+product.quantity+' &times; '+parseFloat(product.price).toFixed(2)+'</span><span class="badge cart-badge float-right" style="background-color:'+attribute.color.toLowerCase()+';">'+attribute.color+'</span></div></li>';
    items += parseFloat(product.quantity);
    subtotal += parseFloat(product.price);

    headerCartCounterIcon.html(items);
    headerCartSubtotal.html(subtotal.toFixed(2));
    headerCartWrapper.append(template);

    if (headerCartWrapper.is('.d-none')) {
        headerCartWrapper.toggleClass('d-none');
        headerCartTotal.toggleClass('d-none');
        headerCartBtns.toggleClass('d-none');
        headerEmptyCart.toggleClass('d-none');
    }
}

$('.header-cart-wrapitem').on('click', '.header-cart-item-img', function(e){
    e.preventDefault();
    var elem = $(this);
    removeCartItem(elem);
});


$('.cart-image').after().click(function(e){
    e.preventDefault();
    var elem = $(this);
    removeCartItem(elem);
});

function removeCartItem(elem){
    var url = elem.children('.remove').attr('href');
    $.ajax({
        type: "GET",
        url: url,
        datType: 'json',
        success: function(response){
            downgradeCart(elem, response);
        },
        error: function (error) {
            responseError(error);
        }
    });
}

function downgradeCart(elem, response){
    var cartTable = $('#cart-table'),
        headerCart = $('.header-cart'),
        itemRow = elem.closest('.cart-item'),
        targetElem = itemRow[0].nodeName,
        dataItem = itemRow.data('item');

    if (targetElem.toLowerCase() == 'tr') {
        reciprocalTarget = headerCart;
    } else {
        reciprocalTarget = cartTable;
    }

    var reciprocalItemRow = reciprocalTarget.find('[data-item='+dataItem+']'),

        totalRow = $('.cart-summary').find('.total'),
        subtotalRow = $('.cart-summary').find('.subtotal'),
        deliveryRow = $('.cart-summary').find('.delivery-fee'),

        headerEmptyCart = headerCart.find('.empty-cart'),
        headerCartBtns = headerCart.find('.header-cart-buttons'),
        headerCartWrapper = headerCart.find('.header-cart-wrapitem'),
        headerCartTotal = headerCart.find('.header-cart-total'),
        headerCartSubtotal = headerCart.find('.subtotal'),
        headerCartCounterIcon = $('.header-icons-noti');

    itemRow.toggle(500);
    reciprocalItemRow.toggle(500);

    var subtotal = 0,
        total = 0,
        deliveryFee = 0,
        items = 0;

    if (response['success']) {

        var cart = response['data'];
        
        $.each(cart, function(model, value){

            $.each(value, function(sku, item){
                
                items += parseInt(item.quantity);
                deliveryFee += parseInt(item.quantity * 100);
                subtotal += parseInt(item.quantity * item.price);

            });

        });

        total = parseInt(subtotal + deliveryFee);
        subtotalRow.html(subtotal.toFixed(2));
        deliveryRow.html(deliveryFee.toFixed(2));
        totalRow.html(total.toFixed(2));
        headerCartSubtotal.html(subtotal.toFixed(2));
        headerCartCounterIcon.html(items);

        removeCartSuccessSwal(response['success']);
        
    } else {

        total = parseInt(subtotal + deliveryFee);
        subtotalRow.html(subtotal.toFixed(2));
        deliveryRow.html(deliveryFee.toFixed(2));
        totalRow.html(total.toFixed(2));
        headerCartSubtotal.html(subtotal.toFixed(2));
        headerCartCounterIcon.html(items);

        if (headerEmptyCart.is('.d-none')) {
            headerCartWrapper.toggleClass('d-none');
            headerCartTotal.toggleClass('d-none');
            headerCartBtns.toggleClass('d-none');
            headerEmptyCart.toggleClass('d-none');
        }

        removeCartWarnSwal(response['warning']);
    
    }

}

function removeCartSuccessSwal(response){
    swal({

        title: "Success",
        text: response,
        type: "success",
        showCancelButton: true,
        confirmButtonColor: '#5EBA7D',
        confirmButtonText: "Go to shop!",
        cancelButtonText : "Close",
    })
    .then((value) => {

        if (value.value) {
            window.location.replace("http://www.logicbag.com.bd/shop");
            return;
        }

    });
}

function removeCartWarnSwal(response){
    swal({

        title: "Success",
        text: response,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#5EBA7D',
        confirmButtonText: "Go to shop!",
        cancelButtonText : "Home page",
    })
    .then((value) => {

        if (value.value) {
            window.location.replace("http://www.logicbag.com.bd/shop");
            return;
        }

        window.location.replace("http://www.logicbag.com.bd");
    });
}

/*====================================================
                General page scripts
====================================================*/   

function responseError(error){
    console.log(error);
    swal({
        title: error.status,
        text: error.statusText,
        type: "error",
        showCancelButton: true,
        confirmButtonColor: '#5EBA7D',
        confirmButtonText: "Home page",
        cancelButtonText : "Close",
    })
    .then((value) => {

        if (value.value) {
            window.location.replace("http://www.logicbag.com.bd");
            return;
        }
    });
}

function quickView(url){

    $.ajax({
        type: "GET",
        url: url,
        datType: 'html',
        success: function(quickModal){
            // Populate Quick modal
            $("#quick-view").html(quickModal);
            var modal = $('#single-product-modal');
            
            // Remove preloader
            $('.quick-view-gallery').removeClass('pd-loaded');
            $('.quick-view-gallery').imagesLoaded( function() {
                setTimeout(function(){
                    $('.quick-view-gallery').addClass('pd-loaded');
                }, 1000);
            });
            
            // show modal
            modal.modal('show');
        },
        error: function (error){
            console.log(error);
        }
    });
}

/*====================================================
                Product review page scripts
====================================================*/   

function openReplyEditForm(){

    var click = 1;
    $('#review .edit-reply').each(function(){
        $(this).click(function(e){
            e.preventDefault();
            var thisPane = $(this).closest('.reply-pane');
            var replyField = $(this).closest('.reply').find('.reply-edit-form-field');

            if (!replyField.is('.active')) {
                var activeField = thisPane.find('.reply-edit-form-field.active');
                if (activeField.length > 0) {
                    activeField.toggleClass('active');
                    activeField.closest('.reply').find('.edit-reply').children('i.closed, i.open').toggle();
                    // activeField.closest('.reply').find('.edit-reply').children('i:open').toggle();
                    activeField.slideUp(500);
                    click = 1;
                }

            }

            if (click%2 == 1) {
                replyField.slideDown(500);
            } else {
                replyField.slideUp(500);
            }

            $(this).children('i.closed, i.open').toggle();
            replyField.toggleClass('active');
            click++;

            console.log(click);
        });
    });
}

openReplyEditForm();

$('.review .edit-review').each(function(){
    $(this).click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var target = $(this).data('target');
        $.ajax({
            type: "GET",
            url: url,
            datType: 'json',
            success: function(review){
                var form = $('#review-form .review-form');
                form.slideUp();
                setTimeout(function(){
                    form.parent().prev().html('Update your review');
                    form.attr('action', 'http://www.logicbag.com.bd/review/update')
                    var reviewIdField = '<input type="hidden" name="id" value="'+review.id+'">';
                    form.find('input[name="product_id"]').after(reviewIdField);
                    form.find('textarea[name=comment]').val(review.comment).attr('autofocus', 'autofocus');
                    form.find('input[name="rating"][value="'+review.rating+'"]').next().trigger('click');
                    form.find('button[type="submit"]').html('Update');
                    form.slideDown(300);
                }, 300);

                $('html, body').animate({
                    scrollTop: $(target).offset().top - 120
                }, 1250);

            },
            
            error: function (error) {
                responseError(error);
            }
        });
    });
});

function minimizeReplyPane(){

    var click = 1;
    $('#review .minimize').each(function(){
        $(this).click(function(e){
            e.preventDefault();
            var thisPane = $(this).closest('.review').find('.reply-pane');

            if (!thisPane.is('.minimized')) {
                click = 1;
            } else {
                click = 0;
            }

            if (click % 2 == 1) {

                $(this).children('i').css('transform', 'rotateX(180deg)')
                thisPane.toggleClass('minimized');
                thisPane.slideUp(500);

            } else {

                $(this).children('i').css('transform', '');
                thisPane.slideDown(500);
                thisPane.toggleClass('minimized');
                
            }
            
            click++;
        });
    });
}

minimizeReplyPane();

function openReplyForm(){

    var click = 1;
    $('#review .reply-btn').each(function(){
        $(this).click(function(e){
            e.preventDefault();
            var thisPane = $(this).closest('.review').find('.reply-pane');
            var replyField = $(this).closest('.review').find('.reply-form-field');

            if (thisPane.is('.minimized')) {
                $(this).closest('.review').find('.minimize').trigger('click');
            }

            if (!replyField.is('.active')) {

                if ($(this).closest('.review-pane').find('.reply-form-field.active')) {
                    var activeField = $(this).closest('.review-pane').find('.reply-form-field.active');
                    activeField.closest('.review').find('.reply-btn').children('i').css('transform', '');
                    activeField.toggleClass('active');
                    activeField.slideUp(500);
                    click = 1;
                }

            }

            if (click%2 == 1) {

                $(this).children('i').css('transform', 'rotateX(180deg)')
                replyField.toggleClass('active');
                replyField.slideDown(500);

            } else {

                e.preventDefault();
                $(this).children('i').css('transform', '');
                replyField.slideUp(500);
                replyField.toggleClass('active');
                
            }
            
            click++;
        });
    });
}

openReplyForm();

/*====================================================
                Shop page scripts
    ====================================================*/   

$('.store').on('change', '#sort', function(){
    var sortData = $(this).val();
    var dataArr = sortData.split(' ');
    var selector = '#container',
        order = dataArr[1],
        argument = dataArr[0];

    if (dataArr[1] == 'asc') {
        order = true;
    } else {
        order = false;
    }
    
    isotopeSort(selector, argument, order);
});

function isotopeSort(selector, argument, order){

    var $grid = $(selector).isotope({
        getSortData: {
            rating: '[data-'+argument+'] parseInt',
            created: '[data-'+argument+']',
            price: '[data-'+argument+'] parseInt',
        },

        sortBy: argument,
        sortAscending: order,
    });

    $grid.isotope('updateSortData').isotope();

}

function getPaginate(){
    $('.store').on('change', '#perpage', function(){

        var perpageRequest = $(this).val(),
            data = {'perpage': perpageRequest},
            url = window.location.href;
        getDataPage(url, data);
        $('.store .nice-select[name="perpage"]').children('option[value="'+perpageRequest+'"]').attr('selected', 'selected');

    });
}

getPaginate(); 

function changePage(){

    $('.store').on('click', '.pagination-links .pagination a', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        getDataPage(url);
    });
}

changePage(); 

function shop_products_category(){
    $("#accordion .categories").on('click', 'li.category', function(e){
        e.preventDefault();
        $("#accordion .categories li").removeClass("active");
        $(this).addClass("active");

        var category = $('#category-panel .categories').find('.category.active').data('category');

        var url = $(this).children('a').attr('href');

        var dataPopulation = getDataPage(url);
        $.when(dataPopulation).done(function(){
            getSubcategoriesList(category);
        });
    });
}

shop_products_category();
    
function shop_products_subcategory(){
    $("#accordion .subcategories").on('click', 'li.subcategory', function(e){
        e.preventDefault();
        $("#accordion .subcategories li").removeClass("active");
        $(this).addClass("active");
        var url = $(this).children('a').attr('href');
        getDataPage(url);
    });
}

shop_products_subcategory();

function getDataPage(url, data){
    
    data = data || {};

    $.ajax({
        url: url,
        type: "get",
        datatype: "html",
        data: data,
    }).done(function(page){
        var deferred = $('#shop .products').toggleClass('slideInRight slideOutLeft');
        $.when(deferred).done(function(){
            setTimeout(function(){
                $(".store").empty().html(page);
                $('.store .nice-select').niceSelect();

                window.history.pushState('data', '', url);
            }, 300);
        });

    }).fail(function(error){
        
            swal({
                title: "Oops!",
                text: error.responseJSON.message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#5EBA7D',
                confirmButtonText: "Shop",
                cancelButtonText : "Close",
            })
            .then((value) => {

                if (value.value) {
                    window.location.replace("http://www.logicbag.com.bd/shop");
                    return;
                }
            });

    });

}

// Subcategories stretch function 
function getSubcategoriesList(category){

    category = category || $('#category-panel .categories').find('.category.active').data('category');
    if (category=='all') {
        var hide = $('#subcategories-panel .subcategories').slideUp(300);
        $.when(hide).done(function(){

          $('#subcategories-panel .subcategories').html('<li data-filter="*" class="subcategory active"><a href="http://www.logicbag.com.bd/shop/products/'+convertToSlug(category)+'">All</a></li>');
          
        }).then(function(){
            $('#subcategories-panel .subcategories').slideDown(300);
        });
        return;
    }
    var url = "http://www.logicbag.com.bd/category/"+convertToSlug(category)+"/subcategories";
      $.ajax({
        type: "GET",
        url: url,
        success: function(subcategories){
            var hide = $('#subcategories-panel .subcategories').slideUp(300);
            $.when(hide).done(function(){

                var subcategoryTitle = getTitleText(3),
                    active = '';

                if (subcategoryTitle == 'All') {
                    var active = 'active';
                }

                $('#subcategories-panel .subcategories').html('<li data-subcategory="all" class="subcategory '+active+'"><a href="http://www.logicbag.com.bd/shop/products/'+convertToSlug(category)+'/all">All</a></li>');

                $.each(subcategories, function(index, subcategory){

                    if (subcategory.title == subcategoryTitle) {
                        var active = 'active';
                    }

                    $('#subcategories-panel .subcategories').append(
                        '<li data-subcategory="'+convertToSlug(subcategory.title)+'" class="subcategory '+active+'"><a href="http://www.logicbag.com.bd/shop/products/'+convertToSlug(category)+'/'+convertToSlug(subcategory.title)+'">'+subcategory.title+'</a></li>'
                    );
                });

            }).then(function(){
                $('#subcategories-panel .subcategories').slideDown(300);
            });
        }, 

        error: function (error){
            responseError(error);
        }
      });

}

if ($('#category-panel .categories').find('.category.active').length > 0) {
    getSubcategoriesList();
}

// Get Subcategory Title from Str_slug
function getTitleText(index){
    var currentLoction = window.location.pathname,
        trimmedCurrentLocation = currentLoction.substring(1),
        pathArray = trimmedCurrentLocation.split('/'),
        titleSlug = pathArray[index];

        if (!titleSlug) {
            return;
        }

    var titlePartsArray = titleSlug.split('-'),
        titleArray = [];

        $.each(titlePartsArray, function(index, key){
            titleArray.push(key.charAt(0).toUpperCase()+key.slice(1));
        });

    var title = titleArray.join(' ');

    return title;
}

// Str_slug
function convertToSlug(text)
{
    return text
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-')
        ;
}

$('#price-search').submit(function(e){
    e.preventDefault();
    
    var minimum = $(this).find('#minimum').val(),
        maximum = $(this).find('#maximum').val(),
        url = 'http://www.logicbag.com.bd/shop/products/search/price/'+minimum+'-'+maximum,
        method = $(this).attr('method');
    $.ajax({
        url: url,
        type: "GET",
        datatype: "html",
    }).done(function(data){
        var deferred = $('#shop .products').toggleClass('slideInRight slideOutLeft');
        $.when(deferred).done(function(){
            setTimeout(function(){
                $(".store").empty().html(data);
                $('.store .nice-select').niceSelect();

            }, 300);
        });

        window.history.pushState('data', '', url);
        $("#accordion .categories li").removeClass("active");
        $('#accordion .categories').find('[data-category=all]').addClass("active");
        getSubcategoriesList('all');
        
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        alert('No response from server');
    });
});

function searchProducts(){

    $('.navbar #keyword').on('keyup', function(e){
        e.preventDefault();
        var keyword = $(this).val(),
            resultField = $('.navbar .search-result'),
            url = 'http://www.logicbag.com.bd/shop/products/live-search/keyword/'+keyword,
            noProduct = '<li class="search-item row"><div class="col-md-10 col-sm-9 search-item-desc"><p><i class="fas fa-exclamation-circle"></i> No product found!</div></li>';
        if (keyword.length > 1) {
            
            $.ajax({
                url: url,
                type: "GET",
                datatype: "json",
                // data: data,
                success:function(response){
                    if (response.length > 0) {
                        
                        resultField.html('');

                        $.each(response, function (index, item){

                            var meta = item.meta,
                                product = item.product,
                                category = item.category,
                                subcategory = item.subcategory,
                                attribute = item.attribute,
                                resultItem = '<a href="http://www.logicbag.com.bd/product/'+convertToSlug(category)+'/'+convertToSlug(subcategory)+'/'+product.model+'/'+meta.slug+'"><li class="search-item row"><div class="col-md-2 col-sm-3"><img src="http://www.logicbag.com.bd/storage/backend/products/'+product.model+'/'+attribute.sku+'/thumbnail/'+attribute.images[0]+'" alt="" class="img-fluid search-item-thumbnail"></div><div class="col-md-10 col-sm-9 search-item-desc"><p>'+product.model+'</p><p>'+product.meta.title+'</p></div></li></a>';

                            resultField.append(resultItem);

                        });

                    } else {

                        resultField.html('');
                        $('.navbar .search-result').append(noProduct);

                    }
                },
                error: function(error){
                    responseError(error);
                }
            });
        } else {

            resultField.html('');
            resultField.append(noProduct);
        }
    });

}

searchProducts();

function liveSearch(){

    $('.navbar #keyword').on('focus', function(e){
        var keyword = $(this).val();
        if (keyword.length < 2) {
            $('.navbar .search-result').html('');
            var resultItem = '<li class="search-item row"><div class="col-md-10 col-sm-9 search-item-desc"><p><i class="fas fa-exclamation-circle"></i> Type to search!</div></li>';
            $('.navbar .search-result').append(resultItem);
        }
        $('.navbar .live-search').slideDown(300);
    });

    $('.navbar #keyword').on('focusout', function(e){
        $('.navbar .live-search').slideUp(300);
    });

}

liveSearch();


