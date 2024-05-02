<?php

namespace App\Application\Actions\Event;

use Psr\Http\Message\ResponseInterface as Response;

class RemoveUserFromEventAction extends EventAction
{
    protected function action(): Response
    {
        $eventId = (int) $this->resolveArg('id');
        $formData = $this->getFormData();
        $userId = (int) $formData['userId'];

        try {
            $this->eventRepository->removeUserFromEvent($eventId, $userId);
            return $this->respondWithData(['message' => 'User removed from event successfully']);
        } catch (\Exception $e) {
            return $this->respondWithData(['error' => 'Failed to remove user from event'], 500);
        }
    }
}
