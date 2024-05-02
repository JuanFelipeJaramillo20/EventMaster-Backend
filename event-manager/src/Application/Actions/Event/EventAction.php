<?php

namespace App\Application\Actions\Event;

use App\Application\Actions\Action;
use App\Domain\Event\EventRepository;
use App\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class EventAction extends Action
{

    protected EventRepository $eventRepository;
    protected UserRepository $userRepository;

    public function __construct(LoggerInterface $logger, EventRepository $eventRepository, UserRepository $userRepository)
    {
        parent::__construct($logger);
        $this->eventRepository = $eventRepository;
        $this->userRepository = $userRepository;
    }
}