<?php

namespace Tests\Feature;

use App\Models\Badge;
use App\Models\Comment;
use App\Models\Lesson;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\BadgeTableSeeder;
use Database\Seeders\CommentAchievementSeeder;
use Database\Seeders\LessonAchievementSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertCount;

class ExampleTest extends TestCase
{
    use RefreshDatabase;



    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIfUserAchievementDetailsCanBeOptained()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(); //creates a fresh user
    
        Comment::factory(3)->create(); // creates comments for the user       
        
        //seed the comment achievements
        $this->seed(CommentAchievementSeeder::class);
        
        //Lessons
        $lessons = Lesson::factory(10)->create();

        //Attach lessons to users
        $user->lessons()->attach($lessons->random(rand(5, 5))->pluck('id')->toArray(),[
            'watched' => 1
        ]);
        
        //Seed lesson achievements
        $this->seed(LessonAchievementSeeder::class);
        
        //Seed Badges
        $this->seed(BadgeTableSeeder::class);

         
        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
    }

    
    public function test_comments_created()
    {
        User::factory()->create();
        
        $comments = Comment::factory(3)->create();
        
        assertCount(3,$comments);
    }
}
