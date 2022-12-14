<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\Pure;

class LogFilter
{
    private array $allowFilters = [
        'serviceName',
        'statusCode',
        'startDate',
        'endDate'
    ];
    private array $tempFilters = [];
    private array $filters = [];
    private array $errors = [];

    public function getAllowFilters(): array
    {
        return $this->allowFilters;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getTempFilters(): array
    {
        return $this->tempFilters;
    }

    public function __construct($filters)
    {
        $this->tempFilters = $filters;
    }

    public function validateFilters(): void
    {
        $filterValidator = Validator::make($this->getFilters(), [
            'serviceName' => 'nullable',
            'statusCode' => 'nullable',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date|after:startDate'
        ]);
        if (count($filterValidator->errors()->messages())) {
            $this->errors = $filterValidator->errors()->messages();
        }
    }

    public function filters(): array
    {
        if (count($this->getTempFilters()) > 0) {
            foreach ($this->getTempFilters() as $filterKey => $filterValue) {
                if (in_array($filterKey, $this->getAllowFilters())) {
                    $this->filters[$filterKey] = $filterValue;
                }
            }
        }

        $this->validateFilters();
        if ($this->errors) {
            return [
                'error' => true,
                'data' => $this->errors
            ];
        }
        return [
            'error' => false,
            'data' => $this->getFilters()
        ];
    }
}
