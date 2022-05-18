<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Achievement;

class LessonAchievement extends Model
{
    use HasFactory;

    public function achievements()
    {
        return $this->morphMany(Achievement::class, 'achieveable');
    }
}
