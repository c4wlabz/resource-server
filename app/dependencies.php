<?php

$container = $app->getContainer();

$container['logger'] = function($c) {
    $logger = new \Monolog\Logger('slim');
    $formatter = new \Monolog\Formatter\LineFormatter("[%datetime%] [%level_name%]: %message%\n");
    $file_handler = new \Monolog\Handler\StreamHandler(STORAGE_PATH . '/logs/app.log');
    $file_handler->setFormatter($formatter);
    $logger->pushHandler($file_handler);
    return $logger;
};

$container['db'] = function (\Slim\Container $c) {
    $settings = $c->get('settings')['db'];
    $dsn = "{$settings['driver']}:host={$settings['host']};port={$settings['port']};dbname={$settings['dbname']};charset={$settings['charset']}";
    $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_PERSISTENT => false,
        \PDO::ATTR_EMULATE_PREPARES => false,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$settings['charset']} COLLATE {$settings['collate']}"
    ];
    return new \PDO($dsn, $settings['username'], $settings['password'], $options);
};
