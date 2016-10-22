
create database `g22_shop`;

create table if not exists `shop_user` (
	`id`   int unsigned  not null auto_increment,
	primary key(`id`) comment '主键',
	`user` varchar(64) not null ,
		unique un_user(`user`) comment '唯一登录帐号',
		`pass` char(32) not null comment '密码',
		`icon` varchar(255) not null default 'default.jpg' comment '头像',
		`integral` int unsigned not null default 0 comment '积分',
		`level` tinyint not null default 2 comment '0:超级管理员,1:管理员，2：铜牌，3：银牌，4：金牌：5：钻石',
		`sex` tinyint not null default 2 comment '0:女,1:男,2:妖',
		`email` varchar(64) not null default "" comment '邮箱',
		`age` int unsigned not null default 0 comment '0:表示没有设置年龄',
		`tel` char(11) not null default "" comment '手机',
		`real_name` varchar(64) not null default "" comment '真实姓名',
		`addtime` int unsigned not null 
	)engine=innodb default charset=utf8;
					

-- 手动添加管理员
	insert into `shop_user` values(null,'lili',md5('123'),'default.jpg',10,2,2,'3453252352@qq.com',unix_timestamp() , '13456789234','丽丽',unix_timestamp()),
		(null,'admin',md5('123'),'default.jpg',10,0,2,'3453252352@qq.com',unix_timestamp() , '13456789234','丽丽',unix_timestamp()),
		(null,'first',md5('123'),'default.jpg',10,2,2,'3453252352@qq.com',unix_timestamp() , '13456789234','老一',unix_timestamp()),
		(null,'second',md5('123'),'default.jpg',10,2,2,'3453252352@qq.com',unix_timestamp() , '13456789234','老二',unix_timestamp()),
		(null,'third',md5('123'),'default.jpg',10,2,2,'3453252352@qq.com',unix_timestamp() , '13456789234','老三',unix_timestamp());
			
			

---orders表
	
create table if not exists `shop_orders`(
	`id` int unsigned not null auto_increment,
	primary key(`id`)  comment '主键',
	`uid` int unsigned not null comment '用户id',
	`linkman` varchar(32)  not null  comment '联系人姓名',
	`address` varchar(255) not null comment '联系人地址',
	`total` double(8,2) not null comment '总金额',
	`addtime` int unsigned not null,
	`status` tinyint unsigned not null default 0 comment'0:新订单; 1:已发货; 2:已收货;3:无效订单'
	)engine=innodb default charset=utf8;


---detail表
create table if not exists `shop_detail`(
	`id` int unsigned not null auto_increment,
	primary key(`id`) comment '主键',
	`orderid` int unsigned not null comment '订单ID',
	`goodsid` int unsigned not null comment '商品ID',
	`name` varchar(32) not null comment '商品名',
	`price` double(6,2) not null comment '单价',
	`num` int unsigned not null comment '数量'
	)engine = innodb default charset=utf8;
