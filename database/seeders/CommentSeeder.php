<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $timeMin = strtotime('1990-10-10');
        $timeMax = strtotime('2020-10-10');
        $i = 0;
        while ($i < 100) {
            if ($timeMax === $timeMin) {
                break;
            }
            $i++;
            $date = $faker->dateTimeBetween(date('Y-m-d H:i:s', $timeMin), date('Y-m-d H:i:s', $timeMax));
            $timeMin = $date->getTimestamp();
            $generatedComment = Comment::create([
                'description' => $faker->text,
                'status' => $faker->randomElement([Comment::APPROVED_STATUS, Comment::DECLINED_STATUS]),
                'status_int' => 1,
                'author_id' => User::get()->random()->id,
                'phone_id' => Phone::get()->random()->id,
                'created_at' => $date->format('Y-m-d H:i:s'),
                'updated_at' => $date->format('Y-m-d H:i:s'),
            ]);

            $lastComment = Comment::where('author_id', $generatedComment->author_id)
                ->where('id', '!=', $generatedComment->id)
                ->where('phone_id', $generatedComment->phone_id)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$lastComment) {
                $generatedComment->status_int = $generatedComment->status === Comment::APPROVED_STATUS ? 1 : -1;
                $generatedComment->save();
                continue;
            }

            $statusInt = 0;
            if ($generatedComment->status !== $lastComment->status) {
                $statusInt = $generatedComment->status === Comment::APPROVED_STATUS ? 2 : -2;
            }

            if (0 === $statusInt) {
                $generatedComment->status = Comment::NEUTRAL_STATUS;
            }

            $generatedComment->status_int = $statusInt;
            $generatedComment->save();
        }
    }
}
