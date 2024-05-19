<?php

namespace App\Application\Actions\User;

use App\Domain\User\UserNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use App\Traits\AccessTokenGeneratorTrait;

class LoginAction extends UserAction
{

    use AccessTokenGeneratorTrait;

    protected function action(): Response
    {
        $requestData = $this->getFormData();
        $email = $requestData['email'] ?? '';
        $password = $requestData['password'] ?? '';

        try {

            $user = $this->userRepository->findUserByEmail($email);
            error_log("Received request data: " . json_encode($requestData));
            error_log("Received user data: " . json_encode($user));
            if (password_verify($password, $user->getPassword())) {
                $accessToken = $this->generateAccessToken($user);
                $this->userRepository->updateLastLoginTimestamp($user->getId());
                return $this->respondWithData(['success' => true, 'access_token' => $accessToken]);
            } else {
                return $this->respondWithData(['success' => false, 'error' => 'Invalid username or password'], 401);
            }
        } catch (UserNotFoundException $e) {
            return $this->respondWithData(['success' => false, 'error' => 'Invalid username or password'], 401);
        }
    }
}