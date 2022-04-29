<?php 
$title = "Regénérer";
?>
<!DOCTYPE html>
<html>
    <head>
    	<!-- L'icon du site -->
		<link rel="icon" href="../images/link_company_child_48px.png" type="image/x-icon">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v4.1.1">

        <title>
            <?php if(isset($title)) : ?>
                <?= $title;?>
                <?php else : ?>
                    Mon site
            <?php endif ?>
        </title>

        <!-- Css -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <style type="text/css">
            body{
    margin: 0;
    padding: 0;
     font-family: "Montserrat",sans-serif;
    background:#2EB26E;
    height: 100vh;
    overflow: hidden;
}
.box{
    position: relative;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(0,0,0, .8);
    width: 400px;
    border-radius: 10px;
}
.box img{
     top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.avatar{
    width: 100px;
    height: 100px;
    position:relative;
    top: -90px;
    left: 110px;
}

.box h1{
    text-align: center;
    padding: 0 20px 20px 0;
    color: #fff;
}
.box form{
    padding: 0 40px;
    box-sizing: border-box;
}
.box .inputbox
{
    position: relative;

}
.box .inputbox input
{
    width: 100%;
    padding: 0 5px;
    height: 40px;
    font-size: 16px;
    letter-spacing: 3px;
    margin-bottom: 30px;
    border: none;
    border-bottom: 2px solid #fff;
    outline: none;
    background: transparent;
}
.box .inputbox label
{
    position: absolute;
    float: left;
    top: 10;
    left: 0;
    padding: 10px 5;
    font-size: 13px;
    color: #fff;
    pointer-events: none;
    transition: .5s;
}
.box .inputbox input:focus ~ label,
.box .inputbox input:valid ~ label
{
    top: -18px;
    left: 0px;
    color: #03a9f4;
    font-size: 12px;
}
.pas{
    margin: -5px 0 20px 5px;
    color: rgba(255, 255, 255);
    cursor: pointer;
}
.pas:hover{
    text-decoration: underline;
}
.signup_link{
    margin: 3px;
    text-align: center;
    color: #FFFFFF;
    font-size: 16px;
}
.signup_link a{
    color: #2691d9;
    text-decoration: none;
}

.signup_link a:hover{
    text-decoration:underline;
}

        </style>
    </head>
<body>
    <div class="box">
        <img src="../images/admin/modo.png" class="img-thumbnail avatar">
        <h1>Login</h1> 
        <form method="Post" action="<?= $_SERVER['PHP_SELF']; ?>">
            <div class="inputbox">
                <input type="email" name="email" required="required">
                <label>Email</label>
            </div>
            <div class="inputbox">
                <input type="password" name="password" required="required">
                <label>Mot de passe</label>
            </div>
            <div class="pas">Forgot Password?</div>
            <input type="submit" name="" value="Login" style="width:100%; height:50px; background:#2691d9; border-radius: 25px;font-size: 18px; color: rgba(255, 255, 255); font-weight: 700px; cursor: pointer; outline: none;" >
            <div class="signup_link">
                Not a member yet ? <a href="login.php">Join us</a> 
        </div>
        </form>
        
    </div>
    </div>



<!-- JavaScript -->
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/all.js"></script>
<!-- /.JavaScript -->
    </body>
</html>



