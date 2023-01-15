<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Tier;



class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_feed_screen_can_be_rendered()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response = $this->get('/home');

        $response->assertStatus(200);
    }

    public function test_feed_screen_can_be_rendered_as_ratings_asc()
    {
        $user = User::factory()->create();
        Course::factory(10)->create();
        Tier::factory(10)->create();
        
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->get('/home?dropdown=rating_asc');

        $response->assertStatus(200);
    }

    public function test_feed_screen_can_be_rendered_as_ratings_desc()
    {
        $user = User::factory()->create();
        Course::factory(10)->create();
        Tier::factory(10)->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->get('/home?dropdown=rating_desc');

        $response->assertStatus(200);
    }

    public function test_feed_screen_can_be_rendered_as_price_asc()
    {
        $user = User::factory()->create();
        Course::factory(10)->create();
        Tier::factory(10)->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->get('/home?dropdown=price_asc');

        $response->assertStatus(200);
    }
    
    public function test_feed_screen_can_be_rendered_as_price_desc()
    {
        $user = User::factory()->create();
        Course::factory(10)->create();
        Tier::factory(10)->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->get('/home?dropdown=price_desc');

        $response->assertStatus(200);
    }

    public function test_feed_screen_can_be_rendered_as_creation_asc()
    {
        $user = User::factory()->create();
        Course::factory(10)->create();
        Tier::factory(10)->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->get('/home?dropdown=id_asc');

        $response->assertStatus(200);
    }
    
    public function test_feed_screen_can_be_rendered_as_creation_desc()
    {
        $user = User::factory()->create();
        Course::factory(10)->create();
        Tier::factory(10)->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->get('/home?dropdown=id_desc');

        $response->assertStatus(200);
    }
}
