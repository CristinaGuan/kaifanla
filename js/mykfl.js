/**
 * Created by yan on 17/8/15.
 */
    //定义全局变量
var $user='global value';
$user='婷婷';

angular.module('kaifanla',['ng','ngRoute','ngAnimate']).config(function ($routeProvider) {
  $routeProvider.when('/home',{
    templateUrl:'kfl/home.html',
    controller:'homeCtrl'
  }).when('/dishDetail',{
    templateUrl:'kfl/dishDetail.html',
    controller:'dishDetailCtrl'
  }).when('/myOrder',{
    templateUrl:'kfl/myOrder.html',
    controller:'myOrderCtrl'
  }).when('/order',{
    templateUrl:'kfl/order.html',
    controller:'orderCtrl'
  })

}).controller('homeCtrl',function ($scope,$http) {
    $scope.showHome=true;
    $scope.isalert=true;
    $scope.mysearch="";
    $scope.isLoading=true;
    $scope.loadmore=true;
    $scope.datalist=[];
    //主页面初次自动加载；
    $scope.start=$scope.datalist.length;
    $http.get('./data/kf_dish_home.php?start='+$scope.start).success(function (data) {
        $scope.datalist=$scope.datalist.concat(data);
        $scope.isLoading=true;
    });
   //主页加载更多
   
    $scope.load=function ()
    {   $scope.isLoading=false;
        $scope.start=$scope.datalist.length;
        $http.get('./data/kf_dish_home.php?start='+$scope.start).success(function (data) {
          if (data.length < 5) {
            $scope.datalist=$scope.datalist.concat(data);
            $scope.loadmore=false;
          }else{
             $scope.datalist=$scope.datalist.concat(data);
              $scope.loadmore=true;
          }
                
                
          
           
        });
    }
    //搜索
    $scope.search=function(){
        $scope.isalert=true;
        if($scope.mysearch!=""){
            $scope.showHome=false;
            $scope.datalist=[];
            $http.post("./data/search.php",{searchCont:$scope.mysearch,start:0}).success(function(searchData){
                if(searchData){
                    $scope.datalist=$scope.datalist.concat(searchData);
                }else {
                    console.log("数据为空");
                }
            });
        }else{
            $scope.isalert=false;
        }
    }
    //搜索结果加载
    $scope.loadsearch=function (a,b)
    {
        $scope.start=$scope.datalist.length;
        $scope.isLoading=true;
        $http.post('./data/search.php?',{searchCont:$scope.mysearch,start:$scope.start}).success(function (data) {
            $scope.datalist=$scope.datalist.concat(data);
            $scope.isLoading=false;
        });
    }

}).controller('dishDetailCtrl',function ($scope,$location,$http) {
  // $scope.dUrl1=$location.absUrl().split("?")[1].split("=")[1];//$location.absUrl()用于获取网页地址URL,返回字符串类型
  // $scope.dUrl2=$location.$$search.did;//$location.$$search用于获取?后面的内容,返回对象,{did:"1"}
  $scope.dId=$location.search().did;//$location.$search()用于获取?后面的内容,返回对象,{did:"1"}

  $http.get('./data/dishDetail.php?dId='+$scope.dId).success(function (datalist) {
    $scope.dDetail=datalist;
    // console.log($scope.dDetail);
  });
  $scope.placeAnOrder=function (oid) {
    window.location.href='http://localhost:8888/kaifanla/kfl_Index.html#/order?did='+oid;
  }
  $scope.goBack=function () {
    window.history.back(-1);//返回上一页
  }

}).controller('myOrderCtrl',function ($scope,$http) {
    $scope.gUser=$user;
    $http.post('./data/dishOrder.php', {user:$scope.gUser}).success(function (data) {
      $scope.Orderdata = data;
    })

}).controller('orderCtrl',function ($scope,$http,$location,$filter) {
    $scope.isAlert=false;
    $scope.gUser=$user;
    $scope.addDid=$location.search().did;//$location.$search()用于获取?后面的内容,返回对象,{did:"1"}
    var today = new Date();
    $scope.formatDate = $filter('date')(today, 'yyyy-MM-dd HH:mm:ss');
    $scope.AOphone='';
    $scope.AOsex='女';
    $scope.AOaddressee='';
    $scope.AOaddr='';
    $scope.GoAddOrder=function(AOaddressee,AOsex,AOphone,AOaddr){
        $scope.AOphone=AOphone;
        $scope.AOsex=AOsex;
        $scope.AOaddressee=AOaddressee;
        $scope.AOaddr=AOaddr;
        if($scope.AOphone!="" && $scope.AOsex!="" && $scope.AOaddressee!="" && $scope.AOaddr!=""){
            $http.post('./data/order_add.php',{did:$scope.addDid,username:$scope.gUser,phone:$scope.AOphone,sex:$scope.AOsex,
                addOrderTime:$scope.formatDate,addressee: $scope.AOaddressee,userAddr:$scope.AOaddr}).success(function(addReturn){
                $scope.status=addReturn.status;
                $scope.newOid=addReturn.oid;
                if($scope.status=='success'){
                    alert("下单成功，您的订单号为:"+$scope.newOid+",可以点击《我的订单》查看！");
                }
            });
        }else{
            alert("下单失败！");
        }
    }
});