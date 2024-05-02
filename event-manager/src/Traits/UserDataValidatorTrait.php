<?php

namespace App\Traits;

trait UserDataValidatorTrait
{
    private function getValidatedUserData(array $userData): ?array
    {
        if (
            isset($userData['email']) &&
            isset($userData['password']) &&
            isset($userData['firstName']) &&
            isset($userData['lastName'])
        ) {
            return $userData;
        }

        return null;
    }
}
