<?php
header('Content-Type: application/json;charset=utf8');
@$dID=$_GET['dId'];
if(!isset($dID)){
  echo "没找到相关菜谱";
}
 $con=mysqli_connect('localhost','root','','kaifanla','3306');
 if(!$con){
  echo "connect not success";
 }
mysqli_query($con,"SET NAMES 'utf8'");
$sql="SELECT * FROM kf_dish where did=$dID";
$result=mysqli_query($con,$sql);
$detail=[];
if($result){
    while($row=mysqli_fetch_assoc($result)){
         $detail=$row;
    };
 }
 $jsonDetail=json_encode($detail);
echo $jsonDetail;
mysqli_close($con);
?>