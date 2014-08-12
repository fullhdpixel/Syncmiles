<?php

/*
 * API Implementation litepaid.eu webshop API
 * Example of new invoice
*/

$api_key = "f5j9ubwi57nonrgyygd8rtywbf7vm7ws37rn9ev4b8ipqqdewhde22038xpjvc2o";

echo $api_key;

// initialize API
$litepaid = new Litepaid($api_key);

// set value
// Fullhdpixel: Should be dynamic value!
$litepaid->setValue(50);

// set test, set this to 1 to test your system.
$litepaid->setTest(1);

// set return url, use of encoded GET variables is allowed
$litepaid->setReturnURL('http://syncfund.com/litepaid/paymentsucceeded.php');

// set description 
$litepaid->setDescription('http://syncfund.com/litepaid/invoicetext.php');

// send invoice
$send = $litepaid->newInvoice();

// do some error handling
if($send !== true) {
	echo $send;
}