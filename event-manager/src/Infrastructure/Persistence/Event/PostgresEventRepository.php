<?php

namespace App\Infrastructure\Persistence\Event;

use App\Domain\Event\Event;
use App\Domain\Event\EventNotFoundException;
use App\Domain\Event\EventRepository;
use App\Domain\User\User;
use PDO;

class PostgresEventRepository implements EventRepository
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT * FROM evento');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @inheritDoc
     */
    public function findEventById(int $id): ?Event
    {
        $statement = $this->pdo->prepare('SELECT * FROM evento WHERE id = :id');
        $statement->execute(['id' => $id]);
        $evento = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$evento) {
            throw new EventNotFoundException();
        }

        return new Event(
            (int)$evento['id'],
            $evento['name'],
            $evento['description'],
            $evento['type'],
            $evento['capacity'],
            (int)$evento['user_creator_id'],
        );
    }

    /**
     * @inheritDoc
     */
    public function createEvent(array $eventData): Event
    {
        $statement = $this->pdo->prepare('INSERT INTO evento (name, description, type, capacity, user_creator_id) VALUES (:name, :description, :type, :capacity, :user_creator_id)');
        $statement->execute([
            'name' => $eventData['name'],
            'description' => $eventData['description'],
            'type' => $eventData['type'],
            'capacity' => $eventData['capacity'],
            'user_creator_id' => $eventData['user_creator_id'],
        ]);

        $eventId = (int)$this->pdo->lastInsertId();
        return new Event($eventId, $eventData['name'], $eventData['description'], $eventData['type'], $eventData['capacity'], $eventData['user_creator_id']);
    }

    /**
     * @inheritDoc
     */
    public function updateEvent(int $id, array $eventData): Event
    {
        $statement = $this->pdo->prepare('UPDATE evento SET name = :name, description = :description, type = :type, capacity = :capacity WHERE id = :id');
        $statement->execute([
            'id' => $id,
            'name' => $eventData['name'],
            'description' => $eventData['description'],
            'type' => $eventData['type'],
            'capacity' => $eventData['capacity']
        ]);

        return new Event($id, $eventData['name'], $eventData['description'], $eventData['type'], $eventData['capacity'], $eventData['user_creator_id']);
    }

    /**
     * @inheritDoc
     */
    public function deleteEvent(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM evento WHERE id = :id');
        $statement->execute(['id' => $id]);
    }

    /**
     * @inheritDoc
     */
    public function addUserToEvent(int $eventId, User $user): void
    {
        $statement = $this->pdo->prepare('INSERT INTO usuario_evento (eventId, userId) VALUES (:eventId, :userId)');
        $statement->execute([
            'eventId' => $eventId,
            'userId' => $user->getId()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function removeUserFromEvent(int $eventId, int $userId): void
    {
        $statement = $this->pdo->prepare('DELETE FROM usuario_evento WHERE eventId = :eventId AND userId = :userId');
        $statement->execute([
            'eventId' => $eventId,
            'userId' => $userId
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getEventAttendees(int $eventId): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM usuario_evento WHERE eventId = :eventId');
        $statement->execute(['eventId' => $eventId]);
        $userIds = $statement->fetchAll(PDO::FETCH_COLUMN, 2); // Assuming the userId is in the second column

        $attendees = [];
        foreach ($userIds as $userId) {
            $userStatement = $this->pdo->prepare('SELECT * FROM usuario WHERE id = :userId');
            $userStatement->execute(['userId' => $userId]);
            $userData = $userStatement->fetch(PDO::FETCH_ASSOC);
            if ($userData) {
                $attendees[] = new User(
                    (int)$userData['id'],
                    $userData['email'],
                    $userData['firstName'],
                    $userData['lastName'],
                    $userData['password']
                );
            }
        }

        return $attendees;
    }

}