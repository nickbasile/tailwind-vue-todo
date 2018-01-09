<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_the_todos()
    {
        $todos = factory('App\Todo', 3)->create();

        $this->get('/todos')
            ->assertStatus(200)
            ->assertJson($todos->toArray());
    }

    /** @test */
    public function can_create_a_todo()
    {
        $todo = factory('App\Todo')->make()->toArray();

        $this->post('/todos', $todo)
            ->assertStatus(201)
            ->assertJson($todo);

        $this->assertDatabaseHas('todos', $todo);
    }

    /** @test */
    public function can_get_a_validation_error_when_trying_to_create_an_empty_todo()
    {
        $this->post('/todos', [])
            ->assertStatus(302);
    }
}
