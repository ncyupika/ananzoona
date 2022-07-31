<?php
$db = @mysqli_connect(
			'35.234.4.135',
			'root',
			'ananzoona');
if ( !$db ) {
	echo "MySQL伺服器連接錯誤!<br/>";
	exit();
}
?>