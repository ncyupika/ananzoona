<?php session_start(); ?>
<?php
$groupstr = $_GET['groupstr'];
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
$query = mysqli_query($db,"insert into test_mess (Sendnum,Acceptnum,Ask) values ('$abc','$groupstr',6)");
if($query) { 
		echo "匯入成功"; 
		echo '<script language="javascript">
		alert("已通知");
		</script>';
		echo "<script type='text/javascript'>";
		echo "window.close();";
		echo "</script>";
	}
	else{ 
		echo $groupstr;
		echo $type;
		echo $abc;
		echo '匯入失敗！'; 
	} 

?>