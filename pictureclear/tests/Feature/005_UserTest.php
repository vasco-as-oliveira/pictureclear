<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;


class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_screen_can_be_rendered()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->get('/profile?username='.$user->username);
        $response->assertStatus(200);
    }

    public function test_edit_profile_screen_can_be_rendered()
    {
        $user = User::factory()->create();
        
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->get('/editarperfil');
        $response->assertStatus(200);
    }

    public function test_user_can_edit_profile()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $file = 'test-image.png';

        $response = $this->post('/editarperfil/save', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'about' => 'Lorem ipsum dolor sit amet, consectetur.',
            'image' => $image = UploadedFile::fake()->image($file)
        ]);

        $this->assertDatabaseHas('users', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'description' => 'Lorem ipsum dolor sit amet, consectetur.',
            'picture' => $image->hashName()
        ]);
    }

    public function test_user_can_edit_profile_only_names()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->post('/editarperfil/save', [
            'firstname' => 'Test',
            'lastname' => 'User'
        ]);

        $this->assertDatabaseHas('users', [
            'firstname' => 'Test',
            'lastname' => 'User'
        ]);
    }

/*     public function test_user_can_edit_profile_only_description()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->post('/editarperfil/save', [
            'description' => 'Lorem ipsum dolor sit amet, consectetur.',
        ]);

        $this->assertDatabaseHas('users', [
            'description' => 'Lorem ipsum dolor sit amet, consectetur.',
        ]);
    } */

}