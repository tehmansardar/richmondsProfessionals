jQuery(document).ready(function($){

    $('.menu-item-object-page:first-child').find('a').addClass('catSelected')
    
    $('.menu-item-object-page').on('click', function(){
        var reqUrl = $(this).data('url'); 
        var slug = $(this).data('slug');
        var name = $(this).data('name');

        // $('.menu-item-object-page').removeClass('catSelected');
        // $(this).addClass('catSelected');

        $('.menu-item-object-page').find('a').removeClass('catSelected');
        $(this).find('a').addClass('catSelected');

        $('#tect').html('')
		//https://woocommerce-505355-1605379.cloudwaysapps.com/
        $('#tect').html('<img src="https://woocommerce-505355-1605379.cloudwaysapps.com/wp-content/themes/my-listing/assets/images/photoswipe/load.gif" />')
        // <img src="https://demo.shopforessentials.com/wp-content/themes/my-listing/assets/images/photoswipe/preloader.gif" />
        $('#tect img').css({
            'display': 'block',
            'margin-left': 'auto',
            'margin-right': 'auto',
            'margin-top' : '40px'
            // width: 50%
        })
    
        $.ajax({
            url     :   reqUrl,
            type    :   'POST',
            data    :   {
                            name    :   name,
                            slug    :   slug,
                            action  :   'richmond_food_menu'
                        },
            // contentType: false,
            // cache: false,
            // processData: false,
            success: function (data) {
                $('#tect').css({
                    'height' : '',
                })
                $('#tect').html(data);
                //console.log(data)
            }

        })
        
    })
})