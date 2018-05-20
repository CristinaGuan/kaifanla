<?php
//header('Content-Type: application/x-www-form-urlencoded;charset=utf8');
header("Content-Type:application/json;charset=utf-8");
//先读取到json字符串，然后解析成对象，这样可以用对象属性的方式取到传过来的参数值了
$postData=file_get_contents('php://input',true);
$obj=json_decode($postData,true);
$user=$obj['user'];
 $con=mysqli_connect('localhost','root','','kaifanla','3306');
 if(!$con){
  echo "连接数据库失败,请检查网络".mysql_error();
 }
mysqli_query($con,"SET NAMES 'utf8'");
$sql="select o.oid,d.did,d.img_sm,o.order_time,o.addressee,o.user_name from kf_dish as d,kf_order as o WHERE o.did=d.did and o.user_name='$user'";
$result=mysqli_query($con,$sql);
$rows=mysqli_affected_rows($con);//获取行数
$colums=mysqli_num_fields($result);//获取列数
$myOrder=[];
//获取表格数据
while($row=mysqli_fetch_assoc($result))
{
   $myOrder[]=$row;
}
//print_r($myOrder);
echo json_encode($myOrder);//对变量进行json编码,转换为json格式

//echo "<br>共计".$rows."行 ".$colums."列<br/>";
mysqli_close($con);
?>