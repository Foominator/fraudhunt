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
        $i = 0;
        while ($i < 100) {
            $i++;
            $generatedComment = Comment::create([
                'description' => $faker->text,
                'status' => $faker->randomElement([Comment::APPROVED_STATUS, Comment::DECLINED_STATUS]),
                'author_id' => User::get()->random()->id,
                'phone_id' => Phone::get()->random()->id,
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s')
            ]);

            $lastComment = Comment::where('author_id', $generatedComment->author_id)
                ->where('phone_id', $generatedComment->phone_id)
                ->orderBy('created_at', 'desc')
                ->first();

            Comment::where('author_id', $generatedComment->author_id)
                ->where('phone_id', $generatedComment->phone_id)
                ->where('id', '!=', $lastComment->id)
                ->update(['status' => Comment::NEUTRAL_STATUS]);
        }
    }
}
