<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>安安租哪-TIME</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">
		
	</body>
	
</html>
<?php
//echo $_GET['groupstr'];
//$groupstr=$_GET['groupstr'];
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
$query = mysqli_query($db,"SELECT * FROM `safereport` WHERE ID = '47';");
//$rows = mysqli_query($db , $sql);//執行SQL查詢
		$row = mysqli_fetch_row($query);
		$abc = $row[18];
if($query) { 
		echo $abc;
		echo '正確';
	}
	else{ 
		echo '匯入失敗！'; 
	} 
	
date_default_timezone_set("Asia/Taipei");
//$tempDate = date("Y/m+6/d");
echo date("Y/m/d" , mktime(0,0,0,date("m")+6,date("d"),date("Y")) );
$aaa = date("Y/m/d" , mktime(0,0,0,date("m")+6,date("d"),date("Y")) );
if ($aaa=$abc){
	echo '<br>';
	echo '123';
	
		mail ("chunseven33@gmail.com","滅火器","TEST","from:ncyu108@gmail.com");
}
//echo $tempDate;
?>