<?php
//header('Content-Type: application/x-www-form-urlencoded;charset=utf8');
header("Content-Type:text/html;charset=utf-8");
//先读取到json字符串，然后解析成对象，这样可以用对象属性的方式取到传过来的参数值了
$postData=file_get_contents('php://input',true);
$obj=json_decode($postData,true);
$user=$obj['user'];
 $con=mysqli_connect('localhost','root','','kaifanla2','3308');
 if(!$con){
  echo "连接数据库失败,请检查网络".mysql_error();
 }
mysqli_query($con,"SET NAMES 'utf8'");
$sql="select o.oid,d.img_sm,o.order_time,o.addressee,o.user_name from kf_dish as d,kf_order as o WHERE o.did=d.did and o.user_name='$user'";
$result=mysqli_query($con,$sql);
$rows=mysqli_affected_rows($con);//获取行数
$colums=mysqli_num_fields($result);//获取列数

//返回表头和表格字段
echo "<table class='table table-bordered table-hover'><thead><tr><th>订单编号</th><th>商品名称</th><th>下单时间</th><th>收货人</th></tr></thead>";

//获取表格数据
while($row=mysqli_fetch_row($result))
{
   echo "<tr>";
   for($j=0;$j<$colums-1;$j++)
      { $did=$row[0];
        echo "<td><a ng-href='#/dishList?did=$did'>".$row[$j]."</a></td>";
       }
   echo "</tr>";
}
echo "</tbody></table>";

echo "<br>共计".$rows."行 ".$colums."列<br/>";

mysqli_close($con);
?>