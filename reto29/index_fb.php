<?php

require 'facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '121055541304374',
  'secret' => '3c8aeb126ca5fbc262ab52e28f9ce803',
  'cookie' => true,
));

// We may or may not have this data based on a $_GET or $_COOKIE based session.
//
// If we get a session here, it means we found a correctly signed session using
// the Application Secret only Facebook and the Application know. We dont know
// if it is still valid until we make an API call using the session. A session
// can become invalid if it has already expired (should not be getting the
// session back in this case) or if the user logged out of Facebook.
$session = $facebook->getSession();

$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}

// login or logout url will be needed depending on current user state.
if ($me) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');

?>


<div align="center">
<fb:swf
swfbgcolor="000000" imgstyle="border-width:3px; border-color:white;"
swfsrc='http://www.ustream.tv/flash/live/1/7742143?v3=1'
imgsrc='http://www.unicef.org.gt/foro.jpg' width='480' height='296' />
</div>


<div align="center">
<fb:live-stream event_app_id="153488658046579" width="475" height="1000"/>
</div>




