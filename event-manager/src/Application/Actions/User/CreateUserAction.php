<?php

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use App\Traits\UserDataValidatorTrait;

class CreateUserAction extends UserAction
{
    use UserDataValidatorTrait;

    protected function action(): Response
    {
        $userData = $this->getFormData();
        $validatedUserData = $this->getValidatedUserData($userData);

        if ($validatedUserData === null) {
            return $this->respondWithData(['error' => 'Invalid user data'], 400);
        }

        $encryptedPassword = password_hash($validatedUserData['password'], PASSWORD_DEFAULT);

        $validatedUserData['password'] = $encryptedPassword;

        $user = $this->userRepository->createUser($validatedUserData);

        $this->logger->info("User created: " . json_encode($user));

        return $this->respondWithData($user, 201);
    }
}