//NAVIGATION

//open and close sidenav
function openSideNav()
{
    if($('.sidebar').css('left') == '-300px')
    {
        $('.sidebar').animate({
            'left' : '0px'
        }, 500);

    }
    else
    {
        $('.sidebar').animate({
            'left' : '-300px'
        }, 500);
    }
    
}


//nav categories
$('.navbar .links .category').on('click', function(){
    if($('.categories-link').css('visibility') == 'hidden')
    {
        
        $('.categories-link').css({
            'visibility' : 'visible' , 'opacity' : '0.0'
        }).animate({
            'opacity' : '1.0'
        }, 700);
        

    }
    else
    {
        $('.categories-link').animate({'opacity': '0.0'}, 700, function(){
            $('.categories-link').css('visibility', 'hidden');
        })

    }
});

//Routing links
$('.route').on('click', function(){
    link = $(this).attr('route');
    window.location.assign(link);
})

//product cart on click script
$(".add-cart").on('click',function(){

    if($(this).attr('status') == 0)
    {
        $(this).text('In cart').css('color', 'rgb(236, 70, 70)');
        $(this).attr('status', '1');
        var curr_qty = $('nav .cart-count').html();
        curr_qty = parseInt(curr_qty) + 1;
        $('nav .cart-count').html(curr_qty);
    }

    else
    {
        $(this).text('Add to cart').css('color', 'gray');
        $(this).attr('status', '0');
        curr_qty = $('nav .cart-count').html();
        if(curr_qty > 0){
            $('nav .cart-count').html(parseInt(curr_qty) - 1);
        }
    }

    $.post("/gstore/en/index.php/store/cart",
    {
        id: $(this).attr('id'),
        status: $(this).attr('status'),
        quantity: '1'
    });

});

//place product on wishlist
$(".add-wish").on('click',function(){

    if($(this).attr('status') == 0)
    {
        $(this).css('color', 'rgb(236, 70, 70)');
        $(this).attr('status', '1');
        var curr_qty = $('nav .wish-count').html();
        curr_qty = parseInt(curr_qty) + 1;
        $('nav .wish-count').html(curr_qty);
    }

    else
    {
        $(this).css('color', 'gray');
        $(this).attr('status', '0');
        curr_qty = $('nav .wish-count').html();
        if(curr_qty > 0){
            $('nav .wish-count').html(parseInt(curr_qty) - 1);
        }
    }

    $.post("/gstore/en/index.php/store/wish",
    {
        id: $(this).attr('id'),
        status: $(this).attr('status'),
        quantity: '1'
    });

});

//change product detail thumb
$('.gallery .thumb img').on('click', function(){
    $('.gallery .thumb img').removeClass('active');
    $(this).addClass('active');
    src = $(this).attr('src');
    $('.gallery .image img').attr('src', src);
})

$('#add-cart .add').on('click', function(){
    curr_qty = $('#add-cart .qty').val();
    $('#add-cart .qty').val(parseInt(curr_qty) + 1); 
})

$('#add-cart .minus').on('click', function(){
    curr_qty = $('#add-cart .qty').val();
    if(curr_qty > '1'){
        $('#add-cart .qty').val(parseInt(curr_qty) - 1);  
    }  
})

star = $('.comment-form label');
star.on('mouseover',function(){
    $(this).css('color','rgb(236, 70, 70)');
    $(this).nextAll().css('color','gray');
    $(this).prevAll().css('color','rgb(236, 70, 70)');
})
star.on('click', function(){
    star.removeClass('active');
    $(this).addClass('active');
})
star.on('mouseout',function(){
    $('.comment-form label.active').css('color','rgb(236, 70, 70)');
    $('.comment-form label.active').nextAll().css('color','gray');
    $('.comment-form label.active').prevAll().css('color','rgb(236, 70, 70)');;
})

$('.comment-form form').submit(function(e){
    e.preventDefault()
    $(this).ajaxSubmit(
        { 
            target:   '#targetLayer', //where to show upload info from uploading php script

            //set initial progress bar width to 0
            beforeSubmit: function()
            {
              $(".comment-form form button").css('background-color','white').html('<div class="lds-dual-ring"></div>');
            },

            success:function ()
            {
                $(".comment-form form button").css('background-color','gray').html('Submit');
                window.location.reload();
        
            },
            resetForm: true 
        }
    );
})

//remove item from cart list in the cart page
$('.remove_cart').on('click', function(){
    $.post("/gstore/en/index.php/store/cart",
    {
        id: $(this).attr('id'),
        status: $(this).attr('status')
    });
    $(this).parents('.item').remove();
    //decrease the cart counter on the navigation menu
    curr_qty = $('nav .cart-count').html();
        if(curr_qty > 0){
            $('nav .cart-count').html(parseInt(curr_qty) - 1);
        }

    //decrease the cart item counter on the cart page
    curr_qty = $('.cart-head .item-no').html();
    if(curr_qty != '0'){
        $('.cart-head .item-no').html(parseInt(curr_qty) - 1);
    }

    //decrease the cart item counter on the banner
    curr_qty = $('.cart-banner-count').html();
    if(curr_qty != '0'){
        $('.cart-banner-count').html(parseInt(curr_qty) - 1);
    }

    //decrease the price item on the summary
    price = $(this).attr('price');
    curr_price1 = $('.cart-summary .sub-total').html();
    curr_price2 = $('.cart-summary .total').html();
    if(curr_price1 != '0' && curr_price2 != '0'){
        $('.cart-summary .sub-total').html(parseInt(curr_price1) - parseInt(price));
        $('.cart-summary .total').html(parseInt(curr_price2) - parseInt(price));
    }
})

//remove item from wish list in the wish page
$('.remove_wish').on('click', function(){
    $.post("/gstore/en/index.php/store/wish",
    {
        id: $(this).attr('id'),
        status: $(this).attr('status')
    });
    $(this).parents('.item').remove();
    //decrease the wish counter on the navigation menu
    curr_qty = $('nav .wish-count').html();
        if(curr_qty > 0){
            $('nav .wish-count').html(parseInt(curr_qty) - 1);
        }

    //decrease the wish item counter on the wish page
    curr_qty = $('.wish-head .item-no').html();
    if(curr_qty != '0'){
        $('.wish-head .item-no').html(parseInt(curr_qty) - 1);
    }

    //decrease the wish item counter on the banner
    curr_qty = $('.wish-banner-count').html();
    if(curr_qty != '0'){
        $('.wish-banner-count').html(parseInt(curr_qty) - 1);
    }

})



$('button.sign-in').on('click', function(){
    $('.register').fadeOut(700);
    setTimeout(function() {
        $('.login').fadeIn(800);
    }, 300);
    
})

$('button.create-account').on('click', function(){
    curr_body_height = $(document).height()
    $('body').css('height', curr_body_height);
    $('.login').fadeOut(700);
    setTimeout(function() {
        $('.register').fadeIn(700);
    }, 600);
    
})

$('form .fa-eye').on('click', function(){
    curr_color = $(this).css('color');
    $(this).css('color','rgb(104, 122, 226)').prev('input').attr('type','text');
    setTimeout(function() {
        $('form .fa-eye').css('color', curr_color).prev('input').attr('type','password');
    }, 600);
})

//submit registration form
$('.register form').submit(function(e){
    e.preventDefault()
    $(this).ajaxSubmit(
        { 
            target:   '#reg-targetLayer', //where to show upload info from uploading php script

            //set initial progress bar width to 0
            beforeSubmit: function()
            {
              $(".register form button").css('background-color','white').html('<div class=" text-danger lds-dual-ring"></div>');
            },

            success:function ()
            {
                $(".register form button").css('background-color','rgb(104, 122, 226)').html('Submit');
                //window.location.reload();
        
            },
            resetForm: true 
        }
    );
})


//submit registration form
$('.login form').submit(function(e){
    e.preventDefault()
    $(this).ajaxSubmit(
        { 
            target:   '#login-targetLayer', //where to show upload info from uploading php script

            //set initial progress bar width to 0
            beforeSubmit: function()
            {
              $(".login form button").css('background-color','white').html('<div class=" text-danger lds-dual-ring"></div>');
            },

            success:function ()
            {
                $(".login form button").css('background-color','rgb(104, 122, 226)').html('Submit');
                if($('#login-targetLayer').text() == 'success')
                {
                    if ($('.redirect').length){
                        redirect = $('.redirect').val();
                    }
                    else{
                        redirect = '/gstore/en';
                    }
                    window.location.assign(redirect);
                }
        
            },
            resetForm: true 
        }
    );
})

$(document).ready(function() {
	
	setTimeout(function(){
		$('.flash-msg').fadeOut(700);
	}, 3000);
	
});

$('#logoutModal form').submit(function(e){
    e.preventDefault();
    $(this).ajaxSubmit(
        { 
            target:   '#targetLayer', //where to show login info

            beforeSubmit: function()
            {
                $("#logoutModal #targetLayer").html('<div class="lds-dual-ring"></div>');
            },

            success:function ()
            {
                //reload page
                if($('#logoutModal #targetLayer').text() == "Success"){
                    location.reload();
                }
            },
            resetForm:  false
        }
    );
});

$(document).ready(function() {
	
	$.getJSON("/gstore/en/assets/javascript/state.json", function(data){
        //console.log(data[0].state.name);
        var list = ' ';
        for (var i=0, len=data.length; i<len; i++){
            list += '<option>'+data[i].state.name+'</option>';
        }
        $('#state').append(list);
    })
	
});


function update_city(state_name){
    json = $.getJSON("/gstore/en/assets/javascript/state.json", function(data){
        for (var i=0, len=data.length; i<len; i++){
            if(data[i].state.name == state_name ){
                var list = ' ';
                for (var u=0, len=data[i].state.locals.length; u<len; u++){
                    list += '<option>'+data[i].state.locals[u].name+'</option>';
                }
                $('#city').html('');
                $('#city').append(list);
                break;
            }
        }
    })
}


$('#state').on('change', function(){
    var st = $(this).val();
    update_city(st);
});

$(document).on('scroll', function(){
    if($(this).scrollTop() > 200)
    {
        $('nav.bottom').css('background-color','black');
    }
    else{
        $('nav.bottom').css('background-color','unset');
    }
});

//display scroll up button when user scroll above 250px
$(document).on('scroll', function(){
    if($(this).scrollTop() > 250)
    {
        $('.pull_up').show();
    }
    else{
        $('.pull_up').hide();
    }
});


//scroll document to top when scroll up button clicked
$(document).on('click', '.pull_up', function(){
    $('html,body').animate({scrollTop:0},700);
});

