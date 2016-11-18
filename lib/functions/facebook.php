<?php
/*
//libreria
require_once(get_template_directory().'/lib/packs/facebook-3.2.3/facebook.php'); //fb library

//url della tab
$redirect_uri = 'https://apps.facebook.com/likeusapi/';

//se non c'e' la tab riporta alla home
if(empty($redirect_uri)) $redirect_uri = home_url();

//facebook object
$facebook = new Facebook(array(
    'appId' => 1613140392263399,
    'secret' => '4eeeacc1147147f435d3224a96aea68b'
));

//parametri di login app
$login_params = array(
    'scope' => 'email,public_profile',
    'redirect_uri' => $redirect_uri
);

//facebook var
$facebook_uid = $facebook->getUser();
$facebook_access_token = $facebook->getAccessToken();
$facebook_login_url = $facebook->getLoginUrl($login_params);

if($facebook_uid) { //connesso
    $user_profile = $facebook->api('/'.$facebook_uid, 'GET');
    print_r($user_profile);
} else { //NON connesso
    ?>
    <a href="<?php echo $facebook_login_url; ?>" target="_top"><img src="<?php echo get_template_directory_uri_images(); ?>/fb-login.png" alt="<?php echo __('Accedi con Facebook', 'rsf'); ?>" /></a>
    <?php
}
*/