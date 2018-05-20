<?php
/*接收客户端提交的订单信息，保存订单，生成订单号，
输出执行的结果，以JSON格式*/
header("Content-Type:application/json;charset=utf-8");
//接收客户端提交的数据
//@$user_name = $_POST['username'];    //接收人姓名
$postData=file_get_contents('php://input',true);
$obj=json_decode($postData,true);
@$user_name=$obj['username'];
@$addressee=$obj['addressee'];
@$sex =$obj['sex'];    //性别
@$phone =$obj['phone'];//联系电话
@$addr =$obj['userAddr'];  //收货地址
@$did =$obj['did'];    //菜品编号
@$order_time=$obj['addOrderTime'];  //下单时间

//客户端输入的服务器端校验——真正可靠的校验！
if( !$user_name || !$addressee ||!$sex || !$phone || !$addr || !$did || !$order_time){
    $output=[];
    $output["status"]="error";
    $output["msg"] = "Request Data Not OK!";
    echo json_encode($output);
    return;
}else{
//执行数据库操作
$conn=mysqli_connect('localhost','root','','kaifanla','3306');
mysqli_query($conn,"SET NAMES 'utf8'");
$sql = "INSERT INTO kf_order(user_name,sex,phone,addr,did,order_time,addressee) VALUES('$user_name','$sex','$phone','$addr','$did','$order_time','$addressee')";
$result=mysqli_query($conn,$sql);

$output = [];
if($result){    //SQL执行成功
    $output['status']='success';
    $output['oid']=mysqli_insert_id($conn); //获取最近的一条INSERT语句所生成的自增主键
}else{          //SQL执行失败
    $output['status']='error';
    $output['msg']="数据库访问失败！SQL:$sql";
}

//向客户端输出响应消息主体
$jsonString = json_encode($output);
echo $jsonString;

}


?>