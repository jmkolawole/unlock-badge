<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\CommentAchievement;
use App\Models\Lesson;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /* $lessons = Lesson::factory()
            ->count(20)
            ->create(); *//* 

        Lesson::factory()->count(20)->create();

        // Populate users
        User::factory()->count(5)->create();

        //Create comments
        Comment::factory()->count(50)->create();

        // Get all the roles attaching up to 3 random roles to each user
        $lessons = Lesson::all();

        // Populate the pivot table
        User::all()->each(function ($user) use ($lessons) {

            $user->lessons()->attach(
                $lessons->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        //Seed all achievements
        $this->call(CommentAchievementSeeder::class);
        $this->call(LessonAchievementSeeder::class);
 */

       // $this->call(BadgeTableSeeder::class);
       $this->call(AchievementSeeder::class);
          
    }
}
