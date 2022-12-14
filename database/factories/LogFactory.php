<?php

namespace Database\Factories;

use App\Models\log;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{

    protected $model = log::class;

    public array $serviceNames = [
        'getUserLists',
        'getBooksLists',
        'deleteUser',
        'editUser',
        'deleteBook',
        'editBook',
        'getCompaniesList',
        'deleteCompany',
        'editCompany'
    ];


    public array $statusCode = [
        200,
        301,
        400,
        404,
        500,
        505,
        201
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'serviceName' => $this->serviceNames[rand(0, sizeof($this->serviceNames) - 1)],
            'statusCode' => $this->statusCode[rand(0, sizeof($this->statusCode) - 1)],
            'startDate' => fake()->dateTime,
            'endDate' => fake()->dateTime
        ];
    }
}
