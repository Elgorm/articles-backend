<?php
// app/Jobs/ProcessComment.php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessComment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $commentData;

    public function __construct(array $commentData)
    {
        $this->commentData = $commentData;
    }

    public function handle()
    {
        // Симулируем длительную работу с помощью sleep(600)
        sleep(600); // Это задержка в 10 минут для тестирования

        $comment = new Comment();
        $comment->article_id = $this->commentData['article_id'];
        $comment->subject = $this->commentData['subject'];
        $comment->body = $this->commentData['body'];
        $comment->save();

        Log::info('Комментарий был обработан и сохранён в базе данных.');
    }
}
