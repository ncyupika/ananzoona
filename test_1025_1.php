<!--#!/var/www/html -q
-->
<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>安安租哪-安全回報</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">
		
	</body>
	
</html>
<?php
//echo $_GET['groupstr'];
$groupstr=$_GET['groupstr'];
//echo $_SESSION['username'];
$abc = $_SESSION['username'];
$db = @mysqli_connect(
			'35.234.4.135',
			'root',
			'ananzoona');
if ( !$db ) {
	echo "MySQL伺服器連接錯誤!<br/>";
	exit();
}
else {
	//echo "----正在連接----<br/>";
}
mysqli_select_db($db, "ananzoona" );
$query = mysqli_query($db,"insert into test_mess (Sendnum,Acceptnum,Ask) values ('$abc','$groupstr',4)");
//$query = mysqli_query($db,"insert into test_mess (Ask) values (4)");
if($query) { 
		//$groupstr=$_GET['groupstr'];		
		$url = "https://appr.tc/r/ncyumis_s".$groupstr."";
		echo "<script type='text/javascript'>";
		echo "window.location.href='$url'";
		echo "</script>"; 
	}
	else{ 
		
		echo '匯入失敗！'; 
	} 

?>