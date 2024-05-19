<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use PDO;

class PostgresUserRepository implements UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $statement = $this->pdo->query('SELECT * FROM usuario');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUserOfId(int $id): User
    {
        $statement = $this->pdo->prepare('SELECT * FROM usuario WHERE id = :id');
        $statement->execute(['id' => $id]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return new User(
            (int)$user['id'],
            $user['email'],
            $user['firstName'],
            $user['lastName'],
            $user['password']
        );
    }

    public function findUserByEmail(string $email): User
    {
        $statement = $this->pdo->prepare('SELECT * FROM usuario WHERE email = :email');
        $statement->execute(['email' => $email]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return new User(
            (int)$user['id'],
            $user['email'],
            $user['firstName'],
            $user['lastName'],
            $user['password']
        );
    }

    public function updateLastLoginTimestamp(int $userId): void
    {
        $statement = $this->pdo->prepare('UPDATE usuario SET last_login_timestamp = now() WHERE id = :id');
        $statement->execute([
            'id' => $userId
        ]);
    }

    public function createUser(array $userData): User
    {
        $statement = $this->pdo->prepare('INSERT INTO usuario (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)');
        $statement->execute([
            'firstName' => $userData['firstName'],
            'lastName' => $userData['lastName'],
            'email' => $userData['email'],
            'password' => $userData['password']
        ]);

        $userId = (int)$this->pdo->lastInsertId();
        return new User($userId, $userData['email'], $userData['firstName'], $userData['lastName'], $userData['password']);
    }

    public function updateUser(int $id, array $userData): User
    {
        $statement = $this->pdo->prepare('UPDATE usuario SET firstName = :firstName, lastName = :lastName, email = :email, password = :password WHERE id = :id');
        $statement->execute([
            'id' => $id,
            'firstName' => $userData['firstName'],
            'lastName' => $userData['lastName'],
            'email' => $userData['email'],
            'password' => $userData['password']
        ]);

        return new User($id, $userData['email'], $userData['firstName'], $userData['lastName'], $userData['password']);
    }

    public function deleteUser(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM usuario WHERE id = :id');
        $statement->execute(['id' => $id]);
    }
}
