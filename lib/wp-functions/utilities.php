<?php
//email in html
function get_email_html_message($template = 'default', $data = '') {
	ob_start();
		include_once(get_template_directory().'/templates/email/'.$template.'.php'); //es. 'contatti'.php
		$html_message = stripslashes(ob_get_contents()); //metto il contenuto in una variabile pulita degli slash
	ob_end_clean();
	return $html_message;
}

//header email
function get_email_headers($name = 'rsf', $noreply = 'noreply@assist.it') {
	$headers	 = 'From: '.$name.' <'.$noreply.'>'."\r\n";
	//$headers	.= 'CC: Name <name@domain.com>'."\r\n";
	//$headers	.= 'Bcc: Name Nascosto <name@domain.com>'."\r\n";
	$headers	.= 'MIME-Version: 1.0'."\r\n";
	$headers	.= 'X-Mailer: PHP/'.phpversion()."\r\n";
	$headers	.= 'Content-Type: text/html; charset="UTF-8"'."\r\n";
	$headers	.= 'Content-Transfer-Encoding: 7bit'."\r\n";
	return $headers;
}

//trovo il video da youtube
function get_youtube_embed_from_url($url, $width = 560, $height = 315) {
	preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
	$code = $matches[1];
	$iframe = '<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$code.'" frameborder="0" allowfullscreen></iframe>';
	return $iframe;
}

//detecto la periferica (0 = desktop, 1 = mobile, 2 = tablet)
function mobile_detect() {
	$user_agent = get_user_info('user_agent'); //trovo l'user agent
	$result = 0; //desktop di default
	
	//apple
	if(strstr($user_agent, 'iPhone') || strstr($user_agent, 'iPod') || strstr($user_agent, 'iPad')) {
        if(strstr($user_agent, 'iPhone') || strstr($user_agent, 'iPod')) $result = 1; //mobile
		if(strstr($user_agent, 'iPad')) $result = 2; //tablet
	}
	
	//android
	if(strstr($user_agent, 'Android')) {
        $result = (strstr($user_agent, 'Mobile')) ? 1 : 2; //mobile o tablet
	}
	
	//altri mobile
	if(strstr($user_agent, 'BlackBerry') || strstr($user_agent, 'Windows Phone') || strstr($user_agent, 'Symbian')) $result = 1; //mobile
	
	//tablet
	if(strstr($user_agent, 'tablet')) $result = 2; //tablet
	
	return $result; //ritorno
}

//se e' mobile
function is_mobile() {
    $return = (mobile_detect() == 1) ? true : false ;
    return $return;
}

//se e' tablet
function is_tablet() {
    $return = (mobile_detect() == 2) ? true : false ;
    return $return;
}

//user info
function get_user_info($var = 'user_agent') {
    $user_agent = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $lang = (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? substr(strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), 0, 2) : 'it' ;
	$user_info = array(
		'user_agent' => $user_agent,
		'ip' => $_SERVER['REMOTE_ADDR'],
		'lang' => $lang,
		'remote_port' => $_SERVER['REMOTE_PORT']
	);
	return $user_info[$var];
}