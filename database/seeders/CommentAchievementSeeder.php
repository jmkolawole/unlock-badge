<?php

namespace Database\Seeders;

use App\Models\CommentAchievement;
use Illuminate\Database\Seeder;

class CommentAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $comment_achievement1 = new CommentAchievement();
        $comment_achievement1->name = 'First Comment Written';
        $comment_achievement1->save();

        $comment_achievement1 = new CommentAchievement();
        $comment_achievement1->name = '3 Comments Written';
        $comment_achievement1->save();

        $comment_achievement1 = new CommentAchievement();
        $comment_achievement1->name = '5 Comments Written';
        $comment_achievement1->save();

        $comment_achievement1 = new CommentAchievement();
        $comment_achievement1->name = '10 Comments Written';
        $comment_achievement1->save();

        $comment_achievement1 = new CommentAchievement();
        $comment_achievement1->name = '20 Comments Written';
        $comment_achievement1->save();
    }
}
