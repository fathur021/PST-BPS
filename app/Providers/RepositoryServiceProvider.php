<?php

namespace App\Providers;

use App\Repositories\FeedbackRepository;
use App\Repositories\GuestbookRepository;
use App\Repositories\Interface\FeedbackRepositoryInterface;
use App\Repositories\Interface\GuestbookRepositoryInterface;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GuestbookRepositoryInterface::class, GuestbookRepository::class);
        $this->app->bind(FeedbackRepositoryInterface::class, FeedbackRepository::class);
    }

    public function boot()
    {
        //
    }
}
