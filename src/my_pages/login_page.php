<?php

require_once  '../class/sql.class.php';

$title = 'Login';

if (isset($_POST['userlogin']) && $_POST['userlogin'] && isset($_POST['usrpasswd']) && $_POST['usrpasswd'])
{
    $pdo = myPDO::getInstance();
    
    $values = [
        'userlogin' => htmlspecialchars($_POST['userlogin']),
        'passwd' =>   htmlspecialchars($_POST['usrpasswd'])
    ];
    
    $error = [];
    $query = "
        SELECT user_id, email, passwd, username, user_email_status, theme FROM users
        WHERE username=:login OR email=:login
        ";
    $sql = $pdo->prepare($query);
    $sql->execute(
            array(
                ':login' => $values['userlogin']
                )
            );
    $count = $sql->rowCount();
    if ($count > 0)
    {
        $result = $sql->fetchAll();    
        foreach($result as $row) 
        {
            if ($row['user_email_status'] == 'verified')
            {
                $values['passwd'] = hash('whirlpool', $values['passwd']);
                if(($values['passwd'] == $row['passwd']) && ($values['userlogin'] == $row['username']
                    || $values['userlogin'] == $row['email']))
                {
                    session_start();
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['theme'] = $row['theme'];
                    header ('location: my_home.php');
                }
                else
                    $error['wrong_user'] = 'Wrong username or password';

            }
            else
                $error['email_status'] = 'Please verify your email';
        }
    }
    else
        $error['wrong_user'] = 'Wrong username or password1';
    
    if (!empty($error))
    {
        {?>
            <div class="alert alert-danger">
            <a class="close" aria-label="close">&times;</a>
            <?php 
                foreach($error as $value)
                    echo "Error: " . $value . "<br>";
            ?>
            </div>
        <?php
        }
    }
}

require_once 'nav_bar.php';
?>
<section class="section login">
<div class="row">
    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <img src="../css_resources/images/9826-Camera-Animation.gif" draggable="false">
        </div>
        <div class="col-md-4">
            <div class="row divform">
            <form  method="POST" id="loginform">
                <h1 style="color:red">Camagru</h1>
                <input type="text" name="userlogin" value="" placeholder="Username or email" required>
                <input type="password" name="usrpasswd" value="" placeholder="Password" required>
                <button type="submit">Log in</button>
            </form>
            <p class="center"><a class="loginlink" href="reset_passwd.php">Forgot password?</a></p>
            </div>
            <div class="row divform">
                 <p class="center"style="color:white">Don't have an account? <a href="sign_up.php" class="loginlink">Sign up</a></p>
            </div> 
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</section>


<?php
    require_once 'footer.php';
?>
