<?php

namespace App\Events;

use App\Models\User;
use App\Models\Lesson;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class LessonWatched
{
    use Dispatchable, SerializesModels;

    public $achievement_name;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($achievement_name, $user)
    {   
        $this->achievement_name = $achievement_name;
        $this->user = $user;

    }
}
