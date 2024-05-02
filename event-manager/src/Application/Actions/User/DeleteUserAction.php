<?php

namespace App\Application\Actions\User;

use App\Application\Actions\User\UserAction;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteUserAction extends UserAction
{

    /**
     * @inheritDoc
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');

        $this->userRepository->deleteUser($userId);

        $this->logger->info("User deleted: ID $userId");

        return $this->respondWithData(['message' => 'User deleted successfully']);
    }
}