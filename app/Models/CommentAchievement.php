<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Achievement;

class CommentAchievement extends Model
{
    use HasFactory;

    public function achievements()
    {
        return $this->morphMany(Achievement::class, 'achieveable');
    }
}
