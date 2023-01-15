<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class SetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_aboutyou_screen_can_be_rendered()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response = $this->get('/aboutyou');
        $response->assertStatus(200);
    }

    public function test_user_can_add_description()
    {
        $user = User::factory()->create(
           [ 'finished_setup' => false]
        );
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->post('/aboutyou/save', [
            'description' => 'Lorem ipsum dolor sit amet, consectetur.',
        ]);

        $this->assertDatabaseHas('users', [
            'description' => 'Lorem ipsum dolor sit amet, consectetur.',
        ]);
        $response->assertRedirect('home');
    }

    public function test_user_can_add_profile_picture()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $file = 'test-image.png';

        $response = $this->post('/aboutyou/save', [
            'inputImage' =>  $image = UploadedFile::fake()->image($file),
        ]);

        $this->assertDatabaseHas('users', [
            'picture' => $image->hashName(),
        ]);
        $response->assertRedirect('home');
    }

    public function test_user_cant_add_description_over_limit()
    {
        $user = User::factory()->create(
           [ 'finished_setup' => false]
        );
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $response = $this->post('/aboutyou/save', [
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Quisque non finibus ligula. Sed cursus velit sed tellus vehicula, malesuada semper ex ultrices.',
        ]);

        $this->assertDatabaseMissing('users', [
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Quisque non finibus ligula. Sed cursus velit sed tellus vehicula, malesuada semper ex ultrices.',
        ]);
    }

    public function test_user_cant_add_profile_picture_with_invalid_format()
    {
        $user = User::factory()->create();
 
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();

        $file = 'test-image.mp4';

        $response = $this->post('/aboutyou/save', [
            'inputImage' =>  $image = UploadedFile::fake()->image($file),
        ]);

        $this->assertDatabaseMissing('users', [
            'picture' => $image->hashName(),
        ]);
    }
}
