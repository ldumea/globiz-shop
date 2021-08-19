$(function(){
    $('.scroll').infiniteScroll({
        path: '.pagination__next',
        append: '.product-list',
        hideNav: '.pagination',
        history: false
    });
     $('.scroll').on( 'append.infiniteScroll', function() {
        if($("img").length){
            $('img').each(function(){
                img1 = new Image();
                var src_second = $(this).data('image-second');
                var src_first = $(this).attr("src");
                img1.src = src_second;
                $(this).hover(
                    function () {
                        $(this).attr('src', src_second);
                    },
                    function () {
                        $(this).attr('src', src_first);
                    }
                );
            });
        }
        if($(".cantitate").length){
            $("input[class='cantitate']").TouchSpin({
                max: 100000,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
                verticalbuttons: true,
                verticalupclass: 'glyphicon glyphicon-plus',
                verticaldownclass: 'glyphicon glyphicon-minus'
            });
        }
    });
});