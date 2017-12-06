<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Todo;

class TodoTest extends TestCase
{
    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function indexTest()
    {
        $response = $this->get('/todo');
        $response->assertStatus(200);
    }

    /** @test */
    public function createTest()
    {
        $response = $this->get('/todo/create');
        $response->assertStatus(200);
    }

    /** @test */
    public function storeTest()
    {
        $this->post('/todo',
            ['title' => "foo"]
        );
        $this->assertDatabaseHas('todos', ['title' => 'foo']);
    }

    /** @test */
    public function editTest()
    {
        $responce = $this->get('/todo/1/edit');
        $responce->assertStatus(200);
    }

    /** @test */
    public function updateTest()
    {
        $this->put('todo/1',
                   ['title' => 'updateData']
        );
        $this->assertDatabaseHas('todos', ['title' => 'updateData']);
    }

    /** @test */
    public function destroyTest()
    {
        $this->delete('/todo/1');
        $this->assertDatabaseMissing('todos', ['id' => 1]);
    }
}
