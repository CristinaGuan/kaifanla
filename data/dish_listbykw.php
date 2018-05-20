<?php
/*根据菜名/原料中的关键字查询菜品，以JSON格式*/
header('Content-Type: application/json');

//接收客户端提交的数据
@$kw = $_REQUEST['kw']; //查询关键字
if( !isset($kw) ){
    echo '[]';
    return; //若客户端未提交查询关键字，直接返回一个空数组，退出当前页面的执行
}


//执行数据库操作
$conn = mysqli_connect('127.0.0.1','root','','kaifanla');
$sql = "SET NAMES UTF8";
mysqli_query($conn, $sql);
$sql = "SELECT did,name,price,material,img_sm FROM kf_dish  WHERE name LIKE '%$kw%' OR material LIKE '%$kw%'  ";
$result = mysqli_query($conn, $sql);

$output = [];  //用于保存所有记录的数组
while( ($row=mysqli_fetch_assoc($result))!==NULL ){
    $output[] = $row;
}

//向客户端输出响应消息主体
$jsonString = json_encode($output);
echo $jsonString;
?>