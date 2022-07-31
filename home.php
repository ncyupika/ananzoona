<!DOCTYPE HTML>
<?php session_start();?>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		
		<title>安安租哪-首頁</title>
		
		<link rel="stylesheet" href="assets/css/main.css" />
		
		<style>
			/* Always set the map height explicitly to define the size of the div
			* element that contains the map. */
			#map {
					height: 500px;
					width: 550px;
				}
			/* Optional: Makes the sample page fill the window. */
			html, body {
				height: 100%;
				margin: 0;
				padding: 0;
				}
		</style>
	</head>
	<body class="is-preload">
		<!-- Wrapper -->
		<div id="wrapper">
			<!-- Main -->
			<div id="main">
				<div class="inner">
					<!-- Header -->
					<header id="header">
						<h2><strong>首頁</strong></h2>
						<name>歡迎，<strong><?php echo $_SESSION['username'];?></strong><?php if($_SESSION['userisonline']==1) {echo '上線中';}?></br>
						會員種類：<?php echo $_SESSION['usertype']."</br>";?></name>
					</header>
					
					<!-- Banner -->
					<section id="banner">
						<div class="content">
							<form method="post" class="a" name="theForm">
								<select name="type" id="demo-category">
									<option value='0'>全部學生</option>
									<option value='1'>已通過</option>
									<option value='2'>未通過</option>
								</select>
								<input type="submit" name="button" id="button" value="搜尋"/>
							</form>
						
							<header>								
								<h1 id="student_name"></h1>								
								<h1 id="student_id"></h1>
								<h3 id="student_adress"></h3>							
								<p></p>
							</header>							
							<br></br>		
							<br></br>
						</div>
						<span class="image object">
							<div id="map"></div>
						</span>
					</section>
					
					<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">
							<!-- Menu -->
							<nav id="menu">
								<header class="major">
									<h2>功能</h2>
								</header>
								<ul>
									<li><a>首頁</a></li>
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
									<li class="fa-home">24小時緊急電話<br />05-2717373</li>
								</ul>
							</section>

							<!-- Footer -->
							<footer id="footer">
								<p class="copyright">&copy; 國立嘉義大學</p>
							</footer>
						</div>
					</div>
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
      var customLabel = {
        '1': {
          label: 'OK'				  
        },
        '2': {
          label: '未通過'
        }
      };

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(23.463408,120.441886),
		  //23.482047, 120.446903/
          zoom:13
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          downloadUrl("http://localhost/ananzoona_1009/map_0912_1.php", function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
			  
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
			  //click 顯示姓名
              var strong = document.createElement('strong');			
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));
			  
			  var strong2 = document.createElement('strong2');
			  strong2.textContent = id
			  infowincontent.appendChild(strong2);
			  //document.getElementById('home.php').click();
			  
			  infowincontent.appendChild(document.createElement('br'));
			  
              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
			  
			  
              var icon = customLabel[type] || {};
			  //ICON 變更
			  //標記地址
              var marker = new google.maps.Marker({
                map: map,
                position: point,
				/*icon: {
				url: 'http://i.imgur.com/YsKYfOw.png',
				size: new google.maps.Size(45, 45),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(0, 20),
				scaledSize: new google.maps.Size(20, 20),
				labelOrigin: new google.maps.Point(9, 8)
				},*/
				//label: {
				//text: '5',
				//fontWeight: 'bold',
				//fontSize: '12px',
				//fontFamily: '"Courier New", Courier,Monospace',
				//color: 'white'
				//}
                label: icon.label
              });
			  //click 顯示資訊
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
				document.getElementById("student_name").innerHTML=name;
				document.getElementById("student_id").innerHTML=id;
				document.getElementById("student_adress").innerHTML=address;				
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqHS9s3XuycFgg65-bBlKLDO4JBkm39RI&callback=initMap">
    </script>

<?php

// 開啟XML檔案，NODE
if (isset($_POST['type']))
{
	$_SESSION['type'] = $_POST['type'];
}
else
{
	$_SESSION['type'] = 1;
}
?>