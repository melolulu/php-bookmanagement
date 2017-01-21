<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改书籍信息</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!-- 	<style type="text/css"> 
/* 			input,select{ */
/* 			margin-bottom:7px; */
/* 			height:26px; */
/* 			font-size:18px; */
/* 			border-radius:10px; */
/* 		} */
/* 		#submitBtn{ */
/* 			background:#38b48b; */
/* 			color:#fff; */
/* 		} */
	</style>-->
	<style type="text/css">
 		body {
   			 background: url(images/sp160923_192423.png);
		}
	</style>
	<script src="laydate/laydate.js"></script>
	<script type="text/javascript">
			function doSubmit(){
					document.getElementById("myForm").submit();
				}
	</script>
</head>
<body>
<?php 
//获取页面提交过来的数据
$bookId=isset($_GET["id"])?$_GET["id"]:0;
//连接并选择数据库
require_once 'inc/connectAjaxPaged.inc.php';
//准备sql语句
$query=<<<std
select *from t_book
where bookID=?
std;

$stmt=$mysqli->prepare($query);
//给占位符绑定值
$stmt->bind_param("s",$bookId);
//绑定结果变量
$stmt->bind_result($bookID,$bookName,$bookType,$bookDate,$author,$price,$memo);
$stmt->execute();
//便利结果集
while($stmt->fetch()) {
//关闭结果集
// mysqli_free_result($result);
?>
	<h1 class="text-center">修改图书信息</h1>
	<form id="myForm" action="updateBookSave.php" method="post">
		编号：<?php echo $bookID?><br>
		<input class="form-control" type="hidden" name="bookID" value="<?php echo $bookID ?>">
		名称：<input class="form-control" type="text" name="bookName"  value="<?php echo $bookName?>"><br/>
		类型：<select class="form-control" name="bookType">
					<?php
					$stmt->close();
					//准备sql语句
					$sql=<<<std
					select typeID,typeName from t_bookType
std;
					$stmt=$mysqli->prepare($sql);
					//绑定结果变量
					$stmt->bind_result($typeID,$typeName);
					$stmt->execute();
					//便利结果集
					while ($stmt->fetch()) {
						?>
						<option <?php echo $bookType==$typeID?"selected":"" ?> value="<?php echo $typeID ?>"><?php echo $typeName ?></option>
					<?php 
						}
						
					?>
					
					
		</select><br>
		时间：<input class="form-control" type="text" name="bookDate"   onclick="laydate()" value="<?php echo $bookDate ?>"><br/>
		作者：<input class="form-control" type="text" name="author" value="<?php echo $author ?>"><br/>
		价格：<input class="form-control" type="text" name="price" value="<?php echo $price?>"><br/>
		简介：<textarea class="form-control" name="memo"  ><?php echo $memo ?></textarea><br/>
		<input class="btn btn-default"  type="submit" value="提交">
		<input class="btn btn-default"  id="submitBtn" type="button" value="也是提交" onclick="doSubmit()">
	</form>
	<?php
}
	//关闭数据库资源
	$stmt->close();
	$mysqli->close();
	?>
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>