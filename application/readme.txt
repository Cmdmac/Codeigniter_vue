CI框架3.0关于session的设置改动及存数据库的使用方法
Session的设置跟之前有点不一样

我们来看看2.0版本中的设置是什么样子的：

$config['sess_cookie_name']= 'test_session';
$config['sess_expiration']= 7200;
$config['sess_expire_on_close']= FALSE;
$config['sess_encrypt_cookie']= FALSE;
$config['sess_use_database']= TRUE;
$config['sess_table_name']= 'test_sessions';
$config['sess_match_ip']= FALSE;
$config['sess_match_useragent']= TRUE;
$config['sess_time_to_update']= 3000;
 
而3.0是这样的：
$config['sess_driver'] = 'database';  
$config['sess_cookie_name'] = 'test_session';
$config['sess_expiration'] = 3600;
$config['sess_save_path'] = 'test_sessions';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
 
首先是第一个改动，CI3.0支持更多的方式去存储session，包括files, database, redis, memcached以及自定义。

所以你可以在sess_driver那里修改为自己所需的存储方式。

然后是第四行的改动，第四行在使用文件存储的时候应当指定文件路径（使用默认的null即可），而使用数据库存储时需要改为数据表的名称，使用redis的时候需要改为tcp地址，如

tcp://localhost:6379

使用memcached也是一样要改为地址，如：

localhost:11211

数据库如何使用呢？

首先在application\config\config.php中配置好，然后去数据库创建表（MYSQL）：

【备注：3.0版本的session数据表与2.0版本相差较大，建议删除2.0的数据表换成新的数据表】

CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` varchar(40) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
        `data` blob NOT NULL,
        PRIMARY KEY (id),
        KEY `ci_sessions_timestamp` (`timestamp`)
);
如果你想要打开sess_match_ip的话还需要执行下面的语句
ALTER TABLE ci_sessions ADD CONSTRAINT ci_sessions_id_ip UNIQUE (id, ip_address);
这样配置就完成了，你可以使用2.0版本的方法进行调用。
 又水