<?php

namespace Tests\Feature;

use App\Models\ContentSource;
use App\Models\User;
use App\Services\ModuleManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentRepurposeTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_seed_creates_sources_and_demo_user(): void
    {
        $this->seed();

        $this->assertDatabaseHas('users', ['email' => 'demo@repurposeai.test']);
        $this->assertTrue(ContentSource::query()->exists());
        $this->assertTrue(app(ModuleManager::class)->enabled('source_ingest'));
    }

    public function test_marketing_home_renders(): void
    {
        $response = $this->get('/');
        $response->assertOk();
    }

    public function test_modules_page_renders(): void
    {
        $this->seed();
        $this->get('/modules')->assertOk();
    }
}
