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

/*     public function test_Buy_screen_can_be_rendered()
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

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'owner_id'  => $seller->id,
            'public' => true,
        ]);

        $tier = Tier::factory()->create([
            'haschatperk' => false,
            'hasscheduleperk' => false,
            'course_id'  => $course->id,
            'price' => 5
        ]);

        $this->assertDatabaseHas('tiers', [
            'haschatperk' => false,
            'hasscheduleperk' => false,
            'id' => $tier->id,
            'course_id'  => $course->id,
            'price' => 5
        ]);

        $buyer = User::factory()->create([
            'balance' => 1000,
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $buyer->id,
            'balance' => 1000
        ]);

        $this->post('/login', [
            'email' => $buyer->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        //pagamento com saldo
        $response = $this->post('/comprarCurso/tier', [
            'course' => 130,
            'tier' => $tier->id,
            'saldo' => true,
        ]);

        $this->assertDatabaseHas('sales', [
            'tier_id' => $tier->id,
            'user_id' => $buyer->id
        ]);
    } */
}