<?php

namespace Tests\Feature;

use App\Services\ModuleManager;
use Tests\TestCase;

class ModuleManagerTest extends TestCase
{
    public function test_modules_config_is_loaded(): void
    {
        $modules = app(ModuleManager::class)->all();

        $this->assertTrue($modules->contains(fn (array $m) => ($m['key'] ?? null) === 'source_ingest'));
        $this->assertTrue($modules->contains(fn (array $m) => ($m['key'] ?? null) === 'brand_voice'));
    }

    public function test_home_page_renders(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('RepurposeAI', false);
    }
}
