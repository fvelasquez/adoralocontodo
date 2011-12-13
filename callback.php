<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
session_start();
require_once('twitteroauth/twitteroauth.php');
require_once('includes/config.php');
require_once('includes/functions.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  //header('Location: ./clearsessions.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
$_SESSION['oauth_uid'] = $access_token['user_id'];
if(!twitter_user_exist($access_token['user_id'])){
/* Save the access tokens. Normally these would be saved in a database for future use. */
	$ct_con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	$fecha_crea = date('Y-m-d H:i:s');
	$oauth_uid	= $access_token['user_id'];
	$username	= $access_token['screen_name'];
	$oauth_token = $access_token['oauth_token'];
	$oauth_token_secret = $access_token['oauth_token_secret'];
	
	$ct_res = mysql_query("INSERT INTO usuarios (oauth_provider,oauth_uid,oauth_token, oauth_token_secret, oauth_verifier, fecha_crea, estatus, name) VALUES ('Twitter','$oauth_uid','$oauth_token','$oauth_token_secret','{$_REQUEST['oauth_verifier']}','$fecha_crea','A','$username')");
mysql_close($ct_con);
}

$_SESSION['access_token'] = $access_token;

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  header('Location: ./index.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
  //header('Location: ./clearsessions.php');
}
