<?php

namespace App\Traits;

trait EventDataValidatorTrait
{
    protected function getValidatedEventData(array $data): ?array
    {
        $requiredFields = ['name', 'description', 'type', 'capacity'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                return null;
            }
        }

        return $data;
    }
}