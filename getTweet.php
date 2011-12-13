<?php
//@Pfle?Z(g__5
//adoralo : 82JS+RlPwu8U
include 'includes/config.php';
include 'includes/functions.php';
// ************************************************************************
// Trae la media que se solicita onDEMAND
// ************************************************************************

$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
mysql_select_db(BD_NAME);
//echo "SELECT * FROM media ORDER BY fecha_crea DESC LIMIT $top,$maxperpage";
$tweetid = $_GET['tid'];
$res = mysql_query("SELECT * FROM media WHERE tweet_id = '$tweetid'");

$list = '';
$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

while($r = mysql_fetch_assoc($res)){
?>
<style>
	html,body,* 
{
	font-family: Helvetica, Arial, Verdana;
	font-size: 11px;
	margin:0px;
	padding:0px;
}
body{ background-color: #000000; color:#909090; }

#tweetficha {
    background: url("../images/bird_16_blue.png") no-repeat scroll right bottom;
    float: left;
    position: relative;
}
	#tweetfichaimg { float:left; width:40px; height:40px; }
	#tweetfichauser { float:left; width: 182px;}
	#tweetfichauser a{ color: #909090; text-decoration: none; font-weight: bold; padding: 0 0 0 5px; line-height: 35px; font-size: 28px}
	#tweetfichatext { padding: 5px; min-height: 70px; font-size: 14px; background-color: #202020; color: #909090; margin-top: 3px;}
	#tweetfichatext a { color: #e0e0e0; text-decoration: none;}
	#tweetficha p { text-align: right}
	#tweetficha2 { padding: 3px; }
</style>
<div id="tweetficha">
<div id="tweetficha2">
<div id="tweetfichaimg"><img src="<?php echo $r['media']; ?>" border="0" width="40" /></div>
<div id="tweetfichauser"><a href="http://twitter.com/#!/<?php echo $r['tweet_user']; ?>" target="_blank"><?php echo $r['tweet_user']; ?></a></div>
<div style="clear:both"></div>
<div id="tweetfichatext"><?php 
$text = $r['tweet_text'];
if(preg_match($reg_exUrl, $text, $url))
{ 
	echo preg_replace($reg_exUrl, "<a href=".$url[0]." target='_blank'>{$url[0]}</a> ", $text);

} else {
	echo $text;
}
?></div>
<p>
<a href="https://twitter.com/intent/tweet?in_reply_to=<?php $r['tweet_id']; ?>"><img src="images/reply2.png" alt="reply" border="0"/></a>
<a href="https://twitter.com/intent/retweet?tweet_id=<?php $r['tweet_id']; ?>"><img src="images/retweet2.png" alt="reply" border="0"/></a>
<a href="https://twitter.com/intent/favorite?tweet_id=<?php $r['tweet_id']; ?>"><img src="images/favorite2.png" alt="reply" border="0"/></a>&nbsp;&nbsp;&nbsp;&nbsp;
</p>
</div>
</div>
<?php } ?>