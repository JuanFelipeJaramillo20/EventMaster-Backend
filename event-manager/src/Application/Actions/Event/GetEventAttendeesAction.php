<?php

namespace App\Application\Actions\Event;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Event\EventNotFoundException;
use App\Domain\User\UserNotFoundException;

class GetEventAttendeesAction extends EventAction
{
    protected function action(): Response
    {
        $eventId = (int) $this->resolveArg('id');

        $attendees = $this->eventRepository->getEventAttendees($eventId);
        return $this->respondWithData($attendees);
    }
}
