<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 20) as $index) {
            $article = Article::create([
                'title' => fake()->sentence,
                'content' => fake()->text(200),
                'published_at' => fake()->dateTimeThisYear->format('Y-m-d H:i:s'),
            ]);
            $tags = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id'); // случайное количество тегов от 1 до 3
            $article->tags()->attach($tags);
        }
    }
}
