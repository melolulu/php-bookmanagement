<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>表单验证</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style type="text/css">
		body{
	 			background:url('images/bg.png');
		}
		h1{
				color:pink
		}
		form{
			width:300px;
			margin:20px auto;
			border:6px solid pink;
			border-radius:20px;
			padding:10px;
			text-align:center;
		}
		span{
			display:inline-block;
			width:66px;
		}
		input{
			font:20px/25px 楷体;
			width:200px;
			margin-bottom:10px;
		}
		@media screen and (max-width:600px) {
			form{
				padding:20px;
			}
			span{
				display:table;
				width:66px;
			}
			span,input{
				font:20px/30px 楷体;
			}
			input{
				width:100%;
				margin-bottom:10px;
			}
		}
	</style>
	
</head>
<body>
	<form action="registerSave.php" method="post">
		<h1>用户注册</h1>
		<span>姓名</span><input type="text" name="name" pattern="^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9])*$" required="required" placeholder="请输入姓名"><br>
		<span>密码</span><input type="password" name="password" placeholder="请输入密码"><br>
		<span>生日</span><input type="date" name="date" value="2016-12-06"><br>
		<span>Email</span><input type="email" name="email" pattern="^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$" required="required" autofocus="autofocus"><br>
		<span>Phone</span><input type="tel" name="tel" pattern="^(?:13\d|15[89])-?\d{5}(\d{3}|\*{3})$" placeholder="请输入电话号码" required="required"><br>
		<span>住址</span><input type="text" name="address" placeholder="请输入家庭住址"><br>
		<input class="btn btn-success" type="submit" name="" value="提交">
	</form>
</body>
</html>