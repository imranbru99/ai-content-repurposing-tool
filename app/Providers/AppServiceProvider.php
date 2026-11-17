<?php

namespace App\Providers;

use App\Models\ChannelDraft;
use App\Models\ContentSource;
use App\Policies\ChannelDraftPolicy;
use App\Policies\ContentSourcePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(ContentSource::class, ContentSourcePolicy::class);
        Gate::policy(ChannelDraft::class, ChannelDraftPolicy::class);
    }
}
