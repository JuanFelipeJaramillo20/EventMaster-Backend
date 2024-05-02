<?php

declare(strict_types=1);

use App\Domain\User\UserRepository;
use App\Domain\Event\EventRepository;
use App\Infrastructure\Persistence\User\PostgresUserRepository;
use App\Infrastructure\Persistence\Event\PostgresEventRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(PostgresUserRepository::class),
        EventRepository::class => \DI\autowire(PostgresEventRepository::class),
    ]);
};
