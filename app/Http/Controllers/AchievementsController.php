<?php

namespace App\Http\Controllers;

use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Comment;
use App\Models\CommentAchievement;
use App\Models\LessonAchievement;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{

    public function index(User $user, Request $request)
    {
    
        $user = User::whereId($request->route('id'))->first();
        //Use either user 2 or 3 for better result / testing
       
        /**
         *  These functions unlocks achievements (for comments and lessons) and badges respectively.
         * These functions can be placed anywhere in the application. Preferably after a lesson is watched or comment
         * is made by a user
         */
       // $this->unlockLessonAchievements($user);
       // $this->unlockCommentAchievements($user);
       // $this->unlockBadges($user);

        
       $this->unlockCommentAchievements($user);
       $this->unlockLessonAchievements($user);
       $this->unlockBadges($user);
     
       

       //1. Unlocked achievements
       $unlocked_achievements = Achievement::whereUserId($user->id)->get()->pluck('achievement')->toArray();
        
        
        

        //2. Next available achievements
        $next_lesson_achievement = $this->getLessonNextAchievement($user);
        $next_comment_achievement = $this->getCommentNextAchievement($user);


        $next_available_achievements = [
            'next_lesson_achievement' => $next_lesson_achievement,
            'next_comment_achievement' => $next_comment_achievement,
        ];

        //3. current badge
        $current_badge =  $this->getUserCurrentBadge($user);
        
        
        //4. Next badge
        $next_badge = $this->getUserNextBadge($current_badge);

        //5. Achievements remaining to unlock next badge
        $remaining_to_unlock_next_badge = $this->unlockNextBadge($user,$next_badge);

       return response()->json([
            'unlocked_achievements' => $unlocked_achievements,
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $current_badge,
            'next_badge' => $next_badge,
            'remaing_to_unlock_next_badge' => $remaining_to_unlock_next_badge
        ]);
        
    }



    /**
     * Triggers an event to unlock lesson-watched achievements
     *
     * @param User $user
     * @return void
     */
    public function unlockLessonAchievements(User $user)
    {
        $lessons_watched_by_users = $user->watched()->count();
        switch ($lessons_watched_by_users) {
            case 1:
                event(new LessonWatched('First Lesson Watched', $user));
                break;
            case 5:
                event(new LessonWatched('5 Lessons Watched', $user));
                break;
            case 10:
                event(new LessonWatched('10 Lessons Watched', $user));
                break;
            case 25:
                event(new LessonWatched('25 Lessons Watched', $user));
                break;
            case 50:
                event(new LessonWatched('50 Lessons Watched', $user));
                break;
            default:
                return;
                break;
        }
    }
    
    /**
     * Triggers events to unlock new achievement levels
     *
     * @param User $user
     * @return void
     */
    public function unlockCommentAchievements(User $user)
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
                return;
                break;
        }
   
    }

    /**
     * Unlocks new badges for users based on achievements
     *
     * @param User $user
     * @return void
     */
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
            return;
                break;
        }
    }

    /**
     * Returns next achievement for lessons (for the user)
     *
     * @param User $user
     * @return string
     */ 
    public function getLessonNextAchievement(User $user) : string
    {
        $latest_lesson_achievement = Achievement::whereUserId($user->id)->whereSource('lesson')->orderBy('id','desc')->first(['achievement']);    
        if ($latest_lesson_achievement) {
            $current_lesson_achievement = LessonAchievement::whereName($latest_lesson_achievement->achievement)->first(['id']);
            $next_lesson_achievement = LessonAchievement::where('id', '>', $current_lesson_achievement->id)->first(['name'])->name;
            return $next_lesson_achievement;
        }

        return '';
    }

    /**
     * Gets next achievement level for comments (for the user)
     *
     * @param User $user
     * @return string
     */
    public function getCommentNextAchievement(User $user) : string
    {
        $latest_comment_achievement = Achievement::whereUserId($user->id)->whereSource('comment')->orderBy('id','desc')->first(['achievement']);
        if ($latest_comment_achievement) {
            $current_comment_achievement = CommentAchievement::whereName($latest_comment_achievement->achievement)->first(['id']);
            $next_comment_achievement = CommentAchievement::where('id', '>', $current_comment_achievement->id)->first(['name'])->name;
            return $next_comment_achievement;
        }

        return '';
    }
    

    /**
     * Gets the user's current badge
     *
     * @param User $user
     * @return string
     */
    public function getUserCurrentBadge(User $user) : string
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
                return '';
                break;
        }
    }

    /**
     * Returns the user's next available badge
     *
     * @param string $current_badge
     * @return string
     */
    public function getUserNextBadge($current_badge) : string
    {
        
       $current_badge = Badge::whereName($current_badge)->first(['id']);
       
       $next_badge = Badge::where('id','>',$current_badge->id)->first()->name;

       return $next_badge;

    }

    /**
     * Returns achievements remaining to unlock next badge
     *
     * @param User $user
     * @param string $next_badge
     * @return void
     */
    public function unlockNextBadge(User $user, $next_badge) : int
    {
        $achievements = Achievement::whereUserId($user->id)->count();
        $next_badge_count = Badge::whereName($next_badge)->first('achievements_count')->achievements_count;
        
        return $next_badge_count - $achievements;
    }

    
    
}
