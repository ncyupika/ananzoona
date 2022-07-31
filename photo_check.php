<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="assets/css/main.css" />
<title>安安租哪-圖片審核</title>
</head>
<body>
<?php
	if (isset($_GET["id"]))
	{
		$_SESSION['photo_id']=$_GET['id'];
		$id = $_GET['id'];
		include("connect.php");
		mysqli_select_db($db, "ananzoona" );
		$sql_select = "SELECT photo_url FROM photos WHERE id = $id;";
		$rows = mysqli_query($db , $sql_select);//執行SQL查詢
		$row = mysqli_fetch_row($rows);
		$num = mysqli_num_rows ($rows);
		if($num!=0)
		{
			echo '<img src="'.$row[0].'" height="700" width="700"/>';
		}
	}
?>
<form>
<input type = "radio" name="abc" value="0" id="b">
<label for="b">安全</label>
<input type = "radio" name="abc" value="1" id="c">
<label for="c">不安全</label>
<input type="submit" name="send" value="確認審核"/>
</form>
</body>
</html>

<?php
	include("connect.php");
	mysqli_select_db($db, "ananzoona" );
	if (isset($_GET["abc"]))
	{
		$safe_level = $_GET['abc'];
		$id = $_SESSION['photo_id'];
		
		$sqlupdate = "UPDATE photos SET safe_level = $safe_level, checked = 1 WHERE id = $id;";
		$rows3 = mysqli_query($db,$sqlupdate);
		
		echo $safe_level;
		
		if ($safe_level == 1)
		{
			$id = $_SESSION['photo_id'];
			include("connect.php");
			mysqli_select_db($db, "ananzoona" );
			$sql_photo = "SELECT safereport_id FROM photos WHERE id = $id;";
			$rows_photo = mysqli_query($db , $sql_photo);//執行SQL查詢
			$row_photo = mysqli_fetch_row($rows_photo);
			
			$sql_safereport = "UPDATE safereport SET safe_level = 0 WHERE ID = $row_photo[0];";
			$rows_safereport = mysqli_query($db , $sql_safereport);//執行SQL查詢
			$row_safereport = mysqli_fetch_row($rows_safereport);
			
			echo '<script language="javascript">
			alert("以更新回報單安全等級");
			</script>';
		}
		
		echo "<script language='javascript'> alert('以更新照片安全等級');  </script>";
		$way = 'Location:safereport.php?name='.$_SESSION['house_name'].'&year='.$_SESSION['safereport_year'].'&group='.$_SESSION['group'];
		header($way);
	}
?>