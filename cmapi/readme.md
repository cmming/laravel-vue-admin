##总体模块分析
- 1. video_users 视频用户

- 2. videos 视频表

        id          视频编号
        name        视频名称
        user_id     视屏关联的用户
        url         视频对应的地址
        is_free     视频是否免费              (0:不免费，1：免费)

- 3. cards 帖子表

- 4. user_cards 用户与帖子关系表



- 6. comments 评论表

- 7. user_comments 用户与评论相关的关系表

- 8. anwsers 用户回复表回复表

- 9. user_anwsers 用户与回复的关系表

- 10. comment_anwsers  评论与回复的关系表


实现多表 jwt

实现 多数据库链接

实现文件续传的接口

上传完成后就能保存的数据

1.创建用户资源表
t_vr_user_ori_resources


//上传完视频后可以修改的
tid：2|4
title：
fname：
ftype
fsize
authorid
author：nick
down_url:
des:
att:
enable:
vfrom:



create table t_vr_user_ori_tmp (
 mid		   bigint not null auto_increment,	           -- 唯一流水号
 tid		   int not null default '0',			   -- 类型编号【方便检索后定位处理】[1 普通图片 2 普通视频 3 VR全景图片 4 VR视频 5 官方贴]
 title		   varchar(128) not null default '',		   -- 电影名称标题
 fsign		   varchar(48) not null default '',		   -- 文件签名
 fname		   varchar(128) not null default '',		   -- 文件名 
 ftype		   varchar(8) not null default '',		   -- 文件类型
 fsize		   int not null default 0,			   -- 文件大小
 authorid	   int not null default 0,			   -- 作者编号
 author		   varchar(64) not null default '',		   -- 作者
 flag		   int not null default '0',			   -- 标识位[用于排序 从大到小] 0 普通贴 1 精选
 ctime		   timestamp default current_timestamp,		   -- 创建时间
 img_url	   text,					   -- 图片地址
 down_url	   text,					   -- 下载地址
 des		   text,					   -- 电影介绍
 tag		   text,					   -- 标签
 att		   text,					   -- 额外配置属性 [ {"fee":"2","free_time":"01`30"} 说明：收费金额：2元 免费观看时长 1分30秒 ]
 mtime		   int not null default 0,			   -- 修改时间[unix时间]
 enable		   int not null default 0,			   -- 可用状态
 vfrom		   varchar(255) not null default '',		   -- 来源
 primary key(mid)
);

