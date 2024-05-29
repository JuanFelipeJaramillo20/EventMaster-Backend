<?php

namespace App\Application\Actions\User;

use App\Traits\UserDataValidatorTrait;
use Psr\Http\Message\ResponseInterface as Response;

class UpdateUserAction extends UserAction
{
    use UserDataValidatorTrait;

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $userData = $this->getFormData();
        $validatedUserData = $this->getValidatedUserData($userData);
        $encryptedPassword = password_hash($validatedUserData['password'], PASSWORD_DEFAULT);
        $validatedUserData['password'] = $encryptedPassword;
        $user = $this->userRepository->updateUser($userId, $validatedUserData);

        $this->logger->info("User updated: " . json_encode($user));

        return $this->respondWithData($user);
    }
}