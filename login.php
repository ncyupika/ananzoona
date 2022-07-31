<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>login</title>
</head>
<body>

<?php
$db = @mysqli_connect(
			'35.234.4.135',
			'root',
			'ananzoona');
if ( !$db ) {
	echo "MySQL伺服器連接錯誤!<br/>";
	exit();
}
else {
	echo "MySQL伺服器連接成功!<br/>";
}
mysqli_select_db($db, "ananzoona" );
	$id = $_POST['account'];//取得表單輸入帳號
	$pw = $_POST['password'];//取得表單輸入密碼
	
	$sql = "SELECT * FROM member where 帳號 = '$id'";
	$result = mysqli_query($db,$sql);
	$row = @mysqli_fetch_row($result);
	//姓名
	$_SESSION['username']=$row[2];
	//密碼
	$_SESSION['password']=$row[1];
	//帳號
	$_SESSION['useraccount']=$row[0];
	//種類
	$_SESSION['usertype']= $row[7];
	//上線狀態
	$_SESSION['userisonline']=$row[8];
	//取得資料庫帳號密碼
	$dbid = $_SESSION['useraccount'];
	$dbpw = $_SESSION['password'];
	//判斷資料庫帳號密碼是否一樣
	if($id == $pw && password_verify($pw, $row[1]) && $row[7] != '超級使用者'){		
		header("Location:member_manager.php");
		echo '登入成功!';		
	}
	else{
		if($row[0] == $id && password_verify($pw, $row[1]) && $row[7] == '超級使用者')
		{
			//echo '<script language="javascript">
			//alert("登入成功");
			//window.location.replace("home.php");
			//</script>';
			echo '登入成功!超級使用者';
			$_SESSION['userisonline'] = 1;
			header("Location:home.php");
		}
		elseif($row[0] == $id && password_verify($pw, $row[1]) && $row[7] == '導師')
		{
			echo '登入成功!導師';	
			$_SESSION['userisonline'] = 1;
			header("Location:home.php");
		}
		elseif($row[0] == $id && password_verify($pw, $row[1]) && $row[7] == '教官')
		{
			echo '登入成功!教官';	
			$_SESSION['userisonline'] = 1;
			header("Location:home.php");
		}
		elseif($row[0] == $id && password_verify($pw, $row[1]) && $row[7] == '學生')
		{
			echo '登入成功!學生';	
			$_SESSION['userisonline'] = 1;
			header("Location:home.php");
		}
		else
		{	
			//echo $pw;
			echo '              登入失敗!                 ';
			echo '<script language="javascript">
		alert("帳號或密碼錯誤");
		</script>';
			
			$url = "index.html";
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url'";
			echo "</script>";
		
			//header("Location:index.html");
		}
	}
mysqli_close($db);
?>
</body>
</html>
