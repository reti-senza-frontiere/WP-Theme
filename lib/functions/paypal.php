<?php
//ricevo il pagamento
if(isset($_POST['payment_status']) && !empty($_POST['payment_status']) && $_POST['payment_status'] == 'Completed') {
	//recupero i dati
	$amount			= $_POST['mc_gross'];
	$invoice		= (int)$_POST['invoice'];
	$item_name		= $_POST['item_name'];
	$item_number	= (int)$_POST['item_number'];
	$payer_id		= $_POST['payer_id'];
	
	//opzioni email
	$subject		= $_POST['transaction_subject'];
	$message		= json_encode($_POST);
	$headers		= get_email_headers(get_bloginfo('name'), get_option('admin_email'));
	$attachments	= array();
	
	//riceventi della notifica
	$receivers		= array(
		get_option('admin_email'),
		$_POST['business']
	);
	
	//invio
	foreach($receivers as $to) {
		wp_mail($to, $subject, $message, $headers, $attachments); //invio
	}
}

/*
$args = array(
	'amount'			=> '10.00',
	'tax'				=> 22,
	'business'			=> 'mic24676@gmail.com',
	'quantity'			=> 1,
	'item_name'			=> __('Prodotto di test', 'rsf'),
	'item_number'		=> 23,
	'invoice'			=> 51,
	'custom'			=> __('Acquisto da '.get_bloginfo('name'), 'rsf'),
	'sandbox'			=> true
);
*/
function get_paypal_url($args = array()) {
	//parso i valori
	if(isset($args['amount']) && !empty($args['amount']) && is_numeric($args['amount'])) {
		$amount = number_format($args['amount'], 2);
	} else {
		$amount = '10.00';
	}
	
	if(isset($args['business']) && !empty($args['business']) && filter_var($args['business'], FILTER_VALIDATE_EMAIL)) {
		$business = strtolower(trim($args['business']));
	} else {
		$business = 'mic24676@gmail.com';
	}
	
	if(isset($args['quantity']) && !empty($args['quantity']) && is_numeric($args['quantity']) && $args['quantity'] > 0) {
		$quantity = (int)$args['quantity'];
	} else {
		$quantity = 1;
	}
	
	if(isset($args['tax']) && !empty($args['tax']) && is_numeric($args['tax']) && $args['tax'] > 0) {
		$tax = (int)$args['tax'];
		$scorporate_tax = '1.'.$tax;
		$amount = $amount * $quantity;
		$amount = number_format(($amount / $scorporate_tax), 2); //ricalcolo il totale
		$tax = number_format((($amount / 100) * $tax), 2); //calcolo l'iva
	} else {
		$tax = '';
	}
	
	if(isset($args['item_name']) && !empty($args['item_name'])) {
		$item_name = trim($args['item_name']);
	} else {
		$item_name = __('Prodotto di test', 'rsf');
	}
	
	if(isset($args['item_number']) && !empty($args['item_number']) && is_numeric($args['item_number']) && $args['item_number'] > 0) {
		$item_number = (int)$args['item_number'];
	} else {
		$item_number = 23;
	}
	
	if(isset($args['invoice']) && !empty($args['invoice']) && is_numeric($args['invoice']) && $args['invoice'] > 0) {
		$invoice = (int)$args['invoice'];
	} else {
		$invoice = rand(10000,99999);
	}
	
	if(isset($args['custom']) && !empty($args['custom']) && is_numeric($args['custom'])) {
		$custom = trim($args['custom']);
	} else {
		$custom = __('Acquisto da '.get_bloginfo('name'), 'rsf');
	}
	
	if(isset($args['sandbox']) && is_bool($args['sandbox'])) {
		$sandbox = $args['sandbox'];
	} else {
		$sandbox = false;
	}
	
	/* paypal */
	if($sandbox == true) { //se online e' true
		$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //sandbox
	} else { //altrimenti
		$url = 'https://www.paypal.com/cgi-bin/webscr'; //true
	}
	
	//aggiungo var
	$url = add_query_arg('amount', $amount, $url);
	$url = add_query_arg('tax', $tax, $url);
	$url = add_query_arg('business', $business, $url);
	$url = add_query_arg('quantity', $quantity, $url);
	$url = add_query_arg('item_name', $item_name, $url);
	$url = add_query_arg('item_number', $item_number, $url);
	$url = add_query_arg('invoice', $invoice, $url);
	$url = add_query_arg('custom', $custom, $url);
	$url = add_query_arg('notify_url', admin_url('admin-post.php'), $url);
	$url = add_query_arg('shopping_url', home_url('/'), $url);
	$url = add_query_arg('return', add_query_arg('paypal', 'success', home_url('/')), $url);
	$url = add_query_arg('cancel_return', add_query_arg('paypal', 'cancel', home_url('/')), $url);
	$url = add_query_arg('paymentaction', 'sale', $url);
	$url = add_query_arg('currency_code', 'EUR', $url);
	$url = add_query_arg('lc', 'IT', $url);
	$url = add_query_arg('no_note', 1, $url);
	$url = add_query_arg('cmd', '_xclick', $url);
	$url = add_query_arg('no_shipping', 2, $url);
	
	return $url;	
}