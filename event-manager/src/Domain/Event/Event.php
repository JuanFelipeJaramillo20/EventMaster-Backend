<?php

declare(strict_types=1);

namespace App\Domain\Event;

use JsonSerializable;

/**
 * @OA\Schema(
 *     title="Event",
 *     description="A model representing an event."
 * )
 */
class Event implements JsonSerializable
{
    /**
     * @OA\Property(type="integer", format="int64", readOnly=true, example=1)
     */
    private ?int $id;

    /**
     * @OA\Property(type="string", example="Event Name")
     */
    private string $name;

    /**
     * @OA\Property(type="string", example="Event Description")
     */
    private string $description;

    /**
     * @OA\Property(type="string", example="Event Type")
     */
    private string $type;

    /**
     * @OA\Property(type="integer", example=100)
     */
    private int $capacity;

    /**
     * @OA\Property(type="integer", format="int64", readOnly=true, example=1)
     */
    private ?int $user_creator_id;


    public function __construct(?int $id, string $name, string $description, string $type, int $capacity, int $user_creator_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->capacity = $capacity;
        $this->user_creator_id = $user_creator_id;
    }

    public function getUserCreatorId(): ?int
    {
        return $this->user_creator_id;
    }

    public function setUserCreatorId(?int $user_creator_id): void
    {
        $this->user_creator_id = $user_creator_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'capacity' => $this->capacity,
            'user_creator_id' => $this->user_creator_id,
        ];
    }
}
