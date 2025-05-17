<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Article;
use Carbon\Carbon;

class PublishScheduledArticles extends Command
{
    protected $signature = 'articles:publish-scheduled';
    protected $description = 'Update status draft ke published jika waktu publish telah lewat';

    public function handle()
    {
        $articles = Article::where('status', 'draft')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->get();

        foreach ($articles as $article) {
            $article->update(['status' => 'published']);
            $this->info("Artikel {$article->title} dipublikasikan.");
        }

        return Command::SUCCESS;
    }
}
