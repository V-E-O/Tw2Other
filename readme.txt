修改config.php中的用户名和密码

选择需要的同步的服务，默认全部开启了同步到sina,digu,zuosa

如果不需要同步某个服务，请删除这一项或者留空

你可以直接访问index.php来达到更新的目的，也可以通过计划任务的方式来访问cron.php来实现跟新
（如果没有权限创建计划任务，可以再你网站访问最频繁的页面中嵌入访问cron.php的代码,如果不想要得到结果，可以加上echo=false的参数）

如果有问题，可以访问我的博客:http://intgu.com  或者 follow我：http://twitter.com/cluries