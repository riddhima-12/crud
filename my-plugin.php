<?php
/**
 * Plugin Name:Login regsiter  Plugin
 * Description: This is a my plugin based on wordpress login registration Plugin.
 * Version: 1.0
 * Author: Riddhima@123
 * Author URI: https://riddhima-int@zehntech.com.in
 */

if(!defined('ABSPATH')){
    header("Location: /youtube");
    die();
}

function my_register_form(){
    ob_start();
    include 'public/register.php';
    return ob_get_clean();
}
add_shortcode('my-register-form', 'my_register_form');

function my_login_form(){
    ob_start();
    include 'public/login.php';
    return ob_get_clean();
}
add_shortcode('my-login-form', 'my_login_form');

function my_login(){
    if(isset($_POST['user_login'])){
        $username = esc_sql($_POST['username']);
        $pass = esc_sql($_POST['pass']);
        $credentials = array(
            'user_login' => $username,
            'user_password' => $pass,
        );
        $user = wp_signon($credentials);

        if(!is_wp_error($user)){
            if($user->roles[0] == 'administrator'){
                wp_redirect(admin_url());
                exit;
            }else{
                wp_redirect(site_url('profile'));
                exit;
            }
        }else{
            echo $user->get_error_message();
        }
    }
}
add_action('template_redirect', 'my_login');

function my_profile(){
    ob_start();
    include 'public/profile.php';
    return ob_get_clean();
}
add_shortcode('my-profile', 'my_profile');

function my_check_redirect(){
    $is_user_logged_in = is_user_logged_in();

    if($is_user_logged_in && (is_page('login') || is_page('register'))){
        wp_redirect(site_url('profile'));
        exit;
    }elseif(!$is_user_logged_in && is_page('profile')){
        wp_redirect(site_url('login'));
        exit;
    }
}
add_action('template_redirect', 'my_check_redirect');

function redirect_after_loguot(){
    wp_redirect(site_url('login'));
    exit;
}
add_action('wp_logout', 'redirect_after_loguot');

function my_meta_fields(){
    ?>
    <label for="my-meta-field1">My Meta Field 1</label>
    <input type="text" name="my-meta-field1" id="my-meta-field1" value="<?php echo get_post_meta(get_the_ID(), 'my-meta-data', true);?>"/>
    <?php
}
function add_my_meta_box(){
    add_meta_box('my-meta-box', 'My Meta Box', 'my_meta_fields', 'cars');
}
add_action('add_meta_boxes', 'add_my_meta_box');

function save_my_meta_data($post_id){
    $field_data = $_POST['my-meta-field1'];
    if(isset($_POST['my-meta-field1'])){
        if(get_post_meta($post_id, 'my-meta-data', true) != ''){
            update_post_meta($post_id, 'my-meta-data', $field_data);
        }else{
            add_post_meta($post_id, 'my-meta-data', $field_data);
        }
    }
}
add_action('save_post', 'save_my_meta_data');

function add_my_plugin_action_links($actions, $plugin){
    $plugin_path = plugin_dir_path(__FILE__);
    $new_actions = array();
    if(basename($plugin_path).'/my-plugin.php' == $plugin){
        $new_actions['my_plugin'] = "<a href='admin.php?page=my-plugin-page'>Settings</a>";
        $new_actions['my_plugin2'] = "<a href='admin.php?page=my-plugin-page'>Something</a>";
    }
    return array_merge($new_actions, $actions);
}
add_filter('plugin_action_links', 'add_my_plugin_action_links', 10, 2);