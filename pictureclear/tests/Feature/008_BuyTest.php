<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Tier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_Buy_screen_can_be_rendered()
    {
        $seller = User::factory()->create();

        $this->post('/login', [
            'email' => $seller->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $course = Course::factory()->create([
            'owner_id'  => $seller->id,
            'public' => true,
        ]);

        $tier = Tier::factory()->create([
            'course_id'  => $course->id,
        ]);

        $buyer = User::factory()->create();

        $this->post('/login', [
            'email' => $buyer->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        //pagamento com saldo
        $response = $this->post('/comprarCurso/tier', [
            'tier' => $tier->id,
            'saldo' => true,
            'course' => $course->id,
        ]);

        $this->assertDatabaseHas('sales', [
            'user_id'=> $buyer->id,
            'tier_id' => $tier->id,
        ]);
    }
}
