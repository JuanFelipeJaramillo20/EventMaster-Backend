<?php

namespace App\Application\Actions\Event;

use App\Application\Actions\Event\EventAction;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteEventAction extends EventAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $eventId = (int) $this->resolveArg('id');

        $this->eventRepository->deleteEvent($eventId);

        $this->logger->info("Event deleted: ID $eventId");

        return $this->respondWithData(['message' => 'Event deleted successfully.']);
    }
}