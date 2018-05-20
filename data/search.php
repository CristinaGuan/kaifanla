<?php
//header('Content-Type: application/x-www-form-urlencoded;charset=utf8');
header("Content-Type:application/json;charset=utf-8");
//先读取到json字符串，然后解析成对象，这样可以用对象属性的方式取到传过来的参数值了
$postData=file_get_contents('php://input',true);
$obj=json_decode($postData,true);
$searchContent=$obj['searchCont'];
$start=$obj['start'];

if(!isset($start)){
$start=0;
}
$count=5;
 $con=mysqli_connect('localhost','root','','kaifanla','3306');
 if(!$con){
  echo "连接数据库失败,请检查网络".mysql_error();
 }
mysqli_query($con,"SET NAMES 'utf8'");
$sql="SELECT * FROM `kf_dish` where name like '%".$searchContent."%' or material like '%".$searchContent."%' LIMIT $start,$count";
if($searchContent!=""){
$result=mysqli_query($con,$sql);
$mySearchList=[];
//获取表格数据
if($result){
   while($row=mysqli_fetch_assoc($result))
   {
      $mySearchList[]=$row;
   }
}
echo json_encode($mySearchList);//对变量进行json编码,转换为json格式
}


mysqli_close($con);
?>