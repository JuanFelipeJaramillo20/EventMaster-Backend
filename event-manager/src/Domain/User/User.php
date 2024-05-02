<?php

declare(strict_types=1);

namespace App\Domain\User;

use JsonSerializable;

/**
 * @OA\Schema(
 *     title="User",
 *     description="A simple user model."
 * )
 */
class User implements JsonSerializable
{
    /**
     * @OA\Property(type="integer", format="int64", readOnly=true, example=1)
     */
    private ?int $id;

    /**
     * @OA\Property(type="string", example="juanfelipejaramillolosada@gmail.com")
     */
    private string $email;

    /**
     * @OA\Property(type="string", example="securePassword")
     */
    private string $password;

    /**
     * @OA\Property(type="string", example="Juan")
     */
    private string $firstName;

    /**
     * @OA\Property(type="string", example="Jaramillo")
     */
    private string $lastName;

    public function __construct(?int $id, string $email, string $firstName, string $lastName, string $password)
    {
        $this->id = $id;
        $this->email = strtolower($email);
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
        $this->password = $password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = strtolower($email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = ucfirst($firstName);
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = ucfirst($lastName);
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            // 'password' => $this->password,
        ];
    }
}
