<?php

namespace App\Application\Actions\Event;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Event\EventNotFoundException;
use App\Domain\User\UserNotFoundException;

class AddUserToEventAction extends EventAction
{
    protected function action(): Response
    {
        $eventId = (int) $this->resolveArg('id');
        $formData = $this->getFormData();
        $userId = (int) $formData['userId'];

        try {
            $user = $this->userRepository->findUserOfId($userId);
        } catch (UserNotFoundException $e) {
            return $this->respondWithData(['error' => 'User not found'], 404);
        }

        $this->eventRepository->addUserToEvent($eventId, $user);
        return $this->respondWithData(['message' => 'User added to event successfully']);
    }
}
