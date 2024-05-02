<?php

namespace App\Application\Actions\Event;

use Psr\Http\Message\ResponseInterface as Response;
use App\Traits\EventDataValidatorTrait;

/**
 * @OA\Post(
 *   tags={"event"},
 *   path="/events",
 *   operationId="createEvent",
 *   summary="Create a new event",
 *   description="Creates a new event with the provided data",
 *   @OA\RequestBody(
 *     required=true,
 *     description="Event data",
 *     @OA\JsonContent(ref="#/components/schemas/Event")
 *   ),
 *   @OA\Response(
 *     response=201,
 *     description="Event created successfully",
 *     @OA\JsonContent(ref="#/components/schemas/Event")
 *   ),
 *   @OA\Response(
 *     response=400,
 *     description="Invalid event data",
 *     @OA\JsonContent(
 *       type="object",
 *       @OA\Property(property="error", type="string", example="Invalid event data")
 *     )
 *   )
 * )
 */
class CreateEventAction extends EventAction
{
    use EventDataValidatorTrait;

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $eventData = $this->getFormData();
        $validatedEventData = $this->getValidatedEventData($eventData);

        if ($validatedEventData === null) {
            return $this->respondWithData(['error' => 'Invalid event data'], 400);
        }

        $event = $this->eventRepository->createEvent($validatedEventData);

        $this->logger->info("Event created: " . json_encode($event));

        return $this->respondWithData($event, 201);
    }
}
