var height = $(window).height();
$('section.chat-banner').css('height', height+'px');

chat_height = height - 150;
$('.chat').css('height', chat_height+'px');

chat_body_height = chat_height - 70
$('.chat-body').css('height', chat_body_height+'px');

$('.chat-input').on('click', function(){
    $('.message-input').focus();
})


$('#messjage-form').submit(function(e){
    e.preventDefault();
    message = $('.message-input').val();
    id = $('.message-id').val();;
    driver = $('.message-driver').val();
    $('.chat-body').append('<div class="message">'+message+'</div>');
    current_height = $('.chat-body').height();
    $('.chat-body').scrollTop('20000');
    $.post('/gstore/en/index.php/chatbot/chat', {
        message : message,
        userId : id,
        driver : driver
    }, function (data){
        reply = data.messages[0].text;
        setTimeout(function() {
            $('.chat-body').append('<div class="reply">'+reply+'</div>')
            $('.chat-body').scrollTop('20000');
        }, 2000);
    });
});