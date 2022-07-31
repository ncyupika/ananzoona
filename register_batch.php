<?php
$db = @mysqli_connect('35.234.4.135','root','ananzoona');
$action = $_GET['action']; 
if ($action == 'import') //匯入CSV 
{ 
//匯入處理 
	$filename = $_FILES['file']['tmp_name']; 
	$extension= pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);//取得檔案副檔名
	if(in_array($extension,array('csv'))){//檢查檔案副檔名	
		echo '允許該檔案格式';	
	}
	else{	
		echo '不允許該檔案格式';
		echo '<meta http-equiv=REFRESH CONTENT=1;url=register0913.php>';
		exit; 		
	}
	if(	empty($filename)) { 	
		echo '請確認要匯入的CSV檔案！'; 
		echo '<meta http-equiv=REFRESH CONTENT=1;url=register0913.php>';
		exit; 		
	} 
	echo $filename; 
	echo "<br/>";	
	$handle = fopen($filename, 'r'); 
	$data_values = "";
	$result = input_csv($handle); //解析csv 
	$len_result = count($result); 
	if($len_result==0) { 
		echo '沒有任何資料！'; 
		exit; 
	} 
	//include("hash_pwd.php");
	for($i = 1; $i < $len_result; $i++) {//迴圈獲取各欄位值  
		$name = iconv('big-5', 'utf-8', $result[$i][0]); //中文轉碼 
		$account = $result[$i][1]; 
		$password = $result[$i][2]; 
		$membertype = iconv('big-5', 'utf-8', $result[$i][3]);
		$department = iconv('big-5', 'utf-8', $result[$i][4]);
		$teacher = iconv('big-5', 'utf-8', $result[$i][5]);
		//$pwchange = hash_pwd("$password");
		//$pwchange = password_hash("$password",PASSWORD_BCRYPT);
		//$data_values .= "('$name','$account','$pwchange','$membertype'),"; 
		$pwintodb = password_hash($password,PASSWORD_BCRYPT);//密碼hash儲存在變數pwintodb
		$data_values .= "('$name','$account','$pwintodb','$membertype','$department','$teacher'),"; 
		echo $data_values;
	} 
	$data_values = substr($data_values,0,-1); //去掉最後一個逗號 
	//echo $data_values;
	fclose($handle);
	mysqli_select_db($db,"ananzoona" );
	$query = mysqli_query($db,"insert into member (姓名,帳號,密碼,種類,系所,導師) values $data_values"); //批量插入資料表中 
	if($query) { 
	
	echo '<script language="javascript">
	alert("匯入成功！");
	</script>'; 
	echo '<meta http-equiv=REFRESH CONTENT=1;url=register0913.php>';
	}
	else{ 
		echo '匯入失敗！'; 
	} 
}
elseif($action=='export') //匯出CSV 
{ 
//匯出處理 
mysqli_select_db($db,"ananzoona" );
$result = mysqli_query($db,"select * from member order by 帳號 asc");
$str = "姓名,帳號,密碼\n";
$str = iconv('utf-8','big-5',$str);
while($row=mysqli_fetch_array($result))
	{
		$name= iconv('utf-8','big-5',$row['姓名']);
		//$account = iconv()
		$str .= $name.",".$row['帳號'].",".$row['密碼']."\n";
	}
	$filename = date("Y/m/d H:i:s").'.csv';
	export_csv($filename,$str);
} 
function export_csv($filename,$data)
	{
		header("CONTENT-Type:text/csv");
		header("Content-Disposition:attachment;filename=".$filename);
		header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header('Expires:0');
		header('Pragma:public');
		echo $data;
	}
function input_csv($handle) 
{ 
$out = array (); 
$n = 0; 
while ($data = fgetcsv($handle, 10000)) 
{ 
$num = count($data); 
for ($i = 0; $i < $num; $i++) 
{ 
$out[$n][$i] = $data[$i]; 
} 
$n++; 
} 
return $out; 
}
mysqli_close($db);
?>
