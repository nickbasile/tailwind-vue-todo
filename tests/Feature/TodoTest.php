<?php

namespace Tests\Feature;

use Carbon\Carbon;
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

    /** @test
     * @throws \Exception
     */
    public function can_get_all_the_todos_in_the_correct_order()
    {
        $todo_one = factory('App\Todo')->create([
                'created_at' => Carbon::now()->subWeeks(1),
                'updated_at' => Carbon::now()->subWeeks(1)
            ])
            ->toArray();

        $todo_two = factory('App\Todo')->create([
                'created_at' => Carbon::now()->subWeeks(2),
                'updated_at' => Carbon::now()->subWeeks(2)
            ])
            ->toArray();

        $todos = collect([$todo_one, $todo_two])->pluck('id');

        $response = $this->get('/todos');

        $this->assertEquals(collect($response->decodeResponseJson())->pluck('id'), $todos);
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
    public function cant_create_an_empty_todo()
    {
        $this->post('/todos', [])
            ->assertStatus(302);
    }

    /** @test */
    public function can_get_a_single_todo()
    {
        $todo = factory('App\Todo')->create();

        $this->get('/todos/'. $todo->id)
            ->assertStatus(200)
            ->assertJson($todo->toArray());
    }

    /** @test */
    public function can_update_a_todo()
    {
        $todo = factory('App\Todo')->create()->toArray();

        $updated_todo = factory('App\Todo')->make()->toArray();

        $this->patch('/todos/'. $todo['id'], $updated_todo)
            ->assertStatus(200)
            ->assertJson($updated_todo);

        $this->assertDatabaseHas('todos', $updated_todo);
        $this->assertDatabaseMissing('todos', $todo);
    }

    /** @test */
    public function cant_update_an_empty_todo()
    {
        $todo = factory('App\Todo')->create()->toArray();

        $this->patch('/todos/'. $todo['id'], [])
            ->assertStatus(302);
    }

    /** @test */
    public function can_delete_a_todo()
    {
        $todo = factory('App\Todo')->create()->toArray();

        $this->delete('/todos/'. $todo['id'])
            ->assertStatus(200);

        $this->assertDatabaseMissing('todos', $todo);
    }
}
