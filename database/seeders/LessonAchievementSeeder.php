<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LessonAchievement;

class LessonAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $Lesson_achievement1 = new LessonAchievement();
        $Lesson_achievement1->name = 'First Lesson Watched';
        $Lesson_achievement1->save();

        $lesson_achievement1 = new LessonAchievement();
        $lesson_achievement1->name = '5 Lessons Watched';
        $lesson_achievement1->save();

        $lesson_achievement1 = new LessonAchievement();
        $lesson_achievement1->name = '10 Lessons Watched';
        $lesson_achievement1->save();

        $lesson_achievement1 = new LessonAchievement();
        $lesson_achievement1->name = '25 Lessons Watched';
        $lesson_achievement1->save();

        $lesson_achievement1 = new LessonAchievement();
        $lesson_achievement1->name = '50 Lessons Written';
        $lesson_achievement1->save();
    }
}
