<?php session_start();?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>安安租哪-匯入帳號</title>
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
									<h2><strong>匯入帳號</strong></h2>
									<name>歡迎，<strong><?php echo $_SESSION['username'];?></strong><?php if($_SESSION['userisonline']==1) {echo '上線中';}?></br>
									會員種類：<?php echo $_SESSION['usertype']."</br>";?></name>
								</header>
								</br>
								<form id="addform" action="register_batch.php?action=import" method="post" enctype="multipart/form-data"> 
										<h4>請選擇要匯入的CSV檔案：</h4>
											<div class="col-12">
													<ul class="actions">
														<li><input type="file" name="file" value="選擇檔案" /></li>
													</ul>
											</div>
													<ul class="actions fit">
														<li><input type="submit" class="button primary fit">匯入CSV</li>
													</ul>
								</form>
								<form id="exportform" action="register_batch.php?action=export" method="post" enctype="multipart/form-data"> 
													<ul class="actions fit">
														<li><input type="submit" class="button fit">匯出CSV</li>
													</ul>
								</form>
								<form id="exportform" action="home.php" method="post" enctype="multipart/form-data"> 
													<ul class="actions fit">
														<li><input="submit" class="button primary fit">回首頁</li>
													</ul>
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