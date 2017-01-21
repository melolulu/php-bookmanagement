<?php
require_once 'inc/header.inc.php';
//获取页面提交过来的数据
$username = isset($_POST["name"])?$_POST["name"]:"";
$pwd = isset($_POST["password"])?$_POST["password"]:"";
$email = isset($_POST["email"])?$_POST["email"]:"";
$tel = isset($_POST["tel"])?$_POST["tel"]:"";
$address = isset($_POST["address"])?$_POST["address"]:"";
$date = isset($_POST["date"])?$_POST["date"]:"";


//准备sql语句
$query = <<<std
insert into t_user value(null,?,?,?,?,?,?);
std;
//创建mysqli对象
// $mysqli = new mysqli("localhost", "root", "root", "bookshop");
require_once 'inc/connectAjaxPaged.inc.php';
/* check connection 检查连接是否成功*/
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();//终止应用
}

/* create a prepared statement 创建预编译语句 */
if ($stmt = $mysqli->prepare($query)) {

	/* bind parameters for markers 给sql语句中的问号？占位符绑定值 */
	$stmt->bind_param("ssssss", $username,$pwd,$address,$email,$date,$tel);

	/* execute query  预编译sql语句 会把sql语句中特殊字符（’#）过滤掉*/
	$stmt->execute();

	/* bind result variables  绑定结果变量*/
// 	$stmt->bind_result($row);
	if ($stmt->affected_rows>0) {
		echo"<script>alert('注册成功！！'); location.href='weiboLogin.html' </script>";
	}

	/* fetch value 执行sql语句获取结果集并遍历 */
// 	$stmt->fetch();
	/* close statement  关闭预编译语句*/
	$stmt->close();
	
}
/* close connection 关闭数据库*/
$mysqli->close();
