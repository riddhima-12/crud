<?php
// redirect if assessed directly
if(!defined('ABSPATH')){
    header("Location: /youtube");
    die();
}

// if user click on update
if(isset($_POST['update'])){
    $user_id = esc_sql($_POST['user_id']);
    $fname = esc_sql($_POST['user_fname']);
    $lname = esc_sql($_POST['user_lname']);

    if($_FILES['user_img']['error'] == 0 ){
        $file = $_FILES['user_img'];
        $ext = explode('/', $file['type'])[1];
        $file_name = "$user_id.$ext";   // 5.png
        
        if(!metadata_exists('user', $user_id, 'user_profile_img_url')){
            $image = wp_upload_bits($file_name, null, file_get_contents($file['tmp_name']));
            add_user_meta($user_id, 'user_profile_img_url', $image['url']);
            add_user_meta($user_id, 'user_profile_img_path', esc_sql($image['file']));
        }else{
            $profile_img_path = get_usermeta($user_id, 'user_profile_img_path');
            wp_delete_file($profile_img_path);
            $image = wp_upload_bits($file_name, null, file_get_contents($file['tmp_name']));
            update_user_meta($user_id, 'user_profile_img_url', $image['url']);
            update_user_meta($user_id, 'user_profile_img_path', esc_sql($image['file']));
        }
    }

    $userdata = array(
        'ID' => $user_id,
        'first_name' => $fname,
        'last_name' => $lname,
    );
    $user = wp_update_user($userdata);

    if(is_wp_error($user)){
        echo 'Can not update : '.$user->get_error_message();
    }
}

$user_id = get_current_user_id();
$user = get_userdata($user_id);
if($user != false):

    $user_type = get_usermeta($user_id, 'type');
    $fname = get_usermeta($user_id, 'first_name');
    $lname = get_usermeta($user_id, 'last_name');
    $profile_img = get_usermeta($user_id, 'user_profile_img_url');
    // echo $profile_img = get_usermeta($user_id, 'user_profile_img_path');
?>

    <?php
    if($profile_img != ''){
        ?>
        <img src="<?php echo $profile_img; ?>" width="200"/>
        <?php
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
    color:blue;

 
    box-shadow:0 5px 10px rgba(0,0,0,.5);
    
}

    </style>
<body>
<div>
    <div class="box">
    <h3 >Hi <?php echo "$fname $lname ";?></h3>

    <p>Not <?php echo "$fname $lname";?> <a href="<?php echo wp_logout_url();?>">Logout</a></p>
    <br>
    </div>

    <form class="box "action="<?php get_the_permalink();?>" method="post" enctype="multipart/form-data">
        Profile Image: <input type="file" name="user_img" id="user-img" /></br>
        First Name: <input type="text" name="user_fname" id="user-fname" class="box" value="<?php echo $fname;?>"><br/>
        <br>
        Last Name: <input type="text" name="user_lname" id="user-lname"  class="box"value="<?php echo $lname;?>"><br/>
        <input type="hidden" name="user_id" value="<?php echo $user_id;?>">
        <br>
        <input type="submit" name="update" id="update" value="Update">
    </form>
</div>
</body>
</html>
<?php
endif;  // if user ends - if($user != false):
?>