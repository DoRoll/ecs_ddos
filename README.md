Nginx/apache 配置
------------
http://www.yiichina.com/doc/guide/2.0/start-installation
注意。项目指定只需指定到根目录下，无需指定进web目录,采用根目录index.php文件

        PS:根目录不存在index.php,需要将index.sample.php复制并命名为index.php

~~~
路由展示
http://localhost/basic/web/
~~~

配置文件
------------
    主配置文件都是.sample.php结尾,clone项目后,复制config文件夹中含
    .sample.php文件并在重命名时去掉.sample即可。
    例如config.simple.php则复制为config.php

    config
        db.sample.php -> db.php
        main.sample.php -> main.php
        params.sample.php -> params.php



