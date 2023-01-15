<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;


class AdminTest extends TestCase
{

    public function test_admin_courses_screen_can_be_rendered()
    {
        $user = User::factory()->create([
                'is_admin' => true
            ]);
 
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
 
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => true
        ]);

        $response = $this->get('/painelAdmin/courses');

        $response->assertStatus(200);
    }

    public function test_admin_users_screen_can_be_rendered()
    {
        $user = User::factory()->create([
                'is_admin' => true
            ]);
 
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
 
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_admin' => true
        ]);

        $response = $this->get('/painelAdmin/users');

        $response->assertStatus(200);
    }

    public function test_admin_courses_screen_cant_be_rendered_if_user_isnt_admin()
    {
        $user = User::factory()->create([
            "is_admin" => false
        ]);


        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response = $this->get('/painelAdmin/courses');

        $response->assertRedirect();
    }

    public function test_admin_users_screen_cant_be_rendered_if_user_isnt_admin()
    {
        $user = User::factory()->create([
            "is_admin" => false
        ]);


        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        $response = $this->get('/painelAdmin/users');

        $response->assertRedirect();
    }

    public function test_admin_users_can_delete_user()
    {
        $admin = User::factory()->create([
            "is_admin" => true
        ]);

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        $response = $this->post('/admin/deleteUser', [
            'user' => $user->id,
        ]);
        
        $this->assertDatabaseMissing('users', $user->toArray());
    }

    public function test_not_admin_users_cant_delete_user()
    {
        $admin = User::factory()->create([
            "is_admin" => false
        ]);

        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        $response = $this->post('/admin/deleteUser', [
            'user' => $user->id,
        ]);
        
        $this->assertDatabaseHas('users', $user->toArray());
    }

    public function test_admin_users_can_delete_course()
    {
        $admin = User::factory()->create([
            "is_admin" => true
        ]);

        $course = Course::factory()->create();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        $response = $this->post('/admin/apagarCurso', [
            'course' => $course->id,
        ]);
        
        $this->assertDatabaseMissing('courses', $course->toArray());
    }

    public function test__not_admin_users_cant_delete_course()
    {
        $admin = User::factory()->create([
            "is_admin" => false
        ]);

        $course = Course::factory()->create();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);
        $response = $this->post('/admin/apagarCurso', [
            'course' => $course->id,
        ]);
        
        $this->assertDatabaseHas('courses', $course->toArray());
    }
}