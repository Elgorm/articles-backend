<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class SyncArticleStatsToDatabase extends Command
{
    protected $signature = 'sync:article-stats';
    protected $description = 'Синхронизирует просмотры и лайки с БД';

    public function handle()
    {
        $articles = Article::published()->get();
        foreach ($articles as $article) {
            $article->syncStatsToDatabase();
        }

        $this->info('Статистика у статей синхронизирована.');
    }
}
