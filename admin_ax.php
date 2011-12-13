<?php
include 'checkauth.php';
include 'includes/config.php';
include 'includes/functions.php';

if(isset($_GET['ax']) && $_GET['ax'] == 'concursante'){

	$id = $_GET['id'];
	
	$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	//echo "SELECT * FROM media ORDER BY fecha_crea DESC LIMIT $top,$maxperpage";
	$res = mysql_query("UPDATE media SET concurso = 1 WHERE id = '$id'");
	
	header('Location: admin.php');
}

if(isset($_GET['ax']) && $_GET['ax'] == 'delete'){

	$id = $_GET['id'];
	
	$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	//echo "SELECT * FROM media ORDER BY fecha_crea DESC LIMIT $top,$maxperpage";
	$res = mysql_query("DELETE FROM media WHERE id = '$id'");
	
	header('Location: admin.php');
}

if(isset($_GET['ax']) && $_GET['ax'] == 'bloquear'){

	$id = $_GET['id'];
	$tid = $_GET['tid'];
	
	$con = mysql_connect(BD_HOST,BD_USER,BD_PASSWORD);
	mysql_select_db(BD_NAME);
	
	$res = mysql_query("INSERT INTO bloqueados (tweet_user) VALUES ('$tid')");
	//echo "SELECT * FROM media ORDER BY fecha_crea DESC LIMIT $top,$maxperpage";
	$res = mysql_query("DELETE FROM media WHERE id = '$id'");
	
	header('Location: admin.php');
}


?>