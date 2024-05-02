<?php

namespace App\Application\Actions\Event;

use Psr\Http\Message\ResponseInterface as Response;
use App\Traits\EventDataValidatorTrait;

class UpdateEventAction extends EventAction
{
    use EventDataValidatorTrait;

    protected function action(): Response
    {
        $eventId = (int) $this->resolveArg('id');
        $eventData = $this->getFormData();
        $validatedEventData = $this->getValidatedEventData($eventData);

        if ($validatedEventData === null) {
            return $this->respondWithData(['error' => 'Invalid event data'], 400);
        }

        $event = $this->eventRepository->updateEvent($eventId, $validatedEventData);

        $this->logger->info("Event updated: " . json_encode($event));

        return $this->respondWithData($event, 200);
    }

    private function getValidatedEventData(array $eventData): ?array
    {
        $requiredFields = ['name', 'description', 'type', 'capacity'];

        foreach ($requiredFields as $field) {
            if (empty($eventData[$field])) {
                return null;
            }
        }

        return $eventData;
    }
}
