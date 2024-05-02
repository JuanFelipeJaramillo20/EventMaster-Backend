<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\User\User;

interface EventRepository
{
    /**
     * Fetches all events.
     *
     * @return Event[] Array of Event objects
     */
    public function findAll(): array;

    /**
     * Fetches a single event by its ID.
     *
     * @param int $id The ID of the event to fetch
     * @return Event|null The event object if found, null otherwise
     */
    public function findEventById(int $id): ?Event;

    /**
     * Creates a new event.
     *
     * @param array $eventData The data for the new event
     * @return Event The created event object
     */
    public function createEvent(array $eventData): Event;

    /**
     * Updates an existing event.
     *
     * @param int $id The ID of the event to update
     * @param array $eventData The updated data for the event
     * @return Event The updated event object
     */
    public function updateEvent(int $id, array $eventData): Event;

    /**
     * Deletes an event.
     *
     * @param int $id The ID of the event to delete
     * @return void
     */
    public function deleteEvent(int $id): void;

    /**
     * Adds a user to the attendees list of an event.
     *
     * @param int $eventId The ID of the event
     * @param User $user The user to add to the event
     * @return void
     */
    public function addUserToEvent(int $eventId, User $user): void;

    /**
     * Removes a user from the attendees list of an event.
     *
     * @param int $eventId The ID of the event
     * @param int $userId The ID of the user to remove
     * @return void
     */
    public function removeUserFromEvent(int $eventId, int $userId): void;

    /**
     * Retrieves the list of attendees for an event.
     *
     * @param int $eventId The ID of the event
     * @return User[] Array of User objects representing attendees
     */
    public function getEventAttendees(int $eventId): array;
}
