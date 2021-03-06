
# 基于PhalApi2的Redis拓展

![](http://webtools.qiniudn.com/master-LOGO-20150410_50.jpg)

## 前言

Redis在PHP开发中运用场景已经无处不在,小到简单缓存大到数据库或消息队列都可以使用Redis来进行实现,基于PhalApi2的出世,PhalApi2-Redis也紧接着进行了本次适配来提供更好的开发体验,PhalApi2-Redis提供相对于原生PhalApi2-RedisCache缓存更强大的Redis操作以及完善的封装机制,帮助开发者更好的使用Redis低成本的来解决实际的业务问题.

附上:

官网地址:[http://www.phalapi.net/](http://www.phalapi.net/ "PhalApi官网")

项目GitHub地址:[https://github.com/wenzhenxi/phalapi2-redis](https://github.com/wenzhenxi/phalapi2-redis "项目Git地址")

项目码云地址  : [https://gitee.com/wenzhenxi/phalapi2-redis](https://gitee.com/wenzhenxi/phalapi2-redis "项目码云地址")

## 安装配置Redis

基于Liunx强烈推荐使用oneinstack在配置php 和 Redis同事会将依赖打包好:

**oneinstack**:[https://oneinstack.com/](https://oneinstack.com/ "oneinstack")

手动安装redis网上有很多教程这里不再提及,主要注意一下配置文件:

```
databases 100                      #redis库的最大数量默认16推荐修改100
requirepass phalapi                #连接此redis的连接密码默认无密码推荐设置
```

手动安装php-redis依赖如下:

```
//下载phpredis解压安装
wget https://github.com/nicolasff/phpredis/archive/master.zip
unzip master.zip -d phpredis
cd phpredis/phpredis-master
phpize
./configure
make && make install
//在php.ini中注册phpredis
extension = redis.so
```
此后可以在phpinfo()中看到redis即可


## 安装PhalApi2-Redis

在项目的composer.json文件中，添加：

```
{
    "require": {
        "abclove/redis": "dev-master"
    }
}
```

配置好后，执行composer update更新操作即可。

## 配置文件
我们需要在 **./config/app.php** 配置文件中追加以下配置：

```
    /**
     * 扩展类库 - Redis扩展
     */
    'redis' => array(
        //Redis链接配置项
        'servers'   => array(
            'host'      => '127.0.0.1', //Redis服务器地址
            'port'      => '6379', //Redis端口号
            'prefix'    => 'PhalApi:', //Redis-key前缀
            'auth'      => 'phalapi', //Redis链接密码
        ),
        // Redis分库对应关系
        'DB'        => array(
            'dev'  => 1,
            'user' => 2,
            'code' => 3,
            'tpl'  => 4,
        ),
        // Redis分库对应序列化值前缀
        'serialize' => array(
            'dev'  => 'dev_serialize:',
            'user' => 'user_serialize:',
            'code' => 'code_serialize:',
            'tpl'  => 'tpl_serialize:',
        ),

        // Redis分库对应键名前缀
        'prefix'    => array(
            'dev'  => 'dev:',
            'user' => 'user:',
            'code' => 'code:',
            'tpl'  => 'tpl:',
        ),

```

## 入门使用

初始化PhalApi2-Redis,入口文件index.php加入如下代码

```

// 惰性加载Redis
\PhalApi\DI()->redis = function () {
    return new \Abclove\Redis\Lite(\PhalApi\DI()->config->get("app.redis.servers"));
}

```

常用基础操作(具体API可以查阅代码中src/Lite.php)

```
// 存入永久的键值队
\PhalApi\DI()->redis->set_forever(键名,值,库名);
// 获取永久的键值队
\PhalApi\DI()->redis->get_forever(键名, 库名);
    
// 存入一个有时效性的键值队,默认600秒
\PhalApi\DI()->redis->set_Time(键名,值,有效时间,库名);
// 获取一个有时效性的键值队
\PhalApi\DI()->redis->get_Time(键名, 库名);
    
// 写入队列左边
\PhalApi\DI()->redis->set_Lpush(队列键名,值, 库名);
// 读取队列右边
\PhalApi\DI()->redis->get_lpop(队列键名, 库名);
// 读取队列右边 如果没有读取到阻塞一定时间(阻塞时间或读取配置文件blocking的值)
\PhalApi\DI()->redis->get_Brpop(队列键名,值, 库名);
    
// 删除一个键值队适用于所有
\PhalApi\DI()->redis->del(键名, 库名);
// 自动增长
\PhalApi\DI()->redis->get_incr(键名, 库名);
// 切换DB并且获得操作实例
\PhalApi\DI()->redis->get_redis(键名, 库名);
    
```


**如果大家有更好的建议可以私聊或加入到PhalApi大家庭中前来一同维护PhalApi**
**注:笔者能力有限有说的不对的地方希望大家能够指出,也希望多多交流!**
