<?php
/*根据菜品编号，返回该菜品的详情，以JSON格式*/
header('Content-Type: application/json');

//接收客户端提交的数据
@$did = $_REQUEST['did']; //待查询的菜品编号
if( !isset($did) ){
    echo '{}';
    return; //若客户端未提交did，则返回一个空JSON对象，退出当前页面的执行
}


//执行数据库操作
$conn = mysqli_connect('127.0.0.1','root','','kaifanla');
$sql = "SET NAMES UTF8";
mysqli_query($conn, $sql);
$sql = "SELECT did,name,price,material,img_lg,detail FROM kf_dish  WHERE  did=$did ";
$result = mysqli_query($conn, $sql);

$row=mysqli_fetch_assoc($result);  //根据编号查询，最多只能获得一行

//向客户端输出响应消息主体
$jsonString = json_encode($row);
echo $jsonString;
?>