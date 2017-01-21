#创建数据库
DROP DATABASE IF EXISTS bookshop;
CREATE DATABASE IF NOT EXISTS bookshop;
#使用数据库
USE bookshop;

#alter database movies default character set = UTF8; 
#创建数据库表,图书种类表
DROP TABLE IF EXISTS t_bookType;
CREATE TABLE IF NOT EXISTS t_bookType
(
	`typeID` INT AUTO_INCREMENT PRIMARY KEY,
	`typeName` VARCHAR(20),
	`typeDesc` VARCHAR(200)
);
INSERT INTO t_bookType VALUES(NULL,'童书','暂无');
INSERT INTO t_bookType VALUES(NULL,'教辅','学习用书');
INSERT INTO t_bookType VALUES(NULL,'小说','武侠，言情');
INSERT INTO t_bookType VALUES(NULL,'文学','四大名著');
INSERT INTO t_bookType VALUES(NULL,'历史','二十四史');
INSERT INTO t_bookType VALUES(NULL,'传记','暂无');
INSERT INTO t_bookType VALUES(NULL,'哲学宗教','暂无');
INSERT INTO t_bookType VALUES(NULL,'保健养生','暂无');

#创建图书信息表
DROP TABLE IF EXISTS t_book;
CREATE TABLE IF NOT EXISTS t_book
(
	`bookID` INT AUTO_INCREMENT PRIMARY KEY,
	`bookName` VARCHAR(50),
	`bookType` INT REFERENCES t_movietype(typeid),
	`bookDate` DATE,
	`author` VARCHAR(20),
	`price` decimal(2),
	`memo` VARCHAR(1000)
);
#插入几条记录
INSERT INTO t_book VALUES(NULL,'射雕英雄传','3','1998-12-01','金庸','66.6','射雕三部曲之一以宋朝靖康之耻为背景');
INSERT INTO t_book VALUES(NULL,'神雕侠侣','3','1998-12-01','金庸','66.6','射雕三部曲之二');
INSERT INTO t_book VALUES(NULL,'倚天屠龙记','3','1998-12-01','金庸','66.6','射雕三部曲之三');
INSERT INTO t_book VALUES(NULL,'西游记','4','1998-12-01','吴承恩','66.6','西游记');
INSERT INTO t_book VALUES(NULL,'红楼梦','4','1998-12-01','曹雪芹','66.6','红楼梦');
INSERT INTO t_book VALUES(NULL,'三国演义','4','1998-12-01','罗贯中','66.6','三国');

SELECT * FROM t_bookType;
SELECT * FROM t_book;

#增加用户表
DROP TABLE IF EXISTS t_user;
CREATE TABLE t_user
(
	`userID` INT PRIMARY KEY AUTO_INCREMENT,
	`userName` VARCHAR(50),
	`userPwd` VARCHAR(128),
    `address` VARCHAR(128),
    `email` VARCHAR(128),
    `date` date,
    `tel` VARCHAR(128)
);

#插入几条记录
INSERT INTO t_user VALUES(NULL,'admin','admin','china','1232345675@qq.com','1999-12-12','13134567890');
#增加用户信息表

SELECT * FROM t_bookType;