<?php

namespace App\Application\Actions\Event;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * @OA\Get(
 *   tags={"event"},
 *   path="/events",
 *   operationId="listEvents",
 *   summary="List all events",
 *   description="Returns a list of all events",
 *   @OA\Response(
 *     response=200,
 *     description="Successful operation",
 *     @OA\JsonContent(
 *       type="array",
 *       @OA\Items(ref="#/components/schemas/Event")
 *     )
 *   )
 * )
 */
class ListEventsAction extends EventAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $events = $this->eventRepository->findAll();

        $this->logger->info("Events list was viewed.");

        return $this->respondWithData($events);
    }
}
