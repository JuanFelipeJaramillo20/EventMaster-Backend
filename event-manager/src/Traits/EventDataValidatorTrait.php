<?php

namespace App\Traits;

trait EventDataValidatorTrait
{
    protected function getValidatedEventData(array $data): ?array
    {
        $requiredFields = ['name', 'description', 'type', 'capacity', 'user_creator_id'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return null;
            }
        }

        return $data;
    }
}