 <!-- Footer 
    ================================================ -->
    <footer>
        <div class='container mt-3'>
            <p>© 2019 GSTORE. All Rights Reserved.</p>
        </div>
    </footer>

<script src="<?php echo base_url; ?>/assets/javascript/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url; ?>/assets/javascript/jquery.form.min.js"></script>
<script src="<?php echo base_url; ?>/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url; ?>/assets/javascript/main.script.js"></script>
<script src="<?php echo base_url; ?>/assets/javascript/client.script.js"></script>
<script>
var botmanWidget = {
    frameEndpoint: '/gstore/en/index.php/chatbot/widget',
    chatServer: '/gstore/en/index.php/chatbot/chat',
    userId: '1234', 
    title: 'GStore Support Bot',
    mainColor: 'rgb(7, 105, 170)',
    bubbleBackground: 'rgb(7, 105, 170)',
    aboutText:  'We got you covered',
    desktopHeight: 600,
    desktopWidth: 500,
};
</script>
<script src='<?php echo base_url; ?>/assets/javascript/widget.js'></script>
</body>
<?php
    if(isset($_SESSION['flashMsg']))
    {
        echo $_SESSION['flashMsg'];
        unset($_SESSION['flashMsg']);
    }
?>

<!-- Pull up button 
    ================================================ -->
<div class="pull_up">
    <button class="btn btn-lg btn-danger"><i class="fa fa-arrow-circle-up"></i></button>
</div>