<section class="chat-banner">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 chat">
                <div class="chat-header">
                    <?php //echo $email ?>
                </div>
                <div class="chat-body">
                    <div class="reply">
                        Hello am Gbot!
                    </div>
                </div>
                <div class="col-12 chat-input">
                    <form method="post" id="message-form" action="<?php echo base_url.'/index.php/chatbot/chat' ?>">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" class="message-input" name="message">
                                <input type="text" class="message-id" name="userId" value="4" hidden>
                                <input type="text" class="message-driver" name="driver" value="web" value hidden>
                                <button type="submit" class="ml-3"><img src="<?php echo base_url.'/images/chatbot/send.png'; ?>" alt=""></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
