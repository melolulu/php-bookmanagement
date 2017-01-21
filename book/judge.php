<?php
session_start();
header("content-type:text/json;charset=utf-8");
//获取页面提交过来的数据
$username=isset($_REQUEST["username"])?$_REQUEST["username"]:"";
$password=isset($_REQUEST["password"])?$_REQUEST["password"]:"";
//连接数据库
require_once 'inc/connectAjaxPaged.inc.php';
//sql语句
$sql="select count(*) from t_user where userName=? and userPwd=?;";
//预编译语句
if ($stmt=$mysqli->prepare($sql)) {
	//给占位符绑定值
	$stmt->bind_param("ss",$username,$password);
	//执行sql语句   插入不用绑定sql结果变量
	$stmt->execute();
	//绑定结果变量
	$stmt->bind_result($rowCount);
	//获取结果
	$stmt->fetch();
	//关闭预编译语句
	$stmt->close();
}
//根据执行结果判断是否成功
$arr=array();
if ($rowCount==0) {
	//用户不存在
	$arr["code"]="0";
	$arr["message"]="用户名或密码错误";
}else{
	//用户存在
	$arr["code"]="1";
	$arr["message"]="输入正确，点击登录";
	$_SESSION["username"]=$username;

}
$jsonStr=json_encode($arr);
echo $jsonStr;
//关闭数据库
$mysqli->close();