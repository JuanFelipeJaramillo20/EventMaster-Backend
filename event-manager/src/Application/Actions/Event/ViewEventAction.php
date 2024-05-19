<?php

namespace App\Application\Actions\Event;

use App\Domain\Event\EventNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * @OA\Get(
 *     tags={"event"},
 *     path="/events/{id}",
 *     operationId="getEventById",
 *     summary="Get event by ID",
 *     description="Returns a single event",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the event to return",
 *         required=true,
 *         @OA\Schema(
 *             type="integer",
 *             format="int64"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Event")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Event not found"
 *     )
 * )
 */
class ViewEventAction extends EventAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $eventId = (int) $this->resolveArg('id');
        $event = $this->eventRepository->findEventById($eventId);

        $this->logger->info("Event of id `{$eventId}` was viewed.");

        return $this->respondWithData($event);

    }
}
