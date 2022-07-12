<?php
// redirect if assessed directly
if(!defined('ABSPATH')){
    header("Location: /youtube");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .body{
        
    box-shadow:0 5px 10px rgba(0,0,0,1);
    }
.box{
    padding: 20px;
  
    width: 500px;
    border-radius: 9px;
    width: 60%;
    border-radius: 5px;
    padding: 12px 14px;
    font-size: 18px;
    color:yellowgreen;
 
    box-shadow:0 5px 10px rgba(0,0,0,.7);
    
}

    </style>
<body>
    
<div class="login-form card box">
    <h2>Please Login</h2>
    <form action="<?php echo get_the_permalink();?>" method="post">
        Username: <input type="text" name="username" class="box" id="login-username">
        <br>
<br/>
        Password: <input type="password" name="pass" class="box" id="login-pass">
      <br>
        <br/>
        <input type="submit" name="user_login" value="login">
    </form>
</div>
</body>
</html>