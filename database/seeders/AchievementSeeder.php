<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $achievement = new Achievement();
        $achievement->user_id = 2;
        $achievement->achievement = 'First Lesson Watched';
        $achievement->source = 'lesson';
        $achievement->save();

        $achievement = new Achievement();
        $achievement->user_id = 3;
        $achievement->achievement = 'First Comment Written';
        $achievement->source = 'comment';
        $achievement->save();

        $achievement = new Achievement();
        $achievement->user_id = 3;
        $achievement->achievement = '3 Comments Written';
        $achievement->source = 'comment';
        $achievement->save();

        $achievement = new Achievement();
        $achievement->user_id = 2;
        $achievement->achievement = '5 Lessons Watched';
        $achievement->source = 'lesson';
        $achievement->save();

        $achievement = new Achievement();
        $achievement->user_id = 2;
        $achievement->achievement = 'First Comment Written';
        $achievement->source = 'comment';
        $achievement->save();

        $achievement = new Achievement();
        $achievement->user_id = 2;
        $achievement->achievement = '10 Lessons Watched';
        $achievement->source = 'lesson';
        $achievement->save();

        $achievement = new Achievement();
        $achievement->user_id = 3;
        $achievement->achievement = 'First Lesson Watched';
        $achievement->source = 'lesson';
        $achievement->save();
    }
}
