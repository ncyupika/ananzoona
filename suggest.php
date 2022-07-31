<?php session_start();?>
<?php
	include("connect.php");
	mysqli_select_db($db, "ananzoona" );
	if (isset($_POST["send"]))
	{		
		$mail_address = $_POST["mail_address"];
		$cellphone = $_POST["cellphone"];
		$address1 = $_POST["address1"];
		$address2 = $_POST["address2"];
		$account = $_SESSION['useraccount'];
		
		$select = "SELECT * FROM member WHERE 帳號 = '$account';";
		$rows2 = mysqli_query($db,$select);//執行查詢
		$row2 = mysqli_fetch_array($rows2);
		echo $account;
		
		//執行修改程式
		$sqlupdate = "UPDATE member SET 信箱 = '$mail_address',電話 = '$cellphone',通訊地址 = '$address1',戶籍地址 = '$address2' WHERE 帳號 = '".$account."'";
		$rows3 = mysqli_query($db,$sqlupdate);	
		if($row2[3])
		{
			echo '修改成功';
			echo '<script language="javascript">
			alert("修改成功");
			window.location.replace("home.php");
			</script>';
		}
		else
		{
			echo '修改失敗';
			echo '<script language="javascript">
			alert("修改失敗");
			window.location.replace("member_manage.php");
			</script>';
		}
	}
	else 
	{
		$id = $_SESSION['useraccount']; //取得帳號
		//$_SESSION['account'] = $id;
		$sql = "SELECT * FROM member WHERE 帳號 = '$id'";
		$rows = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($rows);
		$mail_address = $row[1];
		$cellphone = $row[4];
		$address1 = $row[5];
		$address2 = $row[7];
		mysqli_free_result($rows);	
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>安安租哪-聯繫我們</title>
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
									<h2><strong>聯繫我們</strong></h2>
									<name>歡迎，<strong><?php echo $_SESSION['username'];?></strong><?php if($_SESSION['userisonline']==1) {echo '上線中';}?></br>
									會員種類：<?php echo $_SESSION['usertype']."</br>";?></name>
								</header>
								</br>
													<form method="post" action="#">
														<div class="row gtr-uniform">
														</br>
														姓名：
															<?php echo $_SESSION['username'];?></br>
															<!-- Break -->
															<div class="col-12">
																<textarea name="demo-message" id="demo-message" placeholder="輸入您的建議" rows="6"></textarea>
															</div>
															<!-- Break -->
															<div class="col-12">
																<ul class="actions">
																	<li><input type="submit" value="送出訊息" class="primary" /></li>
																	<li><input type="reset" value="重設欄位" /></li>
																</ul>
															</div>
														</div>
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
							<!-- Section -->
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