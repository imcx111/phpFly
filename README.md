# phpfly基于Fly社区模板的thinkphp5实现

#### 介绍
Thinkphp5 + Layui Fly Template实现的一个社区项目，使用X-admin实现了简单的后台管理功能，数据库使用Ｍysql，前台实现功能：用户注册、登录、邮件激活、发帖、回帖、点赞、回复、删帖、签到等功能

#### 更新说明

- 20191222 本系统用一周时间撸出来的，今天更新了第一个版本，保证前台功能基本可用，除了邮箱验证和找回密码，其他功能基本都实现了，最近会持续更新


#### 安装教程


1. 使用的是thinkphp5.0.24版本。  
2. 安装很简单，把tp5装好  
3. 然后把程序代码覆盖到相应的目录，代码主要就是application extend public 这三个目录  
4. 最后把根目录下的sql文件 导入到你的mysql数据库  
5. 修改一下application目录下面的database.php文件 就OK了。。。
6. 重要说明！！！！如下
7. 修改tp5框架 thinkphp/library/traits/controller/Jump.php 文件
8. 将其中的success 和 error两个方法中的 code返回值调换，success:code=0,error:code=1
9. 这也是最让我受不了的一点，在我的编程逻辑中，没有消息就是最好的消息。


#### 使用说明

1.  服务器环境开启pathinfo，并且支持rewrite(伪静态)
2.  暂时没想到其他需要注意的地方，
3.  有问题可以直接在演示论坛里留言或邮件我（bjphper@qq.com）


#### 技术栈/运行环境

1.  Thinkphp5
2.  Layui Fly Template
3.  X-admin
4.  php7
5.  mysql5.7



#### 演示地址

前台：[http://fly.mmno.com](http://fly.mmno.com "http://fly.mmno.com")  
后台：[http://fly.mmno.com/admin-test.php](http://fly.mmno.com/admin-test.php "http://fly.mmno.com/admin-test.php")  
后台账号密码：superadmin/123456

![输入图片说明](https://images.gitee.com/uploads/images/2019/1222/201641_b30a01c9_593571.jpeg "前端")
![输入图片说明](https://images.gitee.com/uploads/images/2019/1222/201657_202c9dea_593571.jpeg "后端")

