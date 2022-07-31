<?php session_start(); ?>
<?php
include("connect.php");
mysqli_select_db($db, "ananzoona" );
$year = date('Y')-1911;
$usertype = $_SESSION['usertype'];
$useraccount = $_SESSION['useraccount'];
if ($usertype == '導師')
{
	//未審核
	$sql = "SELECT * FROM safereport WHERE 學年度 = '$year' && 導師複查 = 0 && 導師 = '$useraccount' order by safe_level ASC";
	$rows = mysqli_query($db, $sql);
	$num = mysqli_num_rows ($rows);
	
	//已審核
	$sql_checked = "SELECT * FROM safereport WHERE 學年度 = '$year' && 導師複查 = 1 && 導師 = '$useraccount' order by safe_level ASC";
	$rows_checked = mysqli_query($db, $sql_checked);
	$num_checked = mysqli_num_rows ($rows_checked);
	/*
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
	$rows = mysqli_query($db, $sql.' LIMIT '.$start.', '.$per );//執行SQL查詢*/
}
else if($usertype == '超級使用者')
{
	//未審核
	$sql = "SELECT * FROM safereport WHERE 學年度 = '$year' && 導師複查 = 1 && 教官複查 = 0 order by 學年度 DESC";
	$rows = mysqli_query($db, $sql);
	$num = mysqli_num_rows ($rows);
	
	//已審核
	$sql_checked = "SELECT * FROM safereport WHERE 學年度 = '$year' && 教官複查	= 1 order by 學年度 DESC";
	$rows_checked = mysqli_query($db, $sql_checked);
	$num_checked = mysqli_num_rows ($rows_checked);
	/*
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
	$rows = mysqli_query($db, $sql.' LIMIT '.$start.', '.$per );//執行SQL查詢*/
}

mysqli_close($db);
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
						<name>歡迎，<strong><?php echo $_SESSION['username'];?></strong><?php if($_SESSION['userisonline']==1) {echo '上線中';}?>
							</br>
							會員種類：<?php echo $_SESSION['usertype']."</br>";?>
						</name>
					</header>
					</br>
					<div>
						<h2><strong>未審核</strong></h2>
						<table>
							<thead>
								<tr>
									<th>學年度</th>
									<th>成員</th>
									<th>房屋資訊</th>
									<th>安全等級</th>
									<th>視訊</th>
								<tr>
							</thead>
							<tbody>
							<?php
								if($num >0)
								{
									for($i=0 ; $i<$num ; $i++)
									{
										$row = mysqli_fetch_row($rows);
										include("connect.php");
										mysqli_select_db($db, "ananzoona" );
										$sql3 = "SELECT 房屋地址 FROM house WHERE ID = $row[1]";
										$rows3 = mysqli_query($db , $sql3);//執行SQL查詢
										$row3 = mysqli_fetch_row($rows3);
											
										$sql_group = "SELECT * FROM `group` WHERE id = '$row[2]';";
										$rows_group = mysqli_query($db , $sql_group);//執行SQL查詢
										$row_group = mysqli_fetch_row($rows_group);
										$num_group = mysqli_num_rows ($rows_group);
										
										
										echo "<tr>";
										echo "<td>" . $row[13] . "</td>";
										
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
										
										echo "<td>"."<a href ='safereport.php?name=$row[1]&year=$row[13]&group=$row[2]'>$row3[0]</a>"."</td>";
										
										$_SESSION['grouphead'] = $row_group[0] ;
										
										if($row[17] == 0)
										{
											echo '<td><strong><font size="2" color="red">不安全</font></strong></td>';
										}
										else if($row[17] == 1)
										{
											echo '<td>安全</td>';
										}
										
										echo "<td>"."<a target='_blank' href='test_1025_1.php?groupstr=$row_group[0]'>點我聯絡室長</a></td>";										
										
										
										echo "</tr>";
										mysqli_free_result($rows3);
										mysqli_close($db);
									}
									mysqli_free_result($rows);
								}
								else
								{	
									echo "<tr>";
									echo "<td>尚無已繳交回報單!</td><td></td><td></td><td></td><td></td>";
									echo "</tr>";
								}
							?>
							</tbody>
						</table>
					</div>
					
					<div>
						<h2><strong>已審核</strong></h2>
						<table>
							<thead>
								<tr>
									<th>學年度</th>
									<th>成員</th>
									<th>房屋資訊</th>
									<th>安全等級</th>
									<th>視訊</th>
								<tr>
							</thead>
							<tbody>
							
							<?php
								if($num_checked >0)
								{
									for($i=0 ; $i<$num_checked ; $i++)
									{
										$row_checked = mysqli_fetch_row($rows_checked);
										include("connect.php");
										mysqli_select_db($db, "ananzoona" );
										if($row_checked[1] != NULL)
										{
											$sql3 = "SELECT 房屋地址 FROM house WHERE ID = $row_checked[1]";
											$rows3 = mysqli_query($db , $sql3);
											$row3 = mysqli_fetch_row($rows3);
											
											$sql_group = "SELECT * FROM `group` WHERE id = '$row_checked[2]';";
											$rows_group = mysqli_query($db , $sql_group);//執行SQL查詢
											$row_group = mysqli_fetch_row($rows_group);
											$num_group = mysqli_num_rows ($rows_group);
											
											echo "<tr>";
											echo "<td>" . $row_checked[13] . "</td>";
											
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
					
											echo "<td>"."<a href ='safereport.php?name=$row_checked[1]&year=$row_checked[13]&group=$row_checked[2]'>$row3[0]</a>"."</td>";
											
										if($row_checked[17] == 0)
										{
											echo '<td><strong><font size="2" color="red">不安全</font></strong></td>';
										}
										else if($row_checked[17] == 1)
										{
											echo '<td>安全</td>';
										}
											
											echo "<td>"."<a target='_blank' href='test_1025_1.php?groupstr=$row_group[0]'>點我聯絡室長</a></td>";	
											
											echo "</tr>";
											mysqli_free_result($rows3);
										}
										mysqli_close($db);
									}
									mysqli_free_result($rows_checked);
								}
								else
								{	
									echo "<tr>";
									echo "<td>尚無已審核回報單!</td><td></td><td></td><td></td><td></td>";
									echo "</tr>";
								}
							?>
							</tbody>
						</table>
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
<script>
function node(name, child){
	this.name=name;
	this.child=child;
}

function dataHierarchy(){
	// 蘭潭校區
	var lantan=new Array();
	var i=0;
	//lantan[i++]=new node("學院");
	lantan[i++]=new node("農學院", ["農藝學系", "園藝學系", "森林暨自然資源學系","木質材料與設計學系","動物科學系","生物農業科技學系","景觀學系","植物醫學系"]);
	lantan[i++]=new node("理工學院", ["電子物理學系", "應用化學系", "應用數學系", "資訊工程學系","生物機電工程學系","土木與水資源工程學系","電機工程學系","機械與能源工程學系"]);
	lantan[i++]=new node("生命科學學院", ["食品科學系", "水生生物科學系", "生物資源學系","生化科技學系","微生物免疫與生物藥學系"]);
	
	// 民雄校區
	var menhun=new Array();
	var i=0;
	menhun[i++]=new node("師範學院", ["教育學系", "輔導與諮商學系", "體育與健康休閒學系","特殊教育學系","幼兒教育學系","數位學習設計與管理學系"]);
	menhun[i++]=new node("人文藝術學院", ["中國文學系", "視覺藝術系","應用歷史學系","外國語言學系","音樂學系"]);
	
	// 新民校區
	var xhinmen=new Array();
	var i=0;
	xhinmen[i++]=new node("管理學院", ["企業管理學系", "應用經濟學系", "生物事業管理學系","資訊管理學系","財務金融學系","行銷與觀光管理學系"]);
	xhinmen[i++]=new node("獸醫學院", ["獸醫學系"]);
	
	var wwwwwww=new Array();
	var i=0;
	var output=new Array();
	var i=0;
	output[i++]=new node("-----校區-----", wwwwwww);
	output[i++]=new node("蘭潭", lantan);
	output[i++]=new node("民雄", menhun);
	output[i++]=new node("新民", xhinmen);

	return(output);
}
dataTree=dataHierarchy();

// 第三個欄位被更動後的反應動作
//function onChangeColumn3(){
	//updatePath();
//}

// 第二個欄位被更動後的反應動作
function onChangeColumn2(){
	form=document.theForm;
	index1=form.column1.selectedIndex;
	index2=form.column2.selectedIndex;
	index3=form.column3.selectedIndex;
	// Create options for column 3
	for (i=0;i<dataTree[index1].child[index2].child.length;i++)
		form.column3.options[i]=new Option(dataTree[index1].child[index2].child[i], dataTree[index1].child[index2].child[i]);
	form.column3.options.length=dataTree[index1].child[index2].child.length;
	updatePath();
}

// 第一個欄位被更動後的反應動作
function onChangeColumn1() {
	form=document.theForm;
	index1=form.column1.selectedIndex;
	index2=form.column2.selectedIndex;
	index3=form.column3.selectedIndex;
	// Create options for column 2
	for (i=0;i<dataTree[index1].child.length;i++)
		form.column2.options[i]=new Option(dataTree[index1].child[i].name, dataTree[index1].child[i].name);
	form.column2.options.length=dataTree[index1].child.length;
	// Clear column 3
	form.column3.options.length=0;
	updatePath();
}

// 修改所顯示的路徑
/*function updatePath(){
	form=document.theForm;
	index1=form.column1.selectedIndex;
	index2=form.column2.selectedIndex;
	index3=form.column3.selectedIndex;
	if ((index1>=0) && (index2>=0) && (index3>=0)) {
		text1=form.column1.options[index1].text;
		text2=form.column2.options[index2].text;
		text3=form.column3.options[index3].text;
		form.path.value=text1+" ==> "+text2+" ==> "+text3;
	} else
		form.path.value="";
}*/
</script>