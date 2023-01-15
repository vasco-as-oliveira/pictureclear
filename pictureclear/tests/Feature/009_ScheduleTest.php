<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Course;
use App\Models\Tier;
use App\Models\User;
use App\Models\Sale;
use App\Models\Schedule;


class ScheduleTest extends TestCase
{
    public function test_Buy_screen_can_be_rendered()
    {
        $seller = User::factory()->create();


        $this->post('/login', [
            'email' => $seller->email,
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
            'chooseTier1' => true,
            'price1' => 14.50,
        ]);

        $courseId = Course::where([
            'title' => 'Lorem ipsum dolor',
            'language' => 'Lorem',
            'description' => 'Lorem ipsum dolor sit amet, consectetur',
            'owner_id' => $seller->id
        ])->value('id');

        $this->assertDatabaseHas('courses', [
            'title' => 'Lorem ipsum dolor',
            'language' => 'Lorem',
            'description' => 'Lorem ipsum dolor sit amet, consectetur',
            'owner_id' => $seller->id
        ]);

        $this->assertDatabaseHas('tiers', [
            //'course_id' => $courseId,
            'price'=> 14.5,
            'hasscheduleperk' => false,
            'haschatperk' => false
        ]);

        $tierId = Tier::where([
            'course_id' => $courseId,
        ])->value('id');

        $buyer = User::factory()->create();

        $this->post('/login', [
            'email' => $buyer->email,
            'password' => 'password',
        ]);
        $this->assertAuthenticated();
        
        //pagamento com saldo
        $sale = Sale::factory()->create([
            'user_id' => $buyer->id,
            'tier_id' => $tierId,
        ]);
        
        $scheduleId = Schedule::where([
            'user_id' => $seller->id,
            'course_id' => $courseId,
        ])->value('id');

        $response = $this->post('/addHour/'.$courseId, [
            'schedDia' => '01/02/2023',
            'schedHoraInicial' => '12:43:00',
            'schedHoraFinal' => '12:45:00',
        ]);

        $this->assertDatabaseHas('schedule_slots', [
            'schedule_id'=> $scheduleId,
        ]);
    }
}
