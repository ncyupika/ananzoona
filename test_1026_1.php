<?php session_start(); ?>
<?php
	include("connect.php");
	mysqli_select_db($db, "ananzoona" );
	
	//系所學生總人數
	$sql = "SELECT * FROM member WHERE 系所 = '資訊管理'";
	$rows = mysqli_query($db, $sql);
	$num = mysqli_num_rows ($rows);
	
	//所有該系所回報單的群組
	$year = date('Y')-1911;
	$sql_group = "SELECT 成員 FROM safereport WHERE 學年度 = '$year' && 系所 = '資訊管理' order by 學年度 DESC";
	$rows_group = mysqli_query($db, $sql_group);
	$num_group = mysqli_num_rows ($rows_group);
	
	echo $num_group;
	
	$sum = 0;
	for($i=0; $i < $num_group; $i++)
	{
		$row_group = mysqli_fetch_row ($rows_group);
		
		if(isset($row_group[0]))
		{
			$sql_group_num = "SELECT total FROM `group` WHERE id = '$row_group[0]'";
			$rows_group_num = mysqli_query($db, $sql_group_num);
			$row_group_num = mysqli_fetch_row ($rows_group_num);
			
			$sum += $row_group_num[0];
			
		}
	}
	echo $sum;
	mysqli_close($db);
?>