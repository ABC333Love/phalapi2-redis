<?php
/**
 * 请在下面放置任何您需要的应用配置
 */

return array(

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
        
        //使用阻塞式读取队列时的等待时间单位/秒
        'blocking'  => 5,
    ),
);
