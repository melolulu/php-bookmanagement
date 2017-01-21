<?php
require_once 'inc/header.inc.php';
//获取页面提交过来的数据
$bookName=isset($_POST["bookName"])?$_POST["bookName"]:"";
$bookType=isset($_POST["bookType"])?$_POST["bookType"]:"";
$bookDate=isset($_POST["bookDate"])?$_POST["bookDate"]:"";
$author=isset($_POST["author"])?$_POST["author"]:"";
$price=isset($_POST["price"])?$_POST["price"]:"";
$memo=isset($_POST["memo"])?$_POST["memo"]:"";
//连接并选择数据库
require_once 'inc/connectAjaxPaged.inc.php';
//准备sql语句
$sql=<<<std
insert into t_book
values(null,'$bookName','$bookType','$bookDate','$author','$price','$memo')
std;
//预编译语句
$stmt=$mysqli->prepare($sql);
//执行sql语句
$stmt->execute();

//判断是否插入成功
if ($stmt->affected_rows>0) {
	header("location:pagedBookList.php");
}else{
	echo"<script>alert('添加电影信息失败！'); location.href='pagedBookList.php'</script>";
}
//关闭数据库连接
$stmt->close();
?>