<?php

namespace Tests\Unit;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class RegistrationTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }
 
    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'username' => 'testuser',
            'password' => 'Password1+',
            'password_confirmation' => 'Password1+',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
        $this->assertAuthenticated();
        // $response->assertRedirect(url('/email/verify'));
    }


}