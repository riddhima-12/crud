<?php
// redirect if assessed directly
if(!defined('ABSPATH')){
    header("Location: /youtube");
    die();
}
    if(isset($_POST['register'])){
        global $wpdb;
        $fname = $wpdb->escape($_POST['user_fname']);
        $lname = $wpdb->escape($_POST['user_lname']);
        $username = $wpdb->escape($_POST['username']);
        $email = $wpdb->escape($_POST['user_email']);
        $pass = $wpdb->escape($_POST['user_pass']);
        $con_pass = $wpdb->escape($_POST['user_con_pass']);

        if($pass == $con_pass){
            // wp_insert_user()
            // wp_create_user()

            $user_data = array(
                'user_login' => $username,
                'user_email' => $email,
                'first_name' => $fname,
                'last_name' => $lname,
                'display_name' => $fname.' '.$lname,
                'user_pass' => $pass,
            );

            $result = wp_insert_user($user_data);

            if(!is_wp_error($result)){
                echo 'User Created ID:'. $result;
                add_user_meta($result, 'type', 'Intern JSE');
                update_user_meta($result, 'show_admin_bar_front', false);
            }else{
                echo $result->get_error_message();
            }


        }else{
            echo 'Password must match!';
        }
    }
?>

<div class="form-wrapper">
    
<style>
        .form-wrapper {
    width: 100%;
    border-radius: 5px;
    padding: 12px 14px;
    font-size: 18px;
    color: black;
    margin: 10px 0;
    
    background-color: white;
   
    
    box-shadow:0 5px 10px rgba(0,0,0,.8);
}
.box{
    padding: 20px;
    background-color: white;
    box-shadow:0 5px 10px rgba(0,0,0,.1);
  
    width: 500px;
    border-radius: 9px;
    width: 100%;
    border-radius: 5px;
    padding: 12px 14px;
    font-size: 18px;
    color:black;
}
        </style>
    <div class="regi-form">

        <h2>Register</h2>
        <form action="<?php echo get_the_permalink();?>" method="post">
            First Name: <input type="text" name="user_fname" class="box" id="user-fname"></br>
            
            Last Name: <input type="text" name="user_lname"  class="box"id="user-lname"></br>
            
            Username: <input type="text" name="username" class="box" id="username"></br>

            Email: <input type="email" name="user_email"   class="box"id="user-email"></br>
            
            Password: <input type="password" name="user_pass"   class="box"id="user-pass"></br>
            
            Confirm Password: <input type="password" name="user_con_pass" class="box" id="user-con-pass"></br>
            <br>

            
            <input type="submit" class="button" name="register" class="box" value="Register">
      <p>already have an account? <a href="<?php echo site_url();?>/login/">login now</a></p>

        </form>
    </div>
</div>