<?php

namespace Tests\Feature;

use App\Models\log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * create 20 logs and test that's count
     *
     * @return void
     */
    public function test_add_20_logs()
    {
        $logs = log::factory(20)->create();
        $this->assertCount(20, $logs);
    }

    /**
     * create 20 logs and make a request to fetch logs
     *
     * @return void
     */
    public function test_get_logs_from_http_request()
    {
        log::factory(20)->create();
        $response = $this->get('/api/logs');
        $response->assertStatus(200);
        $responseJson = $response->json();
        $count = $responseJson['count'];
        $logs = $responseJson['logs'];
        $this->assertCount(20, $logs);
        $this->assertEquals(20, $count);
    }

    /**
     * create 20 logs and make a request to fetch logs with invalid url
     *
     * @return void
     */
    public function test_get_logs_from_http_request_with_invalid_url()
    {
        log::factory(20)->create();
        $response = $this->get('/api/logs?serviceName=getUserLists&statusCode=301&startDate=:)&endDate=:)');
        $response->assertStatus(401);
        $responseJson = $response->json();
        $this->assertTrue($responseJson['error']);
        $this->assertArrayHasKey('startDate', $responseJson['data']);
        $this->assertArrayHasKey('endDate', $responseJson['data']);
        $this->assertEquals('The start date is not a valid date.', $responseJson['data']['startDate'][0]);
        $this->assertEquals('The end date is not a valid date.', $responseJson['data']['endDate'][0]);
        $this->assertEquals('The end date must be a date after start date.', $responseJson['data']['endDate'][1]);
    }

    /**
     * create logs from log file
     *
     * @return void
     */
    public function test_console_log_command()
    {
        $this->artisan('logs:read log.txt')->assertSuccessful();
    }

}
