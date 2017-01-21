<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加书籍信息</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
 	<style type="text/css">
 		body {
   			 background: url(images/sp160923_192423.png);
		}
	</style>
<!-- 	<script src="laydate/laydate.js"></script> -->
	<script type="text/javascript">
			function doSubmit(){
					document.getElementById("myForm").submit();
				}
	</script>
</head>
<body>
	<h1 class="text-center">添加书籍信息</h1>
	<form class="form-group " id="myForm" action="addBookSave.php" method="post">
		名称：<input class="form-control" type="text" name="bookName" ><br/>
		类型：<select class="form-control"  name="bookType">
					<?php
					//连接并选择数据库
					require_once 'inc/connectAjaxPaged.inc.php';
					//准备sql语句
					$sql=<<<std
					select typeID,typeName from t_bookType
std;
					//预编译语句
					$stmt=$mysqli->prepare($sql);
					//绑定结果变量
					$stmt->bind_result($typeID,$typeName);
					//执行sql语句
					$stmt->execute();
					//便利结果集
					while ($stmt->fetch()) {
						?>
						<option value="<?php echo $typeID ?>"><?php echo $typeName ?></option>
					<?php 
						}
						//多次使用同一个预编译语句对象，需要先关闭，在使用
						$stmt->close();
					?>
					
					
		</select><br>
		时间：<input class="form-control" type="date"  name="bookDate" ><br/>
		作者：<input class="form-control" type="text" name="author" value="某"><br/>
		价格：<input class="form-control" type="text" name="price" value="100"><br/>
		简介：<br/><textarea class="form-control" cols="36"  name="memo" >书</textarea><br/>
		<input class="btn btn-default" type="submit" value="提交">
		<input class="btn btn-default" id="submitBtn" type="button" value="也是提交" onclick="doSubmit()">
	</form>
	<a href="pagedMovieList.php">返回电影列表页面</a>
	
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>