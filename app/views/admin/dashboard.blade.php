<!DOCTYPE html>
<html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title> <?php echo $sitename; ?> - Login</title>
        <link rel="stylesheet" href="<?php echo asset(''); ?>css/bootstrap.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo asset(''); ?>css/admin/login.css" type="text/css" />
        <script type="text/javascript" src="<?php echo asset(''); ?>js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo asset(''); ?>js/htmlfive.js"></script>
        <script type="text/javascript" src="<?php echo asset(''); ?>js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo asset(''); ?>js/admin/validate.js"></script>
    </head>
    <body>
        <section class="overflow slide-container">
            <article class="flexcontainer">
                <div class="flexslider">
                    <ul class="slides">
                        <?php $rand = rand(1, 10); ?>
                        <li>
                            <span>
                                <figure>
                                    <img src="http://azooma.co/images/t/<?php echo $rand; ?>.jpg" alt="Sufrati.com" />
                                </figure>  
                            </span>
                        </li>
                    </ul>
                </div>
            </article>
            <div id="main-container">
            <div id="login">
                <div class="form-container">
                    <h1>
                        <a  href="<?php echo route('adminlogin'); ?>" title="<?php echo $sitename; ?>">
                            <img src="<?php echo asset(''); ?>images/<?php echo $logo['image']; ?>"  alt="<?php echo $sitename; ?>"/>
                        </a>
                    </h1> 
                    <?php
                    echo $errors->all() ? '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Oh snap!</strong> please add all fields.</div>' : '';
                    ?> 
                    <form name="loginform" id="loginform" class="left form-horizontal" action="" method="post">
                        <?php
                        $message = Session::get('message');
                        if ($message) {
                            echo '<div class="alert alert-error"><a class="close" data-dismiss="alert">x</a><strong>' . $message . '</strong></div>';
                        }
                        ?>
                        <p>
                            <label>Username<br />
                                <input type="text" name="User" value="<?php echo Input::old('User'); ?>" id="User" class="input required" value="" size="20" tabindex="10" /></label>
                        </p>
                        <p>
                            <label>Password<br />
                                <input type="password" name="Password" id="Password" class="input required" value="" size="20" tabindex="20" /></label>
                        </p>
                        <p>
                            <label>Country<br />                            
                                <select name="country_ID" id="country_ID" class="form-control required" style="width: 335px;" tabindex="30" >
                                    <option value="">Please select User Country</option>
                                    <?php
                                    if (is_object($countries)) {
                                        foreach ($countries as $country) {
                                            $selected = "";
                                            if (isset($usercountry) && $usercountry->id == $country->id) {
                                                $selected = 'selected="selected="';
                                            }
                                            if (Input::old('country_ID') == $country->id) {
                                                $selected = 'selected="selected="';
                                            }
                                            ?>
                                            <option value="<?php echo $country->id; ?>" <?php echo $selected; ?> >
                                                <?php echo $country->name; ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>                
                                </select>
                        </p><br />
                        <p class="submit">
                            <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary" value="Log In" tabindex="40" />
                        </p>
                    </form>
                </div>
                <p id="backtoblog"><a href="<?php echo route('home'); ?>" title="Are you lost?">&larr; Back to <?php echo $sitename; ?> Website</a></p>
            </div>
            </div>
        </section>
    </body>
</html>
<script type="text/javascript">
    $(document).ready(function(){
        $("#loginform").validate({
            messages: {
                User: {
                    required: 'Please Enter Valid Username'
                },
                Password: {
                    required: 'Please Enter Valid Password'
                }
            }
        });
    });    
</script>