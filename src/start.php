<?php

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

session_start();

$_SESSION['user_id'] = 1; // A 'fake' User system.

require __DIR__ . '/../vendor/autoload.php';

// PayPal API Credentails.
$api = new ApiContext(
	new OAuthTokenCredential(
		'ClientID',
		'Secret'
	)
);

$api->setConfig([
	'mode' => 'sandbox',
	'http.ConnectionTimeOut' => 30,
	'log.LogEnabled' => false,
	'log.FileName' => '',
	'log.LogLevel' => 'FINE',
	'validation.level' => 'log'
]);

$db = new PDO('mysql:host=127.0.0.1;dbname=site', 'username', 'password'); 

// Selecting all the user data for the user with the id of 1.
$user = $db->prepare("
	SELECT * FROM users
	WHERE id = :user_id
");

// Replacing the tempory varible :user_id with the user id from the session.
$user->execute([
	'user_id' => $_SESSION['user_id']
]);

// Assigning the user varible to the data retrived from the database.
$user = $user->fetchObject();