<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $badge1 = new Badge();
        $badge1->name = 'Beginner';
        $badge1->achievements_count = 0;
        $badge1->save();

        $badge1 = new Badge();
        $badge1->name = 'Intermediate';
        $badge1->achievements_count = 4;
        $badge1->save();

        $badge1 = new Badge();
        $badge1->name = 'Advanced';
        $badge1->achievements_count = 8;
        $badge1->save();

        $badge1 = new Badge();
        $badge1->name = 'Master';
        $badge1->achievements_count = 10;
        $badge1->save();

    }
}
