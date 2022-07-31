<?php
session_start();
// 開啟XML檔案，NODE
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
//連線
$db=mysqli_connect ('35.234.4.135','root','ananzoona');
mysqli_select_db($db,"ananzoona" );
$sql = "SELECT * FROM maptest ";
$rows = mysqli_query($db , $sql);

$type = $_SESSION['type'];
if($type==0){
	$sql = "SELECT * FROM maptest";
	$rows2 = mysqli_query($db , $sql);
}else{
$sql2 = "SELECT * FROM maptest WHERE type='$type'";
$rows2 = mysqli_query($db , $sql2);
}
header("Content-type: text/xml");
//讀取到XML檔

while ($row = mysqli_fetch_assoc($rows2)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['ID']);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}
/*
while ($row = mysqli_fetch_assoc($rows)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['ID']);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}*/
echo $dom->saveXML();
?>