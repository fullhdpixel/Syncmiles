<?php

/*
 * API Implementation litepaid webshop API
 * Example how to retrieve information from an invoice
*/

require_once 'litepaid.php';

$api_key = "f5j9ubwi57nonrgyygd8rtywbf7vm7ws37rn9ev4b8ipqqdewhde22038xpjvc2o";

// initialize API
$litepaid = new Litepaid($api_key);

// check payment by id
$payment_result = $litepaid->checkPayment($_GET['litepaid_id']);

if($payment_result === true) {
	echo 'payment success';
} else {
	echo $payment_result;
}