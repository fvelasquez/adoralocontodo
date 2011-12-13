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
<a onClick="outside_location.setInnerFBML(link_1);" style="cursor: pointer;">Accesar</a>

<div id="outside_location" align="center"></div>
<fb:js-string var="link_1">
<fb:swf
swfbgcolor="000000" imgstyle="border-width:3px; border-color:white;"
swfsrc='http://www.ustream.tv/flash/live/1/7742143?v3=1'
imgsrc='http://img.youtube.com/vi/JOt2Qp0H9G8/2.jpg' width='480' height='296' />
<fb:comments href="http://www.unicef.org.gt"  num_posts="2" width="500" xid="foro1"  title="Foro en vivo"></fb:comments>
</fb:js-string>



<script type="text/javascript" charset="utf-8">
var outside_location = document.getElementById('outside_location');
</script>

