<?php session_start(); ?>
<?php
function num($type)
{
	include("connect.php");
	mysqli_select_db($db, "ananzoona" );
	
	$usertype = $_SESSION['usertype'];
	$useraccount = $_SESSION['useraccount'];
	
	//系所學生總人數
	$sql = "SELECT * FROM member WHERE 系所 = '$type'";
	$rows = mysqli_query($db, $sql);
	$num = mysqli_num_rows ($rows);
	
	//所有該系所回報單的群組
	$year = date('Y')-1911;
	$sql_group = "SELECT 成員,導師複查 FROM safereport WHERE 學年度 = '$year' && 系所 = '$type' order by 學年度 DESC";
	$rows_group = mysqli_query($db, $sql_group);
	$num_group = mysqli_num_rows ($rows_group);
	
	$sum = 0;
	$no = 0;
	for($i=0; $i < $num_group; $i++)
	{
		$row_group = mysqli_fetch_row ($rows_group);
		
		$sql_group_num = "SELECT total FROM `group` WHERE id = '$row_group[0]'";
		$rows_group_num = mysqli_query($db, $sql_group_num);
		$row_group_num = mysqli_fetch_row ($rows_group_num);
			
		$sum += $row_group_num[0];
		
		if ($row_group[1] == 1)
		{
			$no += $row_group_num[0];
		}
	}
	
	echo '<td>'.$no.'/'.$num.'</td>';
	
	echo '<td>'.$sum.'/'.$num.'</td>';
	if($num != 0)
	{
		echo '<td>'.(($sum/$num)*100).'%</td>';
	}
	else
	{
		echo '<td>'.'0%'.'</td>';
	}
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
						<name>歡迎，<strong><?php echo $_SESSION['username'];?></strong><?php if($_SESSION['userisonline']==1) {echo '上線中';}?>
							</br>
							會員種類：<?php echo $_SESSION['usertype']."</br>";?>
						</name>
					</header>
					</br>
					<div>
						<h2><strong>教學單位</strong></h2>
						<table>
							<thead>
								<tr>
									<th>單位</th>
									<th>導師已審查</th>
									<th>已繳交</th>
								<tr>
							</thead>
							<tbody>
							<tr> <td colSpan=3><font style="BACKGROUND-COLOR: rgb(144,0,0)" color=#ffffff size=+0>師範學院 </font></td><td></td></tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=教育系'>教育學系暨研究所</a></td>
									<?php
										num('教育系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=輔諮系'>輔導與諮商學系暨研究所</a></td>
									<?php
										num('輔諮系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=體育系'>體育與健康休閒學系暨研究所</a></td>
									<?php
										num('體育系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=特教系'>特殊教育學系暨研究所</a></td>
									<?php
										num('特教系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=幼教系'>幼兒教育學系暨研究所</a></td>
									<?php
										num('幼教系');
									?>
								</tr>								
								<tr>
									<td><a target='_blank' href='1026_1.php?type=數位系'>數位學習設計與管理學系暨研究所</a></td>
									<?php
										num('數位系');
									?>
								</tr>
							<tr> <td colSpan=3><font style="BACKGROUND-COLOR: rgb(144,0,0)" color=#ffffff size=+0>人文藝術學院 </font></td></tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=中文系'>中國文學系暨研究所</a></td>
									<?php
										num('中文系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=視藝系'>視覺藝術系暨研究所</a></td>
									<?php
										num('視藝系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=應歷系'>應用歷史學系暨研究所</a></td>
									<?php
										num('應歷系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=外語系'>外國語言學系暨研究所</a></td>
									<?php
										num('外語系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=音樂系'>音樂學系暨研究所</a></td>
										<?php
										num('音樂系');
									?>
								</tr>
							<tr> <td colSpan=3><font style="BACKGROUND-COLOR: rgb(144,0,0)" color=#ffffff size=+0>管理學院 </font></td></tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=企管系'>企業管理學系暨研究所</a></td>
									<?php
										num('企管系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=應經系'>應用經濟學系暨研究所</a></td>
									<?php
										num('應經系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=生管系'>生物事業管理學系暨研究所</a></td>
									<?php
										num('生管系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=資訊管理'>資訊管理學系暨研究所</a></td>
									<?php									
										num('資訊管理');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=財金系'>財務金融學系暨研究所</a></td>
									<?php
										num('財金系');
									?>
								</tr>								
								<tr>
									<td><a target='_blank' href='1026_1.php?type=行銷系'>行銷與觀光管理學系暨研究所</a></td>
									<?php
										num('行銷系');
									?>
								</tr>
							<tr> <td colSpan=3><font style="BACKGROUND-COLOR: rgb(144,0,0)" color=#ffffff size=+0>農學院 </font></td></tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=農藝系'>農藝學系暨研究所</a></td>
									<?php
										num('農藝系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=園藝系'>園藝學系暨研究所</a></td>
									<?php
										num('園藝系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=森林系'>森林暨自然資源學系暨研究所</a></td>
									<?php
										num('森林系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=木設系'>木質材料與設計學系暨研究所</a></td>
									<?php
										num('木設系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=動科系'>動物科學系暨研究所</a></td>
									<?php
										num('動科系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=生科系'>生物農業科技學系暨研究所</a></td>
									<?php
										num('生科系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=景觀系'>景觀學系暨研究所</a></td>
									<?php
										num('景觀系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=植醫系'>植物醫學系暨研究所</a></td>
									<?php
										num('植醫系');
									?>
								</tr>
							<tr> <td colSpan=3><font style="BACKGROUND-COLOR: rgb(144,0,0)" color=#ffffff size=+0>理工學院 </font></td></tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=電光系'>電子物理學系光電暨固態電子研究所</a></td>
									<?php
										num('電光系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=應化系'>應用化學系暨研究所</a></td>
									<?php
										num('應化系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=應數系'>應用數學系暨研究所</a></td>
									<?php
										num('應數系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=資工系'>資訊工程學系暨研究所</a></td>
									<?php
										num('資工系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=生機系'>生物機電工程學系暨研究所</a></td>
									<?php
										num('生機系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=土木系'>土木與水資源工程學系暨研究所</a></td>
									<?php
										num('土木系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=電機系'>電機工程學系暨研究所</a></td>
									<?php
										num('電機系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=機械系'>機械與能源工程學系</a></td>
									<?php
										num('機械系');
									?>
								</tr>
							<tr> <td colSpan=3><font style="BACKGROUND-COLOR: rgb(144,0,0)" color=#ffffff size=+0>生命科學院 </font></td></tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=食科系'>食品科學系暨研究所</a></td>
									<?php
										num('食科系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=水生系'>水生生物科學系暨研究所</a></td>
									<?php
										num('水生系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=生資系'>生物資源學系暨研究所</a></td>
									<?php
										num('生資系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=生科系'>生化科技學系暨研究所</a></td>
									<?php
										num('生科系');
									?>
								</tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=微藥系'>微生物免疫與生物藥學系暨研究所</a></td>
									<?php
										num('微藥系');
									?>
								</tr>
							<tr> <td colSpan=3><font style="BACKGROUND-COLOR: rgb(144,0,0)" color=#ffffff size=+0>獸醫學院 </font></td></tr>
								<tr>
									<td><a target='_blank' href='1026_1.php?type=獸醫系'>獸醫學系暨研究所</a></td>
									<?php
										num('獸醫系');
									?>
								</tr>
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