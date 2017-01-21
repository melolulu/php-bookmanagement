<?php
require_once 'inc/header.inc.php';
//获取页面提交过来的数据
$bookID=isset($_POST["bookID"])?$_POST["bookID"]:0;
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
update t_book
set bookName='$bookName',bookType='$bookType',bookDate='$bookDate',author='$author',
price='$price',memo='$memo'
where bookID=$bookID
std;

//预编译语句
$stmt=$mysqli->prepare($sql);
//执行sql语句
$stmt->execute();
//判断是否插入成功
if ($stmt->affected_rows>0) {
	header("location:pagedBookList.php");
}else{
	echo"<script>alert('没有更新图书内容或者更新图书信息失败!\\n\请确定是否更新了图书内容！'); location.href='pagedBookList.php'</script>";
}
//关闭数据库连接
$stmt->close();
$mysqli->close();
?>