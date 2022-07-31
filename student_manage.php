<?php session_start(); ?>
<?php
include("connect.php");
mysqli_select_db($db, "ananzoona" );
$year = date('Y')-1911;
$usertype = $_SESSION['usertype'];
$useraccount = $_SESSION['useraccount'];

if ($usertype == '導師')
{
	//所有回報單
	$sql = "SELECT 成員 FROM safereport WHERE 學年度 = '$year' && 導師 = '$useraccount' order by 學年度 DESC";
	$rows = mysqli_query($db, $sql);
	$num = mysqli_num_rows ($rows);
	
	$sql_ed = "SELECT * FROM safereport WHERE 學年度 = '$year' && 導師 = '$useraccount' order by 導師複查 ASC";
	$rows_ed = mysqli_query($db, $sql_ed);
	
	$per = 5; //每頁顯示項目數量
	$pages = ceil($num/$per); //取得不小於值的下一個整數
	if (!isset($_GET["page"]))
	{ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } 
	else 
	{
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
	$start = ($page-1)*$per; //每一頁開始的資料序號
	$rows = mysqli_query($db, $sql.' LIMIT '.$start.', '.$per );//執行SQL查詢
}
else if($usertype == '超級使用者')
{
	//所有回報單
	$sql = "SELECT 成員 FROM safereport WHERE 學年度 = '$year' order by 學年度 DESC";
	$rows = mysqli_query($db, $sql);
	$num = mysqli_num_rows ($rows);
	
	$sql_ed = "SELECT * FROM safereport WHERE 學年度 = '$year' order by 導師複查 ASC";
	$rows_ed = mysqli_query($db, $sql_ed);
	
	$per = 5; //每頁顯示項目數量
	$pages = ceil($num/$per); //取得不小於值的下一個整數
	if (!isset($_GET["page"]))
	{ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } 
	else 
	{
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
	$start = ($page-1)*$per; //每一頁開始的資料序號
	$rows = mysqli_query($db, $sql.' LIMIT '.$start.', '.$per );//執行SQL查詢
}

mysqli_close($db);
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>安安租哪-學生管理</title>
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
						<h2><strong>學生管理</strong></h2>
						<name>歡迎，<strong><?php echo $_SESSION['username'];?></strong><?php if($_SESSION['userisonline']==1) {echo '上線中';}?></br>
						會員種類：<?php echo $_SESSION['usertype']."</br>";?></name>
					</header>
					</br>
					<div>
						<h2><strong>未繳交名單</strong></h2>
						<table>
							<thead>
								<tr>
									<th>姓名</th>
									<th>電話</th>
								<tr>
							</thead>
							<tbody>
							<?php
							if ($usertype == '導師')
							{
								include("connect.php");
								mysqli_select_db($db, "ananzoona" );
								$student_search = "SELECT 帳號,姓名,電話 FROM member WHERE 導師 = '$useraccount' && 種類 = '學生' order by 帳號 ASC";
								$rows_student_search = mysqli_query($db, $student_search);
								$num_student_search = mysqli_num_rows ($rows_student_search);
							
								//所有學生
								for($i=0; $i < $num_student_search; $i++)
								{
									$row_student_search = mysqli_fetch_row($rows_student_search);
									
									$in = 0;
									
									$sql = "SELECT 成員 FROM safereport WHERE 學年度 = '$year' && 導師 = '$useraccount' order by 學年度 DESC";
									$rows = mysqli_query($db, $sql);
									
									$a = 0;
									//回報單群組
									while($a < $num)
									{
										$row = mysqli_fetch_row($rows);
										$sql_group = "SELECT * FROM `group` where id = '$row[0]' order by stnumber ASC;";
										$rows_group = mysqli_query($db , $sql_group);
										$num_group = mysqli_num_rows ($rows_group);
									
										$b = 0;
										//群組裡有的人
										while($b < $num_group)
										{
											$row_group = mysqli_fetch_row($rows_group);
											if(in_array($row_student_search[0], $row_group))
											{
												$in = 1;
											}
											$b++;
										}
										$a++;
									}
									if($in == 0)
									{
										echo "<tr>";
										echo "<td>" . $row_student_search[1] . "</td>";
										echo "<td>" . $row_student_search[2] . "</td>";
										$str = '<a target="_blank" href="notice_safereport.php?groupstr='.$row_student_search[0].'">點我催繳</a>';
										echo '<td>'.$str.'</td>';
										echo "</tr>";
									}
								}
							}
							else if($usertype == '超級使用者')
							{
								include("connect.php");
								mysqli_select_db($db, "ananzoona" );
								$student_search = "SELECT 帳號,姓名,電話 FROM member WHERE 種類 = '學生' order by 帳號 ASC";
								$rows_student_search = mysqli_query($db, $student_search);
								$num_student_search = mysqli_num_rows ($rows_student_search);
							
								//所有學生
								for($i=0; $i < $num_student_search; $i++)
								{
									$row_student_search = mysqli_fetch_row($rows_student_search);
									
									$in = 0;
									
									$sql = "SELECT 成員 FROM safereport WHERE 學年度 = '$year' order by 學年度 DESC";
									$rows = mysqli_query($db, $sql);
									
									$a = 0;
									//回報單群組
									while($a < $num)
									{
										$row = mysqli_fetch_row($rows);
										$sql_group = "SELECT * FROM `group` where id = '$row[0]' order by stnumber ASC;";
										$rows_group = mysqli_query($db , $sql_group);
										$num_group = mysqli_num_rows ($rows_group);
									
										$b = 0;
										//群組裡有的人
										while($b < $num_group)
										{
											$row_group = mysqli_fetch_row($rows_group);
											if(in_array($row_student_search[0], $row_group))
											{
												$in = 1;
											}
											$b++;
										}
										$a++;
									}
									if($in == 0)
									{
										echo "<tr>";
										echo "<td>" . $row_student_search[1] . "</td>";
										echo "<td>" . $row_student_search[2] . "</td>";
										
										$str = '<a target="_blank" href="#"><img src="http://35.194.238.246/uploads/158.jpg" height="20" width="20"/></a>';
										echo '<td>'.$str.'</td>';
										
										echo "</tr>";
									}
								}
							}
							?>
							</tbody>
						</table>
					</div>
					<div>
						<h2><strong>已繳交名單</strong></h2>
						<table>
							<thead>
								<tr>
									<th>成員</th>
									<th>回報單連結</th>
									<th>回報單狀態</th>
								<tr>
							</thead>
							<tbody>
							<?php
							if ($usertype == '導師')
							{
								if($num >0)
								{
									for($i=0 ; $i<$num ; $i++)
									{
										$row_ed = mysqli_fetch_row($rows_ed);
										include("connect.php");
										mysqli_select_db($db, "ananzoona" );
										$sql3 = "SELECT 房屋地址 FROM house WHERE ID = $row_ed[1]";
										$rows3 = mysqli_query($db , $sql3);//執行SQL查詢
										$row3 = mysqli_fetch_row($rows3);
											
										$sql_group = "SELECT * FROM `group` WHERE id = '$row_ed[2]';";
										$rows_group = mysqli_query($db , $sql_group);//執行SQL查詢
										$row_group = mysqli_fetch_row($rows_group);
										$num_group = mysqli_num_rows ($rows_group);
										
										
										echo "<tr>";
										
										echo "<td>";
										
										$a = 0;
										while($a < 10)
										{
											$sql_member = "SELECT 姓名 FROM `member` WHERE 帳號 = '$row_group[$a]';";
											$rows_member = mysqli_query($db , $sql_member);
											$row_member = mysqli_fetch_row($rows_member);
											echo $row_member[0].' ';
											$a++;
										}
										mysqli_free_result($rows_member);
										
										echo "</td>";
										
										echo "<td>"."<a href ='safereport.php?name=$row_ed[1]&year=$row_ed[13]&group=$row_ed[2]'>$row3[0]</a>"."</td>";
										
										echo "<td>";
										
										if($row_ed[14]==0)
										{
											echo "尚未審查";
										}
										else
										{
											echo "已審查";
										}
										
										echo "</td>";
										
										echo "</tr>";
										mysqli_free_result($rows3);
										mysqli_close($db);
									}
									mysqli_free_result($rows_ed);
								}
							}
							else if($usertype == '超級使用者')
							{
								if($num >0)
								{
									for($i=0 ; $i<$num ; $i++)
									{
										$row_ed = mysqli_fetch_row($rows_ed);
										include("connect.php");
										mysqli_select_db($db, "ananzoona" );
										$sql3 = "SELECT 房屋地址 FROM house WHERE ID = $row_ed[1]";
										$rows3 = mysqli_query($db , $sql3);//執行SQL查詢
										$row3 = mysqli_fetch_row($rows3);
											
										$sql_group = "SELECT * FROM `group` WHERE id = '$row_ed[2]';";
										$rows_group = mysqli_query($db , $sql_group);//執行SQL查詢
										$row_group = mysqli_fetch_row($rows_group);
										$num_group = mysqli_num_rows ($rows_group);
										
										
										echo "<tr>";
										
										echo "<td>";
										
										$a = 0;
										while($a < 10)
										{
											$sql_member = "SELECT 姓名 FROM `member` WHERE 帳號 = '$row_group[$a]';";
											$rows_member = mysqli_query($db , $sql_member);
											$row_member = mysqli_fetch_row($rows_member);
											echo $row_member[0].' ';
											$a++;
										}
										mysqli_free_result($rows_member);
										
										echo "</td>";
										
										echo "<td>"."<a href ='safereport.php?name=$row_ed[1]&year=$row_ed[13]'>$row3[0]</a>"."</td>";
										
										echo "<td>";
										
										if($row_ed[14]==0)
										{
											echo "尚未審查";
										}
										else
										{
											echo "已審查";
										}
										
										echo "</td>";
										
										echo "</tr>";
										mysqli_free_result($rows3);
										mysqli_close($db);
									}
									mysqli_free_result($rows_ed);
								}
							}
							?>
							</tbody>
						</table>
					</div>
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
					<!-- Section -->
					<section>
						<header class="major">
							<h2>軍訓組聯絡方式</h2>
						</header>
						<p>服務時間：０８：００～１７：００</p>
						<ul class="contact">
							<li class="fa-envelope-o">meo@mail.ncyu.edu.tw</li>
							<li class="fa-phone">05-2717312</li><li class="fa-home">24小時緊急電話<br />05-2717373</li>
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