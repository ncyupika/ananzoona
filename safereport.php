<?php session_start(); ?>
<?php
	include("connect.php");
	$name = $_GET["name"];
	$_SESSION['house_name'] = $name;
	$year = $_GET["year"];
	$group = $_GET['group'];
	$_SESSION['group'] = $group;
	$_SESSION['safereport_year'] = $year;
	$usertype = $_SESSION['usertype'];
	mysqli_select_db($db, "ananzoona" );
	
	if(isset($_GET['type']))
	{
		$type = $_GET['type'];
	}
	
	if (isset($_POST["send"]))
	{
		if($usertype == '導師')
		{
			$sqlupdate = "UPDATE safereport SET 導師複查 = 1 WHERE 房屋資訊 like $name && 學年度 = $year && 成員 = $group;";
			$rows3 = mysqli_query($db,$sqlupdate);
			echo '<script language="javascript">
			alert("導師已複查");
			</script>';
			
			$url = "0815.php";
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url'";
			echo "</script>";
		}
		elseif($usertype == '教官')
		{
			$sqlupdate = "UPDATE safereport SET 教官複查 = 1 WHERE 房屋資訊 like $name && 學年度 = $year && 成員 = $group;";
			$rows3 = mysqli_query($db,$sqlupdate);
			echo '<script language="javascript">
			alert("教官已複查");
			</script>';
			
			$url = "1026_1.php?type=$type";
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url'";
			echo "</script>";
		}
		elseif($usertype == '學生')
		{
			echo '<script language="javascript">
			alert("學生不能修改R");
			</script>';
		}
		elseif($usertype == '超級使用者')
		{
			$sqlupdate = "UPDATE safereport SET 教官複查 = 1 WHERE 房屋資訊 like $name && 學年度 = $year && 成員 = $group;";
			$rows3 = mysqli_query($db,$sqlupdate);
			echo '<script language="javascript">
			alert("教官已複查");
			</script>';
			$url = "1026_1.php?type=$type";
			echo "<script type='text/javascript'>";
			echo "window.location.href='$url'";
			echo "</script>";
		}
		
		
		$sql = "SELECT * FROM safereport WHERE 房屋資訊 like $name && 學年度 = $year && 成員 = $group;";
		$rows = mysqli_query($db , $sql);//執行SQL查詢
		$row = mysqli_fetch_row($rows);
		$ps = $row[0];
		$house = $row[1];
		$member = $row[2];
		$access = $row[3];
		$light = $row[4];
		$fire_extinguisher = $row[5];
		$alart = $row[6];
		$way = $row[7];
		$got_the_way = $row[8];
		$wtf = $row[9];
		$type = $row[10];
		$place = $row[11];
		$ID = $row[12];
		$year = $row[13];
		$teacher_check = $row[14];
		$instructor_check = $row[15];
		$teacher = $row[16];
		$safe = $row[17];
		$fire_date = $row[18];
		
		$check = 0;
		
		$sql_house = "SELECT * FROM house WHERE ID = $house;";
		$rows_house = mysqli_query($db , $sql_house);//執行SQL查詢
		$row_house = mysqli_fetch_row($rows_house);
		$house_rent = $row_house[1];
		$house_address = $row_house[2];
		$house_owner = $row_house[3];
		mysqli_close($db);
	}
	else
	{
		$sql = "SELECT * FROM safereport WHERE 房屋資訊 like $name && 學年度 = $year && 成員 = $group;";
		$rows = mysqli_query($db , $sql);//執行SQL查詢
		$row = mysqli_fetch_row($rows);
		$ps = $row[0];
		$house = $row[1];
		$member = $row[2];
		$access = $row[3];
		$light = $row[4];
		$fire_extinguisher = $row[5];
		$alart = $row[6];
		$way = $row[7];
		$got_the_way = $row[8];
		$wtf = $row[9];
		$type = $row[10];
		$place = $row[11];
		$ID = $row[12];
		$year = $row[13];
		$teacher_check = $row[14];
		$instructor_check = $row[15];
		$teacher = $row[16];
		$safe = $row[17];
		$fire_date = $row[18];
		
		$check = 0;
		
		$sql_house = "SELECT * FROM house WHERE ID = $house;";
		$rows_house = mysqli_query($db , $sql_house);//執行SQL查詢
		$row_house = mysqli_fetch_row($rows_house);
		$house_rent = $row_house[1];
		$house_address = $row_house[2];
		$house_owner = $row_house[3];
		mysqli_close($db);
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>安安租哪-安全回報</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
		<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Main -->
					<div id="main">
						<div class="inner">
							<!-- Header -->
								<header id="header">
									<h2><strong>安全回報</strong></h2>
									<name>歡迎，<strong><?php echo $_SESSION['username'];?></strong><?php if($_SESSION['userisonline']==1) {echo '上線中';}?></br>
									會員種類：<?php echo $_SESSION['usertype']."</br>";?></name>
								</header>
								</br>
								<form name="delete" method="post" action="">
								
	<body>
	
	<?php 
		if ($_SESSION['usertype'] == '導師')
		{ 
			echo '<strong>導師複查:';
			if($row[14] == 0){echo '尚未審查</strong>';}
			else{echo '已審查</strong>';}
		}
		elseif ($_SESSION['usertype'] == '教官')
		{ 
			echo '<strong>教官複查:';
			if($row[15] == 0){echo '尚未審查</strong>';}
			else{echo '已審查</strong>';}
		}
		elseif ($_SESSION['usertype'] == '超級使用者')
		{ 
			echo '<strong>教官複查:';
			if($row[15] == 0){echo '尚未審查</strong>';}
			else{echo '已審查</strong>';}
		}
	?>

	<font size='6' color='red'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;安全等級:</font>
	<?php 
								//include("connect.php");
								//mysqli_select_db($db, "ananzoona" );														
									if($safe == 0) {echo "<font size='6' color='red'>不安全</font>";
								//				$sql_group = "UPDATE maptest SET type = 2 WHERE $safe = 0";
								//				$rows_group = mysqli_query($db , $sql_group);//執行SQL查詢
													}
									else if ($safe == 1) {echo "<font size='6' color='green'>安全</font>";}
								?>
								
	<br><br>

								房屋資訊: <?php echo $house_address;?>
								<!--<input type = "checkbox" name="abc" value="1" id="a">
								<label for="a">很OK</label>
								<input type = "radio" name="abc" value="2" id="b">
								<label for="b">差不多OK</label>
								<input type = "radio" name="abc" value="3" id="c">
								<label for="c">應該OK</label>
								<input type = "radio" name="abc" value="4" id="d">
								<label for="d">非常不OK</label>-->
						<!--		<font size='3' color='red'>安全等級:</font>
								<?php 
								//include("connect.php");
								//mysqli_select_db($db, "ananzoona" );														
						//			if($safe == 0) {echo "<font size='3' color='red'>不安全</font>";
								//				$sql_group = "UPDATE maptest SET type = 2 WHERE $safe = 0";
								//				$rows_group = mysqli_query($db , $sql_group);//執行SQL查詢
						//							}
						//			else if ($safe == 1) {echo '安全';}
								?>
						-->		<br><br>
								
								房屋租金: <?php echo $house_rent;?><br><br>
								房東: <?php echo $house_owner;?><br><br>
								學年度: <?php echo $year;?><br><br>
								成員: <?php 
								include("connect.php");
								mysqli_select_db($db, "ananzoona" );
								$sql_group = "SELECT * FROM `group` WHERE id = '$member';";
								$rows_group = mysqli_query($db , $sql_group);//執行SQL查詢
								$row_group = mysqli_fetch_row($rows_group);
								$num_group = mysqli_num_rows ($rows_group);
								if($num_group >0)
								{
									for($i=0 ; $i<10 ; $i++)
									{
										$sql_member = "SELECT 姓名 FROM `member` WHERE 帳號 = '$row_group[$i]';";
										$rows_member = mysqli_query($db , $sql_member);//執行SQL查詢
										$row_member = mysqli_fetch_row($rows_member);
										if($i == 0)
										{
											echo '<strong>'.$row_member[0].'</strong>'.' ';
											$groupstr = $row_group[0];
										}
										else
										{
											echo $row_member[0].' ';
										}
									}
									mysqli_free_result($rows_member);
								}
								echo '<br><br>';
								mysqli_close($db);
								?>
	<?php
	if($access==1)
	{
		echo "<label><font size='5'>1.租屋處有共同門禁管制</font></label>";
		
		include("connect.php");
		mysqli_select_db($db, "ananzoona" );
		$sql_select = "SELECT * FROM photos WHERE safereport_id = $ID && caption = 'entrance';";
		$rows4 = mysqli_query($db , $sql_select);//執行SQL查詢
		$num3 = mysqli_num_rows ($rows4);
	
		if($num3 >0)
			{ 
				for($i=0 ; $i<$num3 ; $i++)
				{
					while ($row3 = mysqli_fetch_row($rows4)){
					//$row3 = mysqli_fetch_row($rows4);
					$pic_id = $row3[0];
					$pic_name = $row3[1];
					$pic_way = $row3[2];
					$pic_type = $row3[3];
					$pic_safe = $row3[6];
					$pic_checked = $row3[7];
					
					if($pic_checked == 0)
					{
						echo '<font size="3" color="red">尚未審查</font> ';
						$check = 1;
					}
					else
					{
						if ($pic_safe == 0)
						{
							echo '安全等級:安全';
						}
						elseif ($pic_safe == 1)
						{
							echo '安全等級:<font size="3" color="red">不安全</font> ';
						}
					}
					echo '</br>';	
					echo '<a href="photo_check.php?id='.$pic_id.'">出入口</a>';	
					echo '</br>';	
					echo '<img src="'.$pic_way.'" height="200" width="200"/>';
					
					echo '</br>';	
					}
				}
			}
		else
		{
			echo '<font size="3" color="red">尚未繳交照片</font> ';
			$str = '<a target="_blank" href="notice.php?groupstr='.$groupstr.'&type=門禁管制'.'"><img src="http://35.194.238.246/uploads/bell.png" height="20" width="20"/></a>';
			echo $str;
			$check = 1;
		}
				mysqli_free_result($rows4);
	}
	else
	{
		echo "<label><strong><font size='5' color='red'>1.租屋處沒有共同門禁管制</font></strong></label>";
	}
	?><br><br>
	<?php
	if($light==1)
	{
		echo "<label><font size='5'>2.租屋處內或週邊停車場有照明設施</font></label>";
		
		include("connect.php");
		mysqli_select_db($db, "ananzoona" );
		$sql_select = "SELECT * FROM photos WHERE safereport_id = $ID && caption = 'surround';";
		$rows4 = mysqli_query($db , $sql_select);//執行SQL查詢
		$num3 = mysqli_num_rows ($rows4);
	
		if($num3 >0)
			{ 
				for($i=0 ; $i<$num3 ; $i++)
				{
					while ($row3 = mysqli_fetch_row($rows4)){
					//$row3 = mysqli_fetch_row($rows4);
					$pic_id = $row3[0];
					$pic_name = $row3[1];
					$pic_way = $row3[2];
					$pic_type = $row3[3];
					$pic_safe = $row3[6];
					$pic_checked = $row3[7];
					
					if($pic_checked == 0)
					{
						echo '<font size="3" color="red">尚未審查</font> ';
						$check = 1;
					}
					else
					{
						if ($pic_safe == 0)
						{
							echo '安全等級:安全';
						}
						elseif ($pic_safe == 1)
						{
							echo '安全等級:<font size="3" color="red">不安全</font> ';
						}
					}
					echo '</br>';	
					echo '<a href="photo_check.php?id='.$pic_id.'">周遭照明</a>';	
					echo '</br>';	
					echo '<img src="'.$pic_way.'" height="200" width="200"/>';
					
					echo '</br>';	
					}
				}
			}
		else
		{
			echo '<font size="3" color="red">尚未繳交照片</font> ';
			$str = '<a target="_blank" href="notice.php?groupstr='.$groupstr.'&type=照明設施'.'"><img src="http://35.194.238.246/uploads/bell.png" height="20" width="20"/></a>';
			echo $str;
			$check = 1;
		}
				mysqli_free_result($rows4);
	}
	else
	{
		echo "<label><strong><font size='5' color='red'>2.租屋處內或週邊停車場沒有照明設施</font></strong></label>";
	}
	?><br><br>
	<?php
	if($fire_extinguisher==1)
	{
		echo "<label><font size='5'>3.設有滅火器</font></label>";
		
		include("connect.php");
		mysqli_select_db($db, "ananzoona" );
		$sql_select = "SELECT * FROM photos WHERE safereport_id = $ID && caption = 'fire extinguisher';";
		$rows4 = mysqli_query($db , $sql_select);//執行SQL查詢
		$num3 = mysqli_num_rows ($rows4);
	
		if($num3 >0)
			{ 
				for($i=0 ; $i<$num3 ; $i++)
				{
					while ($row3 = mysqli_fetch_row($rows4)){
					//$row3 = mysqli_fetch_row($rows4);
					$pic_id = $row3[0];
					$pic_name = $row3[1];
					$pic_way = $row3[2];
					$pic_type = $row3[3];
					$pic_safe = $row3[6];
					$pic_checked = $row3[7];
					
					if($pic_checked == 0)
					{
						echo '<font size="3" color="red">尚未審查</font> ';
						$check = 1;
					}
					else
					{
						if ($pic_safe == 0)
						{
							echo '安全等級:安全';
						}
						elseif ($pic_safe == 1)
						{
							echo '安全等級:<font size="3" color="red">不安全</font> ';
						}
					}
					echo '</br>';	
					echo '<a href="photo_check.php?id='.$pic_id.'">滅火器</a>';	
					echo '</br>';	
					echo '<img src="'.$pic_way.'" height="200" width="200"/>';
					
					echo '</br>';	
					}
				}
			}
		else
		{
			echo '<font size="3" color="red">尚未繳交照片</font> ';
			$str = '<a target="_blank" href="notice.php?groupstr='.$groupstr.'&type=滅火器'.'"><img src="http://35.194.238.246/uploads/bell.png" height="20" width="20"/></a>';
			echo $str;
			$check = 1;
		}
				mysqli_free_result($rows4);
		
		echo '<br><label>滅火器期限:'.$fire_date .'</label>';
	}
	else
	{
		echo "<label><strong><font size='5' color='red'>3.未設有滅火器</font></strong></label>";
	}
	?><br><br>
	<?php
	if($alart==1)
	{
		echo "<label><font size='5'>4.設有火警警報器或獨立型偵煙偵測器</font></label>";
		
		include("connect.php");
		mysqli_select_db($db, "ananzoona" );
		$sql_select = "SELECT * FROM photos WHERE safereport_id = $ID && caption = 'alarm';";
		$rows4 = mysqli_query($db , $sql_select);//執行SQL查詢
		$num3 = mysqli_num_rows ($rows4);
	
		if($num3 >0)
			{ 
				for($i=0 ; $i<$num3 ; $i++)
				{
					while ($row3 = mysqli_fetch_row($rows4)){
					//$row3 = mysqli_fetch_row($rows4);
					$pic_id = $row3[0];
					$pic_name = $row3[1];
					$pic_way = $row3[2];
					$pic_type = $row3[3];
					$pic_safe = $row3[6];
					$pic_checked = $row3[7];
					
					if($pic_checked == 0)
					{
						echo '<font size="3" color="red">尚未審查</font> ';
						$check = 1;
					}
					else
					{
						if ($pic_safe == 0)
						{
							echo '安全等級:安全';
						}
						elseif ($pic_safe == 1)
						{
							echo '安全等級:<font size="3" color="red">不安全</font> ';
						}
					}
					echo '</br>';	
					echo '<a href="photo_check.php?id='.$pic_id.'">警報器</a>';	
					echo '</br>';	
					echo '<img src="'.$pic_way.'" height="200" width="200"/>';
					
					echo '</br>';	
					}
				}
			}
		else
		{
			echo '<font size="3" color="red">尚未繳交照片</font> ';
			$str = '<a target="_blank" href="notice.php?groupstr='.$groupstr.'&type=警報器'.'"><img src="http://35.194.238.246/uploads/bell.png" height="20" width="20"/></a>';
			echo $str;
			$check = 1;
		}
				mysqli_free_result($rows4);
	}
	else
	{
		echo "<label><strong><font size='5' color='red'>4.沒有火警警報器或獨立型偵煙偵測器</font></strong></label>";
	}
	?><br><br>
	<?php
	if($way==1)
	{
		echo "<label><font size='5'>5.逃生路線暢通並標示清楚</font></label>";
		
		include("connect.php");
		mysqli_select_db($db, "ananzoona" );
		$sql_select = "SELECT * FROM photos WHERE safereport_id = $ID && caption = 'exit';";
		$rows4 = mysqli_query($db , $sql_select);//執行SQL查詢
		$num3 = mysqli_num_rows ($rows4);
	
		if($num3 >0)
			{ 
				for($i=0 ; $i<$num3 ; $i++)
				{
					while ($row3 = mysqli_fetch_row($rows4)){
					//$row3 = mysqli_fetch_row($rows4);
					$pic_id = $row3[0];
					$pic_name = $row3[1];
					$pic_way = $row3[2];
					$pic_type = $row3[3];
					$pic_safe = $row3[6];
					$pic_checked = $row3[7];
					
					if($pic_checked == 0)
					{
						echo '<font size="3" color="red">尚未審查</font> ';
						$check = 1;
					}
					else
					{
						if ($pic_safe == 0)
						{
							echo '安全等級:安全';
						}
						elseif ($pic_safe == 1)
						{
							echo '安全等級:<font size="3" color="red">不安全</font> ';
						}
					}
					echo '</br>';	
					echo '<a href="photo_check.php?id='.$pic_id.'">逃生出口</a>';	
					echo '</br>';	
					echo '<img src="'.$pic_way.'" height="200" width="200"/>';
					
					echo '</br>';	
					}
				}
			}
		else
		{
			echo '<font size="3" color="red">尚未繳交照片</font> ';
			$str = '<a target="_blank" href="notice.php?groupstr='.$groupstr.'&type=逃生路線'.'"><img src="http://35.194.238.246/uploads/bell.png" height="20" width="20"/></a>';
			echo $str;
			$check = 1;
		}
				mysqli_free_result($rows4);
	}
	else
	{
		echo "<label><strong><font size='5' color='red'>5.逃生路線不暢通或標示不清楚</font></strong></label>";
	}
	?><br><br>
	<?php
	if($got_the_way==1)
	{
		echo "<label><font size='5'>6.我知道逃生路線</font></label>";
	}
	else
	{
		echo "<label><strong><font size='5' color='red'>6.不知道逃生路線</font></strong></label>";
	}
	?><br><br>
	<?php
	if($wtf==1)
	{
		
		
		echo "<label><font size='5'>7.請依學校校外宿舍使用熱水器安全診斷表評核</font></label>";
		
		include("connect.php");
		mysqli_select_db($db, "ananzoona" );
		$sql_select = "SELECT * FROM photos WHERE safereport_id = $ID && caption = 'heater';";
		$rows4 = mysqli_query($db , $sql_select);//執行SQL查詢
		$num3 = mysqli_num_rows ($rows4);
	
		if($num3 >0)
			{ 
				for($i=0 ; $i<$num3 ; $i++)
				{
					while ($row3 = mysqli_fetch_row($rows4)){
					//$row3 = mysqli_fetch_row($rows4);
					$pic_id = $row3[0];
					$pic_name = $row3[1];
					$pic_way = $row3[2];
					$pic_type = $row3[3];
					$pic_safe = $row3[6];
					$pic_checked = $row3[7];
					
					if($pic_checked == 0)
					{
						echo '<font size="3" color="red">尚未審查</font> ';
						$check = 1;
					}
					else
					{
						if ($pic_safe == 0)
						{
							echo '安全等級:安全';
						}
						elseif ($pic_safe == 1)
						{
							echo '安全等級:<font size="3" color="red">不安全</font> ';
						}
					}
					echo '</br>';	
					echo '<a href="photo_check.php?id='.$pic_id.'">熱水器</a>';	
					echo '</br>';	
					echo '<img src="'.$pic_way.'" height="200" width="200"/>';
					
					echo '<br><label>熱水器類型: '.$type;
					echo '<br>熱水器地點: '.$place .'</label>';
					}
				}
			}
		else
		{
			echo '<font size="3" color="red">尚未繳交照片</font> ';
			$str = '<a target="_blank" href="notice.php?groupstr='.$groupstr.'&type=熱水器'.'"><img src="http://35.194.238.246/uploads/bell.png" height="20" width="20"/></a>';
			echo $str;
			$check = 1;
		}
				mysqli_free_result($rows4);
	}
	else
	{
		echo "<input type='checkbox' name='check' disabled=''/> <label><strong><font size='5' color='red'>7.請依學校校外宿舍使用熱水器安全診斷表評核</font></strong></label>";
	}
	echo '<br>';
	?>	
	
	<?php
	//0911新增查詢安全回報圖片 
	/*	include("connect.php");
		mysqli_select_db($db, "ananzoona" );
		$sql_select = "SELECT * FROM photos WHERE safereport_id = $ID && caption != 'fire extinguisher' && checked = 1;";
		$rows4 = mysqli_query($db , $sql_select);//執行SQL查詢
		$num3 = mysqli_num_rows ($rows4);
	
		if($num3 >0)
			{ 
				for($i=0 ; $i<$num3 ; $i++)
				{
					while ($row3 = mysqli_fetch_row($rows4)){
					//$row3 = mysqli_fetch_row($rows4);
					$pic_id = $row3[0];
					$pic_name = $row3[1];
					$pic_way = $row3[2];
					$pic_type = $row3[3];
					$pic_safe = $row3[6];
					
					if ($pic_safe == 0)
					{
						echo '安全等級:安全';
					}
					elseif ($pic_safe == 1)
					{
						echo '安全等級:<font size="3" color="red">不安全</font> ';
					}
					echo '</br>';	
					echo '<a target="_blank" href="photo_check.php?id='.$pic_id.'">'.$pic_type.'</a>';	
					echo '</br>';	
					echo '<img src="'.$pic_way.'" height="200" width="200"/>';
					
					echo '</br>';	
					}
				}
			}
				mysqli_free_result($rows4);
					echo '</br>';
		$sql_select = "SELECT * FROM photos WHERE safereport_id = $ID && caption = 'fire extinguisher' && checked = 1;";
		$rows5 = mysqli_query($db , $sql_select);//執行SQL查詢
		$num4 = mysqli_num_rows ($rows5);
		if($num4 >0)
			{ 
				for($i=0 ; $i<$num4 ; $i++)
				{
					while ($row3 = mysqli_fetch_row($rows5)){
					//$row3 = mysqli_fetch_row($rows4);
					$pic_id = $row3[0];
					$pic_name = $row3[1];
					$pic_way = $row3[2];
					$pic_type = $row3[3];
					$pic_safe = $row3[6];
					
					echo '有效日期 : __ 年 __ 月';
					echo '</br>';
					
					if ($pic_safe == 0)
					{
						echo '安全等級:安全';
					}
					elseif ($pic_safe == 1)
					{
						echo '安全等級:<font size="3" color="red">不安全</font> ';
					}
					echo '</br>';	
					echo '<a target="_blank" href="photo_check.php?id='.$pic_id.'">'.$pic_type.'</a>';
					echo '</br>';	
					echo '<img src="'.$pic_way.'" height="200" width="200"/>';	
					echo '</br>';	
					
					}
				}
			}
				mysqli_free_result($rows5);
			
		mysqli_close($db);
	*/	
	?>
	<?php 
		if ($_SESSION['usertype'] == '導師')
		{ 
			if ($row[14] == 0 && $check == 1)
			{ 
				echo '請盡快完成審查';
			} 
			elseif ($row[14] == 0 && $check == 0) 
			{
				echo '<ul class="actions fit"><li><input type="submit" name="send" value="確認審核"/></li></ul> ';
			}
		}
		elseif ($_SESSION['usertype'] == '教官')
		{ 
			if ($row[15] == 0 && $check == 1)
			{ 
				echo '請盡快完成審查';
			}
			else if ($row[15] == 0 && $check == 0)
			{
				echo '<ul class="actions fit"><li><input type="submit" name="send" value="確認審核"/></li></ul> ';
			}
		}
		elseif ($_SESSION['usertype'] == '超級使用者')
		{ 
			if ($row[15] == 0 && $check == 1)
			{ 
				echo '請盡快完成審查';
			}
			else if ($row[15] == 0 && $check == 0)
			{
				echo '<ul class="actions fit"><li><input type="submit" name="send" value="確認審核"/></li></ul> ';
			}
		}
	?>
</form>
								</div>
					</div>
			<div id="sidebar">
						<div class="inner">
							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2>功能</h2>
									</header>
									<ul>
										<li><a href="home.php">首頁</a></li>
										<li><a href="0815.php?sel=<?php 
							include("connect.php");
							mysqli_select_db($db, "ananzoona" );
							$sql2 = "SELECT 學年度 FROM safereport order by 學年度 DESC limit 1";
							$rows2 = mysqli_query($db , $sql2);//執行SQL查詢
							$row = mysqli_fetch_row($rows2);
							echo $row[0];
							?>&check=0">安全回報</a></li>
										
									<?php
										if ($_SESSION['usertype'] == '導師')
										{
											echo '<li><a href="student_manage.php">學生管理</a></li>';
										}
										else if($_SESSION['usertype'] == '超級使用者' || '教官')
										{
											echo '<li><a href="1026.php">系別管理</a></li>';
										}
									?>
									
										<li>
											<span class="opener">個人設定</span>
											<ul>
												<li><a href="member_manager.php">帳號管理</a></li>
												<li><a href="member_manage.php">個人管理</a></li>
											</ul>
										</li>
										<li><a href="suggest.php">聯繫我們</a></li>
										<?php 
											$usertype = $_SESSION['usertype'];
											if ($usertype == '超級使用者')
												{ 
													echo '<li><a href="register0913.php">匯入帳號</a></li>';
												}
										?>
										<li><a href="logout.php">登出</a></li>
									</ul>
								</nav>

								<section>
									<header class="major">
										<h2>軍訓組聯絡方式</h2>
									</header>
									<p>服務時間：０８：００～１７：００</p>
									<ul class="contact">
										<li class="fa-envelope-o">meo@mail.ncyu.edu.tw</li>
										<li class="fa-phone">05-2717312</li>
										<li class="fa-home">24小時緊急電話<br />
										05-2717373</li>
									</ul>
								</section>

							<!-- Footer -->
								<footer id="footer">
									<p class="copyright">&copy; 國立嘉義大學</p>
								</footer>

						</div>
					</div>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>