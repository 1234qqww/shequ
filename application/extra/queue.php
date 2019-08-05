<?php
return [
    // 'connector' => 'Sync'
    'connector' => 'Database',   // 数据库驱动
    'expire'    => 60,           // 任务的过期时间，默认为60秒; 若要禁用，则设置为 null
    'default'   => 'default',    // 默认的队列名称
    'table'     => '',   // 存储消息的表名，不带前缀
    'dsn'       => [],
];
