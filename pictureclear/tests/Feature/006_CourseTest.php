<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Tier;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_creation_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        $response = $this->get('/course');

        $response->assertStatus(200);
    }

    public function test_tier_creation_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        $course = [
            'title' => 'Lorem ipsum dolor',
            'language' => 'Lorem',
            'description' => 'Lorem ipsum dolor sit amet, consectetur',
            'certificate' => false
        ];
        $response = $this->post('/course/create', $course);

        $response->assertSessionHas(['course' => array_merge($course, ['id' => true])]);
        
        $response = $this->get('/course/tier');

        $response->assertStatus(200);
    }

    public function test_user_can_create_course()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        $course = [
            'title' => 'Lorem ipsum dolor',
            'language' => 'Lorem',
            'description' => 'Lorem ipsum dolor sit amet, consectetur',
            'certificate' => false
        ];
        $response = $this->post('/course/create', $course);

        $response->assertSessionHas(['course' => array_merge($course, ['id' => true])]);

        $this->assertDatabaseMissing('courses', [
            'title' => 'Lorem ipsum dolor',
            'language' => 'Lorem',
            'description' => 'Lorem ipsum dolor sit amet, consectetur',
            'has_certificate' => false
        ]);
 
        $response = $this->post('/course/tiers/create', [
            'radio' =>
        ])

        $courseId = Course::where([
            'title' => 'Lorem ipsum dolor',
            'language' => 'Lorem',
            'description' => 'Lorem ipsum dolor sit amet, consectetur',
            'owner_id' => $user->id
        ])->value('id');

        $this->assertDatabaseHas('courses', [
            'title' => 'Lorem ipsum dolor',
            'language' => 'Lorem',
            'description' => 'Lorem ipsum dolor sit amet, consectetur',
            'owner_id' => $user->id
        ]);

        $this->assertDatabaseHas('tiers', [
            //'course_id' => $courseId,
            'price'=> 15,
            'hasscheduleperk' => false,
            'haschatperk' => false
        ]);
    } 

    public function test_lesson_creation_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        $course = Course::factory()->create([
            'owner_id' => $user->id,
        ]);

        $tier = tier::factory()->create([
            'course_id' => $course->id,
        ]);

        $response = $this->get('/addLesson/'. $course->id);
        $response->assertStatus(200);
    }

    public function test_user_can_see_others_public_course()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        $course = Course::factory()->create();

        $response = $this->get('/checkCourse/search?selectCourse='.$course->id);

        $response->assertStatus(200);
        $response->assertSee($course->name);
        $response->assertSee($course->description);
        $this->assertTrue($course->public);
        $this->assertFalse($user->id==$course->owner_id);
    }

    public function test_user_cant_see_others_private_course()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        $course = Course::factory()->create([
            'public' => false
        ]);

        $response = $this->get('/checkCourse/search?selectCourse='.$course->id);

        $response->assertDontSee($course->name);
        $response->assertDontSee($course->description);
        $this->assertFalse($course->public);
        $this->assertFalse($user->id==$course->owner_id);
    }
}
