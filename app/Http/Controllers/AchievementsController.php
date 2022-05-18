<?php

namespace App\Http\Controllers;

use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\CommentAchievement;
use App\Models\LessonAchievement;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{

    public function index(User $user)
    {
        $user = User::whereId(2)->first();

        //$this->unlockAchievements($user);
        $this->unlockBadges($user);

        $unlocked_achievements = Achievement::whereUserId($user->id)->get()->pluck('achievement')->toArray();

        
        


        $next_lesson_achievement = $this->getLessonNextAchievement($user);
        $next_comment_achievement = $this->getCommentNextAchievement($user);

        $next_available_achievements = [
            'next_lesson_watched_achievement' => $next_lesson_achievement,
            'next_comment_achievement' => $next_comment_achievement,
        ];

        //current badge
        $current_badge =  $this->getUserCurrentBadge($user);
        
        $next_badge = $this->getUserNextBadge($current_badge);

        $remaining_to_unlock_next_badge = $this->unlockNextBadge($user,$next_badge);

        return response()->json([
            'unlocked_achievements' => $unlocked_achievements,
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $current_badge,
            'next_badge' => $next_badge,
            'remaing_to_unlock_next_badge' => $remaining_to_unlock_next_badge
        ]);
    }

    public function unlockBadges(User $user)
    {
        $achievements = Achievement::whereUserId($user->id)->count();
        
        switch ($achievements) {
            //Every users badge is "Beginner" by default
            case 2:
                event(new BadgeUnlocked('Intermediate', $user));
                break;
            case 8:
                event(new BadgeUnlocked('Advanced', $user));
                break;
            case 10:
                event(new BadgeUnlocked('Master', $user));
                break;
            default:
                
                break;
        }
    }

    public function unlockNextBadge(User $user, $next_badge){
        $achievements = Achievement::whereUserId($user->id)->count();
        $next_badge_count = Badge::whereName($next_badge)->first('achievements_count')->achievements_count;
        
        return $achievements_to_unlock_next_badge = $next_badge_count - $achievements;
    }

    public function getUserNextBadge($current_badge)
    {
       $current_badge = Badge::whereName($current_badge)->first(['id']);
       $next_badge = Badge::where('id','>',$current_badge->id)->first()->name;

       return $next_badge;

    }

    public function getCommentNextAchievement(User $user)
    {
        $latest_comment_achievement = Achievement::whereUserId($user->id)->whereSource('comment')->latest()->first(['achievement']);
        if ($latest_comment_achievement) {
            $current_comment_achievement = CommentAchievement::whereName($latest_comment_achievement->achievement)->first(['id']);
            $next_comment_achievement = CommentAchievement::where('id', '>', $current_comment_achievement->id)->first(['name'])->name;
            return $next_comment_achievement;
        }

        return '';
    }

    public function getLessonNextAchievement(User $user)
    {
        $latest_lesson_achievement = Achievement::whereUserId($user->id)->whereSource('lesson')->latest()->first(['achievement']);
        if ($latest_lesson_achievement) {
            $current_lesson_achievement = LessonAchievement::whereName($latest_lesson_achievement->achievement)->first(['id']);
            $next_lesson_achievement = LessonAchievement::where('id', '>', $current_lesson_achievement->id)->first(['name'])->name;
            return $next_lesson_achievement;
        }

        return '';
    }


    public function unlockAchievements(User $user)
    {
        

        $comments_by_user = $user->comments()->count();

        switch ($comments_by_user) {
            case 1:
                event(new CommentWritten('First Comment Written', $user));
                break;
            case 3:
                event(new CommentWritten('3 Comments Written', $user));
                break;
            case 5:
                event(new CommentWritten('5 Comments Written', $user));
                break;
            case 10:
                event(new CommentWritten('10 Comments Written', $user));
                break;
            case 20:
                event(new CommentWritten('20 Comments Watched', $user));
                break;
            default:
                # code...
                break;
        }


        $lessons_watched_by_users = $user->watched()->count();
        switch ($lessons_watched_by_users) {
            case 1:
                event(new LessonWatched('First Lesson Watched', $user));
                break;
            case 3:
                event(new LessonWatched('5 Lessons Watched', $user));
                break;
            case 5:
                event(new LessonWatched('10 Lessons Watched', $user));
                break;
            case 10:
                event(new LessonWatched('25 Lessons Watched', $user));
                break;
            case 20:
                event(new LessonWatched('50 Lessons Watched', $user));
                break;
            default:
                # code...
                break;
        }
    }

    public function getUserCurrentBadge(User $user)
    {
        $achievements = Achievement::whereUserId($user->id)->count();
        switch ($achievements) {
            case $achievements >= 0 && $achievements <= 3:
                return 'Beginner';
                break;
            case $achievements >= 4 && $achievements <= 7:
                return 'Intermediate';
                break;

            case $achievements >= 8 && $achievements < 9:
                return 'Advanced';
                break;

            case $achievements >= 10:
                return 'Master';
                break;

            default:
                return;
                break;
        }
    }


    
}
