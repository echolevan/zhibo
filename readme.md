# Laravel5.2

路由按照示例分离，不要写到一个里面。


##目前composer为中国镜像，速度很快！
常用命令 	意义

php artisan make:controller Blog/IndexController 	新建控制器

php artisan make:migration create_articles_table 	新建数据库迁移文件

php artisan migrate 	执行迁移，修改数据库

php artisan make:model Models/Article 	新建模型

php artisan route:list 	查看所有定义的路由


常用代码 	意义

return view('blog.index'); 	加载模板

return view('blog.index')->with('articles', $articles); 	发送数据到模板

return view('blog.index', ['articles'=> $articles]); 	发送数据到模板

return back() 	跳转回上一页

return redirect('/') 	跳转到指定路径


请求类型 	意义

get 	直接访问网址

post 	新增数据

put 	修改数据

patch 	修改一个字段

delete 	删除数据

验证码包 composer require mews/captcha

