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

    public function test_add_result(): string
    {
        $member = Member::factory()->make();

        $this->postJson(route('add_results'), ['email' => $member->email, 'milliseconds' => 1000]);
        $response = $this->postJson(route('add_results'), ['email' => $member->email, 'milliseconds' => 900]);
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

        return $member->email;
    }

    /**
     * @param $email
     * @return void
     *
     * @depends test_add_result
     */
    public function test_get_results($email): void
    {
        $response = $this->getJson(route('get_results'));
        $response->assertStatus(200);

        $response = $this->getJson(route('get_results') . '?email=' . $email);
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => ['self' => ['email' => $email, 'milliseconds' => 900]],
            ]);
    }
}
