<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => false, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'host' => getenv('DB_HOST') ?: 'demo5.linkisite.com',
                    'port' => getenv('DB_PORT') ?: '3306',
                    'database' => getenv('DB_DATABASE') ?: 'demo5linkisite_mydb2',
                    'username' => getenv('DB_USERNAME') ?: 'demo5linkisite_myuser2',
                    'password' => getenv('DB_PASSWORD') ?: 'uB7UsE_3Bzzh',
                ],
            ]);
        }
    ]);
};
