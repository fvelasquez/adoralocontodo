<?php
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);
function totalpages(){
	
	$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	$res = mysql_query("SELECT count(*) as total FROM media");
	$tot = mysql_fetch_assoc($res);
	mysql_close($con);
	
	return ceil($tot['total']/29);
}

function get_facebook_cookie($app_id, $app_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $app_secret) != $args['sig']) {
    return null;
  }
  return $args;
}

function check_tweet($tweetid){

	$ct_con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	$ct_res = mysql_query("SELECT * FROM media WHERE tweet_id = '$tweetid'");
	$cti = 0;
	while($ctr = mysql_fetch_assoc($ct_res))
	{
		$cti++;
	}
	
	if($cti == 0){
		return False;
	}else{
		return True;
	}
	mysql_close($ct_con);
}

function twitter_user_exist($tuser)
{
	$ate_con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	$aet_res = mysql_query("SELECT * FROM usuarios WHERE oauth_uid = '$tuser'");
	$aeti = 0;
	while($aetr = mysql_fetch_assoc($aet_res))
	{
		$aeti++;
	}
	
	if($aeti == 0){
		return False;
	}else{
		return True;
	}
	mysql_close($aet_con);
}
function get_url_content($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_URL,"http://oohembed.com/oohembed/?url=".urlencode($url));
	curl_setopt($ch, CURLOPT_URL,"http://api.embed.ly/1/oembed?url=".urlencode($url)."&key=b235bd9e057e11e191834040d3dc5c07");
	$oembed = curl_exec($ch);
	$oembed	= json_decode($oembed);
	curl_close($ch);
	
	return $oembed;
}

function form_video_media($lnk,$provider)
{
		
		$ivideo			= $lnk;
		$link			= $lnk;
		switch($provider){
		case 'YouTube':
			$lnk 			= explode('v=',$ivideo);
			$link 			= 'http://www.youtube.com/v/'.$lnk[1].'?version=3&amp;hl=es_ES';
		break;
		case 'Vimeo':
			$lnk			= explode('.com/',$ivideo);
			$link 			= 'http://vimeo.com/moogaloop.swf?clip_id='.$lnk[1].'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00adef&amp;fullscreen=1&amp;autoplay=0&amp;loop=0';
		break;
		case 'Tumblr':
			$media			= 'images/video_tumblr.png';
			$lnk			= $lnk;
		break;
		default:
			$media			= 'images/video_generico.png';
			$lnk			= $lnk;
		break;
		}
		
		return $link;
}

function form_photo_media($lnk,$media,$provider)
{
		$link = $lnk;
		switch($provider){
			case 'Twitpic':
				$tlink			= $link;
				$link			= $media;
				$media			= $tlink;
			break;
			default:
				$tlink			= $link;
				$link			= $media;
				$media			= $tlink;
			break;
		}
		
		return $link;
}

function isbloqued($tuser){
	$ib_con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	$ib_res = mysql_query("SELECT * FROM bloqueados WHERE tweet_user = '$tuser'");
	$ibi = 0;
	while($ibr = mysql_fetch_assoc($ib_res))
	{
		$ibi++;
	}
	
	if($ibi == 0){
		return False;
	}else{
		return True;
	}
	mysql_close($ib_con);
}

function insert_tweet($rtweets){

	$it_con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);

	$media_provider = 'Twitter';

	$ttweets = count($rtweets);
	$htweet = '';
	for($i = 0;$i < $ttweets;$i++)
	{

		$link = '';
		$media = '';
		
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		$text = $rtweets[$i]->text;
		$ooembed = '';
		$media_width = '150px';
		$media_height = '150px';
		
		$fecha_c = new DateTime($rtweets[$i]->created_at);
		$fecha_crea = $fecha_c->format('Y-m-d H:i:s');
		$tweet_user = $rtweets[$i]->from_user;
		$tweet_id = $rtweets[$i]->id_str;
		$oauth_uid = $rtweets[$i]->from_user_id;
		$tweet_text = $rtweets[$i]->text;
		$titulo = $rtweets[$i]->from_user;
		$descripcion = '';
		$media_tipo = 'tweet';
		$media_html = '';
		$media_provider = 'Twitter';
		if(!isbloqued($tweet_user))
		{
		if(!check_tweet($tweet_id)){
		
			if(preg_match($reg_exUrl, $text, $url))
			{ 
				$urllist = $url[0]; 
				$ooembed = get_url_content($urllist);
			}
		
			$media = $rtweets[$i]->profile_image_url;
		
			if($ooembed != '')
			{
				if($ooembed->type == 'video')
				{
					$link 	= form_video_media($ooembed->url,$ooembed->provider_name);
					$media  = $ooembed->thumbnail_url;
					$media_width = $ooembed->width;
					$media_height = $ooembed->height;
				}
				if($ooembed->type == 'photo')
				{
					$link 	= form_photo_media($ooembed->url,$ooembed->url,$ooembed->provider_name);
					$media 	= form_photo_media($ooembed->url,$ooembed->url,$ooembed->provider_name);
					$media_width = $ooembed->width;
					$media_height = $ooembed->height;
				}
			}
		
		
			$it_res = mysql_query("INSERT INTO media (oauth_uid, fecha_crea, media, link, titulo, descripcion, media_tipo, media_html, media_provider, media_width, media_height, tweet_id, tweet_user, tweet_text) VALUES ('$oauth_uid','$fecha_crea','$media', '$link','$titulo','$descripcion','$media_tipo','$media_html','$media_provider','$media_width','$media_height','$tweet_id','$tweet_user','$tweet_text')");
			//echo "INSERT INTO media (oauth_uid, fecha_crea, media, link, titulo, descripcion, media_tipo, media_html, media_provider, media_width, media_height, tweet_id, tweet_user, tweet_text) VALUES ('$oauth_uid','$fecha_crea','$media', '$link','$titulo','$descripcion','$media_tipo','$media_html','$media_provider','$media_width','$media_height','$tweet_id','$tweet_user','$tweet_text')";

		}
		}
}

mysql_close($it_con);
}
?>