<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createTestDatabase();
    }

    private function createTestDatabase(): void
    {
        $this->artisan('migrate:fresh', ['--env' => 'testing']);
        $this->artisan('db:seed', ['--env' => 'testing']);
    }
}
