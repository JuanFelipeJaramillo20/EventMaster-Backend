<?php

namespace App\Application\Actions\User;

use App\Domain\User\UserNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends UserAction
{
    protected function action(): Response
    {
        $requestData = $this->getFormData();
        $email = $requestData['email'] ?? '';
        $password = $requestData['password'] ?? '';

        try {

            $user = $this->userRepository->findUserByEmail($email);

            if (password_verify($password, $user->getPassword())) {
                return $this->respondWithData(['success' => true]);
            } else {
                return $this->respondWithData(['success' => false, 'error' => 'Invalid username or password'], 401);
            }
        } catch (UserNotFoundException $e) {
            return $this->respondWithData(['success' => false, 'error' => 'Invalid username or password'], 401);
        }
    }
}