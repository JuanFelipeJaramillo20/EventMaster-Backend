<?php

declare(strict_types=1);

namespace App\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;

    /**
     * @param string $email
     * @return User
     * @throws UserNotFoundException
     */
    public function findUserByEmail(string $email): User;

    /**
     * @param $userId int
     * @return void
     * @throws UserNotFoundException
     */
    public function updateLastLoginTimestamp(int $userId): void;

    /**
     * Create a new user.
     *
     * @param array $userData
     * @return User
     */
    public function createUser(array $userData): User;

    /**
     * Update an existing user.
     *
     * @param int $id
     * @param array $userData
     * @return User
     * @throws UserNotFoundException
     */
    public function updateUser(int $id, array $userData): User;

    /**
     * Delete a user.
     *
     * @param int $id
     * @throws UserNotFoundException
     */
    public function deleteUser(int $id): void;
}
