<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameResultsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_add_result(): void
    {
        $member = Member::factory()->make();

        $response = $this->postJson(route('add_results'), ['email' => $member->email, 'milliseconds' => 1000]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
            ]);

        $response = $this->postJson(route('add_results'), ['milliseconds' => 800]);
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
            ]);
    }
}