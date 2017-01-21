<?php
//获取页面提交过来的数据
$bookId=isset($_GET["id"])?$_GET["id"]:0;
//连接并选择数据库
require_once 'inc/connectAjaxPaged.inc.php';
//准备sql语句
$query="delete from t_book where bookID=?";

//预编译语句
$stmt=$mysqli->prepare($query);
//给占位符绑定值
$stmt->bind_param("s",$bookId);
//执行sql语句
$stmt->execute();
//根据返回是否成功完成相关操作
if ($stmt->affected_rows>0) {
	header("location:pagedBookList.php");
}else {
	echo"<script>alert('删除图书信息失败！'); location.href='pagedBookList.php'</script>";
}


//关闭数据库连接
mysqli_close($link);