<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


 
class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
 
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
 
        $response->assertStatus(200);
    }
 
    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();
 
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
 
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
 
    public function test_admins_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'is_admin' => true
            ]);
 
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
 
        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_cant_authenticate_with_invalid_email()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => 'random@email.com',
            'password' => 'password',
        ]);
 
        $this->assertGuest();
    }


    public function test_users_cant_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
 
        $this->assertGuest();
    }

    public function test_users_cant_authenticate_with_security_breach()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email."'--",
            'password' => 'wrong-password',
        ]);
        $this->assertGuest();
    }
}