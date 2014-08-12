<?php

require_once('./litepaid/litepaid.php');

//error_reporting(0);

$date = date("Y-m-d");

/* check for errors */
if (isset($_POST['submit'])) {
	$error = array();
				
	if (empty($_POST['selectamount'])) {
		$error[] = 'No amount provided.';
	} else {
		$amount = $_POST['selectamount'];
	}	
	
	if (empty($_POST['name'])) {
		$error[] = 'No name provided.';
	} else {
		$name = $_POST['name'];
	}
	
	if (empty($_POST['airlineprogram'])) {
		$error[] = 'No airline program specified.';
	} else {
		$airlineprogram = $_POST['airlineprogram'];
	}
	
	if (empty($_POST['accountid'])) {
		$error[] = 'No account id provided.';
	} else {
		$accountid = $_POST['accountid'];
	}

	if (empty($_POST['email'])) {
		$error[] = 'No email provided.';
	} else {
	    if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
            $email = $_POST['email'];
        } else {
            $error[] = 'Your email is invalid';
        }
	}
}

/* send receipt to user */
	$headers .= 'From: Syncfund.com <sync@syncfund.com>' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$messageone = '<html><body>';
	$messageone .= '<img src="http://syncfund.com/images/1b.png" alt="Syncfund" /><br>';
	$messageone .= "You filled in the form 'Buy Miles with Sync";
	$messageone .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
	$messageone .= "<tr style='background: #eee;'><td><strong>Amount:</strong></td><td>".$amount."</td></tr>";
	$messageone .= "<tr><td><strong>Name:</strong></td><td>".$name."</td></tr>";
	$messageone .= "<tr style='background: #eee;'><td><strong>Airline Program:</strong></td><td>".$airlineprogram."</td></tr>";
	$messageone .= "<tr><td><strong>Account ID:</strong></td><td>".$accountid."</td></tr>";
	$messageone .= "<tr style='background: #eee;'><td><strong>Email:</td><td>".$email."</td></tr>";
	$messageone .= "</table></body></html>";
	mail($email, 'Userform: Buy Miles with SYNC filled', $messageone, $headers);

/* send mail to sync@syncfund.com */
	$syncemail = "sync@syncfund.com";

	$headers .= 'From: Syncfund.com <sync@syncfund.com>' . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$messageone = '<html><body>';
	$messageone .= '<img src="http://syncfund.com/images/1b.png" alt="Syncfund" /><br>';
	$messageone .= $email." filled in the form 'Buy Miles with Sync";
	$messageone .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
	$messageone .= "<tr style='background: #eee;'><td><strong>Amount:</strong></td><td>".$amount."</td></tr>";
	$messageone .= "<tr><td><strong>Name:</strong></td><td>".$name."</td></tr>";
	$messageone .= "<tr style='background: #eee;'><td><strong>Airline Program:</strong></td><td>".$airlineprogram."</td></tr>";
	$messageone .= "<tr><td><strong>Account ID:</strong></td><td>".$accountid."</td></tr>";
	$messageone .= "<tr style='background: #eee;'><td><strong>Email:</td><td>".$email."</td></tr>";
	$messageone .= "</table></body></html>";
	mail($syncemail, 'Userform: Buy Miles with SYNC filled', $messageone, $headers);

/* create invoice */
$api_key = "f5j9ubwi57nonrgyygd8rtywbf7vm7ws37rn9ev4b8ipqqdewhde22038xpjvc2o";

// initialize API
$litepaid = new Litepaid($api_key);

// set value, either 5-7.5-10k
if ($amount == 5000) {
	$litepaid->setValue(150);
} else if ($amount == 7500) {
	$litepaid->setValue(225);
} else if ($amount == 10000) {
	$litepaid->setValue(300);
}

// set test, set this to 1 to test your system.
$litepaid->setTest(0);

// set return url, use of encoded GET variables is allowed
$litepaid->setReturnURL('http://syncfund.com/NewWebsite/buymiles.html');

// set description 
$litepaid->setDescription('http://syncfund.com/NewWebsite/litepaid/invoicetext.php');

// send invoice
$send = $litepaid->newInvoice();

// error handling
if($send !== true) {
	echo $send;
}

?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
	
    <title>SyncFund | Buy Miles</title>
    <meta name="description" content="Syncfund">
    <meta name="viewport" content="width=device-width">

	<!-- Bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-responsive.min.css">
	
	<!-- Font awesome -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
	
	<!-- Main styling document -->
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/sl-slide.css">
	
	<!-- Other external libraries -->
	<link rel="stylesheet" href="../css/animate.css">
	<link rel="stylesheet" href="../css/docs.css">
    <link rel="stylesheet" href="../css/prettify.css">

    <script src="../js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <link rel="shortcut icon" href="../images/icon.png">
</head>

<body>
<header class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a href="./index.html">
				<img src="../images/logo-small.png" class="animated flipInX" id="logo" alt=""/>
			</a>
			<div class="nav-collapse collapse pull-right">
				<ul class="nav">
					<li><a href="index.html">Home</a></li>
					<li><a href="assets.html">Assets</a></li>
					<li><a href="foundation.html">Foundation</a></li>
					<li class="dropdown active">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Projects <i class="icon-angle-down"></i></a>
						<ul class="dropdown-menu">
						<li><a href="profit-share.html">Sync Profits</a></li>
							<li><a href="whales.html">Sync Whales</a></li>
							<li><a href="club.html">Sync Club</a></li>
							<li><a href="miles.html">Sync Miles</a></li>
							<li><a href="tradeparty.html">Sync Tradeparty</a></li>
							<li><a href="rewards.html">Sync Rewards</a></li>
							<li><a href="kids.html">Sync Kids</a></li>
							<li><a href="whysync.html">Why Sync?</a></li>
						</ul>
					</li>
					<li><a href="news.html">In the news</a></li>
				</ul>
			</div>
		</div>
	</div>
</header>
<body>

<section class="title">
	<div class="container">
		<div class="row-fluid">
			<div class="span6"></div>
		</div>
	</div>
</section> 

<div class="gap"></div>
<div class="container">

<?php
if (!empty($error)) {
	echo '<ol>';
	foreach ($error as $key => $values) { 
		echo '<li>'.$values.'</li>';
	}
	echo '</ol>';
}
?>

</div>
<div class="gap"></div>

<script src="../js/vendor/jquery-1.9.1.min.js"></script>
<script src="../js/vendor/bootstrap.min.js"></script>
<script src="../js/main.js"></script>

</body>
</html>