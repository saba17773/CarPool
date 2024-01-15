<?php

	session_cache_limiter(false);
	session_start();
	define("site_url", "http://43.225.140.94:8003");
	//define("site_url", "http://192.168.21.166:81/carpool");
	//define("site_url", "http://localhost:81/carpool");

	require "./vendor/autoload.php";
	require "./functions.php";
	require "./mail/PHPMailerAutoload.php";
	
	$app = new \Slim\Slim();
	use Violin\Violin;

	$app->container->singleton("Mail", function () {
		$mail = new PHPMailer;
	    return $mail;
	});

	foreach (glob("./controllers/*.php") as $file) {
		require $file;
	};


