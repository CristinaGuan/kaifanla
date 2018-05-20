<?php
header('Content-Type: application/json;charset=utf8');
@$start=$_GET['start'];
if(!isset($start)){
$start=0;
}
$count=5;

 $con=mysqli_connect('localhost','root','','kaifanla','3306');
 if(!$con){
  echo "connect not success";
 }
mysqli_query($con,"SET NAMES 'utf8'");
$sql="SELECT * FROM kf_dish LIMIT $start,$count";
$result=mysqli_query($con,$sql);
 //用于保存所有记录的数组
$output = array();
if($result){
    while($row=mysqli_fetch_assoc($result)){
    $output[]= $row;
 }
 }
 $jsonString =json_encode($output);
// sleep(1);
// echo $start;
 echo $jsonString;

mysqli_close($con);
?>