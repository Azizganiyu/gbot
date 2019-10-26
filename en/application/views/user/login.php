<?php
if(isset($_GET['redirect']))
{
    $_SESSION['flashMsg'] = "<div class='flash-msg'>You must sign in to continue!</div>";
    echo '<input class="redirect" type="text" value ="'.$_GET["redirect"].'" hidden/>';
}
?>
<div class="container r-l-f-container login">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1 mt-5 r-l-f">
            <div class="row">
                <div class="col-12 col-md-7 left">
                    <div class="form-section">
                        <div class="form-header">
                            <h2>Sign in to Gstore</h2>
                            <p class="text-secondary">Enter your login details to continue</p>
                        </div>
                        <form action="<?php echo base_url.'/index.php/users/login' ?>" method="post">
                            <div class="form">
                                <i class="fa fa-envelope mr-3"></i><input required type="email" name="email" placeholder="Email">
                            </div>
                            <div class="form">
                                <i class="fa fa-lock mr-3"></i><input required type="password" name="password" placeholder="Password">
                                <i class="fa fa-eye"></i>
                            </div>
                            <div class="remember">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" name="remember" value="yes" id="remember" type="checkbox">
                                    <label class="custom-control-label text-secondary" for="remember"> Remember me </label>
                                </div>
                            </div>
                            <div class="submit-button">
                                <button type="submit" name="submit">SIGN IN</button>
                            </div>
                            <div class="mt-3" id="login-targetLayer"></div>
                            <div class="forgot-password text-center mt-4">
                                <a class="btn btn-sm btn-link text-secondary">forgot password?</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-5 right">
                    <div class="header">
                        <a class="btn btn-link text-light" href="<?php echo base_url ?>"><span class="gadget">G</span><span class="store">STORE</span></a>
                    </div>
                    <hr style="border-color: white;"/>
                    <div class="info">
                        <h1>Hello, Friend!</h1>
                        <p>Enter your personal detail<br/>and start journey with us.</p>
                    </div>
                    <div class="button">
                        <button class="create-account">SIGN UP</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>


<div class="container r-l-f-container register">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1 mt-5 r-l-f">
            <div class="row">
                <div class="col-12 col-md-5 right">
                    <div class="header">
                        <span class="gadget">G</span><span class="store">STORE</span>
                    </div>
                    <hr style="border-color: white;"/>
                    <div class="info">
                        <h1>Welcome Back!</h1>
                        <p>To keep connected with us please <br/> login with your personal info</p>
                    </div>
                    <div class="button">
                        <button class="sign-in">SIGN IN</button>
                    </div>
                </div>
                <div class="col-12 col-md-7 left">
                    <div class="form-section">
                        <div class="form-header">
                            <h2>Create Account</h2>
                        </div>
                        <form action="<?php echo base_url.'/index.php/users/register' ?>" method="post">
                            <div class="form">
                                <i class="fa fa-user mr-3"></i><input required type="text" name="name" placeholder="Name">
                            </div>
                            <div class="form">
                                <i class="fa fa-envelope mr-3"></i><input required type="email" name="email" placeholder="Email">
                            </div>
                            <div class="form">
                                <i class="fa fa-lock mr-3"></i><input required type="password" name="password" placeholder="Password">
                                <i class="fa fa-eye"></i>
                            </div>
                            <div class="submit-button">
                                <button type="submit" name="submit">SIGN UP</button>
                            </div>
                            <div class="mt-3" id="reg-targetLayer"></div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<?php
    if(isset($_SESSION['flashMsg']))
    {
        echo $_SESSION['flashMsg'];
        unset($_SESSION['flashMsg']);
    }
?>

