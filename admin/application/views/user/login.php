    <div class="container login">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-4 offset-md-4 offset-sm-2">
                <div class="header">
                    <div class="login-logo">
                        <img src="<?php echo site_url.'/images/admin/login-logo2.jpg' ?>" alt="logo">
                    </div>
                </div>
                <div class="box">
                    <?php
                    if($this->input->get('redirect') != null)
                    {
                        $redirect = $this->input->get('redirect'); //hidden attribute to redirect to desired page after login
                    }
                    else{
                        $redirect = '';
                    }
                    ?>
                    <?php echo form_open('user/login'); ?>
                        <input type="text" name="id" placeholder="USER ID">
                        <input type="password" name="password" placeholder="PASSWORD">
                        <input type="text" name="redirect" hidden value="<?php echo $redirect ?>">
                        <div class=" mt-2 text-danger form-error">
                        <?php 
                        if(isset($error))
                        {
                            echo $error;
                        }
                        ?>
                        </div>
                        <button type="sumbit" name="submit">Sign In</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>