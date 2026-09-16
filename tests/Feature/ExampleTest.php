<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Statamic\Eloquent\Collections\CollectionModel;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * The programs endpoint is publicly available.
     */
    public function test_the_programs_api_returns_a_successful_response(): void
    {
        CollectionModel::query()->create([
            'handle' => 'programs',
            'title' => 'Programs',
            'settings' => ['dated' => false],
        ]);

        $response = $this->getJson('/api/programs');

        $response
            ->assertOk()
            ->assertJson(['data' => []]);
    }
}
