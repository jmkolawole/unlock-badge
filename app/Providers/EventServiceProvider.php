<?php

namespace App\Providers;

use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Listeners\CommentAchievementListener;
use App\Listeners\LessonAchievementListener;
use App\Listeners\BadgeUnlockedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            //
            CommentAchievementListener::class
        ],

        LessonWatched::class => [
            //
            LessonAchievementListener::class
        ],

        BadgeUnlocked::class => [
            //
            BadgeUnlockedListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
