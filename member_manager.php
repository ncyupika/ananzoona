<?php session_start();?>
<?php
	include("connect.php");
	mysqli_select_db($db, "ananzoona" );
	if (isset($_POST["send"])){
		$pw = $_POST["pw"];
		$pw2 = $_POST["pw2"];
		$pw3 = $_POST["pw3"];
		$account = $_SESSION['useraccount'];
		$select = "SELECT * FROM member WHERE 帳號 = '$account';";
		$rows2 = mysqli_query($db,$select);//執行查詢
		$row2 = mysqli_fetch_array($rows2);
		echo $account;
		if($pw != null && $pw2 != null && $pw3 != null)
		{
			//修改密碼與原本一樣
			if (password_verify($pw, $row2[1]))//密碼跟資料庫裡的一樣
			{
				if($pw2 == $pw3)
				{
					if(password_verify($pw2, $row2[1]) || password_verify($pw3, $row2[1]))
					{
						//顯示錯誤資訊
						echo '密碼不能跟原本一樣';
					}
					else
					{
						//執行修改程式
					
						$pwintodb = password_hash($pw3,PASSWORD_BCRYPT);
						$sqlupdate = "UPDATE member SET 密碼 = '$pwintodb' WHERE 帳號 = '".$account."'";
						$rows3 = mysqli_query($db,$sqlupdate);				
						echo '修改成功';
						echo '<script language="javascript">
						alert("修改成功");
						window.location.replace("index.html");
						</script>';
					}					
				}
				else
				{
					
					echo '<script language="javascript">
					alert("新密碼輸入不一樣");
					window.location.replace("index.html");
					</script>';
					echo '新密碼輸入不一樣';
				}
			}
			else
			{
				echo '<script language="javascript">
					alert("舊密碼輸入錯誤");
					window.location.replace("index.html");
					</script>';
				echo '舊密碼輸入錯誤';
				echo $row2[1];
			}
		}
		else
		{
			echo '<script language="javascript">
					alert("密碼不能為空值");
					window.location.replace("member_manager.php");
				</script>';
		}
		
	}
	else 
	{
		$id = $_SESSION['useraccount']; //取得帳號
		$sql = "SELECT * FROM member WHERE 帳號 = '$id'";
		$rows = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($rows);
		mysqli_free_result($rows);	
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>安安租哪-修改密碼</title>
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
									<h2><strong>修改密碼</strong></h2>
									<name>歡迎，<strong><?php echo $_SESSION['username'];?></strong><?php if($_SESSION['userisonline']==1) {echo '上線中';}?></br>
									會員種類：<?php echo $_SESSION['usertype']."</br>";?></name>
								</header>
								</br>
													<form method="post" action="#">
														<div class="row gtr-uniform">
														<div class="col-6 col-12-xsmall">
																帳號: <?php echo $_SESSION['useraccount'];?></br>
																姓名: <?php echo $_SESSION['username'];?>
																<input type="password" name="pw" id="demo-name" value="" placeholder="舊密碼" />
														</br>
																<input type="password" name="pw2" id="demo-name" value="" placeholder="新密碼" />
														</br>
																<input type="password" name="pw3" id="demo-name" value="" placeholder="再次輸入新密碼" />
														</br>
														</div>
														</br>
															<!-- Break -->
															<div class="col-12">
																<ul class="actions">
																	<li><input type="submit" name="send" value="確認修改" class="primary"<?php 
		$userisonline = $_SESSION['userisonline'];
		if ($userisonline==0)
		{ 
			echo 'hidden=""';
		} 
	?> /></li>
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
										<li><a href="0815.php">安全回報</a></li>	
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
												<li><a>帳號管理</a></li>
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