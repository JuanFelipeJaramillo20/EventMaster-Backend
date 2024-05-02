<?php

namespace App\Domain\UserEvent;

class UserEvent
{
    private int $userId;
    private int $eventId;

    public function __construct(int $userId, int $eventId)
    {
        $this->userId = $userId;
        $this->eventId = $eventId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getEventId(): int
    {
        return $this->eventId;
    }

    public function setEventId(int $eventId): void
    {
        $this->eventId = $eventId;
    }
}