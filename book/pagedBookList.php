<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>图书内部管理页面—分页</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!-- 	<style type="text/css">
		table{
			width:800px;
			border-collapse:collapse;
		}
		th,td{
			border:solid 1px #00a381;

		}
		th{
			background:#f2a0a1;
		}
		tr:nth-child(odd){
			background:#ccc;
		}
		tr:nth-child(even){
			background:#e7e7eb;
		}
		tr:hover{
			background:#f5b1aa;
		}
		.modify{
			text-align:center;
		}
		.paged{
			background:#fff;
			text-align:right;
		}
	</style> -->
	<style type="text/css">
 		body {
   			 background: url(images/sp160923_192423.png);
		}
		th{
			text-align:center;
		}
	</style>
</head>
<body>
	<h1 class="text-center">图书管理</h1>
	<table class="text-center  table table-bordered table-striped table-condensed table-hover">
		<tr>
			<th>编号</th>
			<th>书名</th>
			<th>类型</th>
			<th>时间</th>
			<th>作者</th>
			<th>价格</th>
			<th>编辑</th>
			
		</tr>
		<?php
		//接收传过来的电影类型
		$type=isset($_GET["type"]) && (integer)$_GET["type"]>0 ? (integer)$_GET["type"] : 0;
		//接受传过来的关键字
		$keyword=isset($_GET["keyword"])?$_GET["keyword"]:"%";
		//接收传过来的页码
		$pageNumber = isset($_GET["page"]) && (integer)$_GET["page"]>0?(integer)$_GET["page"]:1;
		//计算每页首行索引
		//页码-1*每页记录数
		$pageSize = 5;//每页五条记录
		$start=($pageNumber - 1)*$pageSize;
		//连接数据库
		require_once 'inc/connectAjaxPaged.inc.php';
		// 准备SQL语句
		if($type > 0){
			//按照类型筛选
			$sql = <<<std
			SELECT bookID,bookName,bookType,bookDate,author,price,b.typeName
			FROM t_book a,t_bookType b
			WHERE bookType=$type and
			bookName like '%$keyword%' and
			a.bookType = b.typeID
			limit $start,$pageSize;
			
std;
		}else {
			$sql = <<<std
			SELECT bookID,bookName,bookType,bookDate,author,price,b.typeName
			FROM t_book a,t_bookType b
			WHERE bookName like '%$keyword%' and
			a.bookType = b.typeID
			limit $start,$pageSize;
std;
		}
		//预编译语句
		$stmt=$mysqli->prepare($sql);
		//绑定结果变量
		$stmt->bind_result($bookID,$bookName,$bookType,$bookDate,$author,$price,$typeName);
		//执行sql语句
		$stmt->execute();
		//遍历结果
		while ($stmt->fetch()) {
		?>
		<tr>
				<td><?php echo $bookID  ?></td>
				<td><?php echo$bookName ?></td>
				<td><?php echo $typeName ?></td>
				<td><?php echo $bookDate  ?></td>
				<td><?php echo $author  ?></td>
				<td><?php echo $price  ?></td>
				<td class="modify">
						<a class="btn btn-info" href="updateBook.php  ?id=<?php echo $bookID?>">修改</a>
						<a  class="btn btn-danger" href="deleteBook.php  ?id=<?php echo $bookID?>" onclick="return confirm('是否删除?')">删除</a>
				</td>
		</tr>
		<?php 
				}
				//多次使用同一个预编译语句对象，需要先关闭，在使用
				$stmt->close();
				// 小插曲 获取总记录数,计算总页数
				if ($type>0) {
					//按照类型筛选
					$sql = "select count(*) from t_book where bookType=$type and bookName like '%$keyword%'";
				}else{
					$sql = "select count(*) from t_book where bookName like '%$keyword%'";
				}
				
				//预编译语句
				$stmt=$mysqli->prepare($sql);
				//绑定结果变量//总记录数
				$stmt->bind_result($rowCount);
				//执行sql语句
				$stmt->execute();
				//获取结果
				$stmt->fetch();
				//总页数
				$pageCount=ceil($rowCount/$pageSize);
		?>
		<tr>
			<td colspan="7" class="paged">
					<ul class="pager">
        
        
    
					<?php 
					$pageURL="";//总的分页条
					//分页部分
					$firstURL="";//首页
					$previousURL="";//上一页
					$nextURL="";//下一页
					$lastURL="";//末页
						if ($pageCount>1) {
							if ($pageNumber==1) {
								//首页
								$firstURL="<li><a>首页</a></li>";
								$previousURL="<li><a>上一页</a></li>";
								$nextURL="<li><a href='pagedBookList.php?type=$type&keyword=$keyword&page=".($pageNumber+1)."'>下一页</a></li>&nbsp;";
								$lastURL="<li><a href='pagedBookList.php?type=$type&keyword=$keyword&page=$pageCount '>末页</a></li>&nbsp;";
							}elseif ($pageNumber==$pageCount){
								//末页
								$firstURL="<li><a href='pagedBookList.php?type=$type&keyword=$keyword&page=1'>首页</a></li>&nbsp;";
								$previousURL="<li><a href='pagedBookList.php?type=$type&keyword=$keyword&page=".($pageNumber-1)."'>上一页</a></li>&nbsp;";
								$nextURL="<li><a>下一页</a></li>&nbsp;";
								$lastURL="<li><a>末页</a></li>&nbsp;";
							}else{
								//中间部分的页
								$firstURL="<li><a href='pagedBOOKList.php?type=$type&keyword=$keyword&page=1 '>首页</a></li>&nbsp;";
								$previousURL="<li><a href='pagedBookList.php?type=$type&keyword=$keyword&page=".($pageNumber-1)."'>上一页</a></li>&nbsp;";
								$nextURL="<li><a href='pagedBookList.php?type=$type&keyword=$keyword&page=".($pageNumber+1)."'>下一页</a></li>&nbsp;";
								$lastURL="<li><a href='pagedBookList.php?type=$type&keyword=$keyword&page=$pageCount '>末页</a></li>&nbsp;";
							}
							$pageURL = $firstURL.$previousURL.$nextURL.$lastURL."&nbsp;当前：第".$pageNumber."页/共".$pageCount."页";
						}elseif ($pageCount<1){
							$pageURL="没有符合条件的书籍";
						}elseif ($pageCount==1){
							$pageURL = $firstURL.$previousURL.$nextURL.$lastURL."&nbsp;当前：第".$pageNumber."页/共".$pageCount."页";
						}
						echo $pageURL;
						
						
					?>
					</ul>
			</td>
		</tr>
	</table>
	<form action="pagedBookList.php" method="get">
			类型 ：<select class="form-control" name="type">
			<option value="0">---请选择电影类型---</option>
	<?php 
				//多次使用同一个预编译语句对象，需要先关闭，在使用
				$stmt->close();
				 $sql="select typeID,typeName from t_bookType";
				  //预编译语句
				 $stmt=$mysqli->prepare($sql);
				 //绑定结果变量//总记录数
				 $stmt->bind_result($typeID,$typeName);
				 $stmt->execute();
				 //遍历结果
				 while ($stmt->fetch()) {
	?>
		<option <?php if($type==$typeID){echo "selected";}?> value="<?php echo $typeID ?>">
					<?php echo $typeName ?>
		</option>
		<?php 
				 }
		?>
	</select>
	图书关键字：<input class="form-control" type="text" name="keyword"  value="<?php if($keyword!='%'){echo$keyword; } ?>"/>
	<input class="btn btn-default" type="submit" value="筛选">
	</form>
	
<a href="addBook.php">点击添加新书</a>
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>