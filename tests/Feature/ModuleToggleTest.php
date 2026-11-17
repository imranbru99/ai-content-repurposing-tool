<?php

namespace Tests\Feature;

use App\Models\ModuleSetting;
use App\Services\ModuleManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModuleToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_module_manager_respects_database_override(): void
    {
        $this->seed();

        $manager = app(ModuleManager::class);
        $this->assertTrue($manager->enabled('patient_onboarding'));

        ModuleSetting::query()->where('key', 'patient_onboarding')->update(['enabled' => false]);
        cache()->forget('module_settings_map');

        $this->assertFalse(app(ModuleManager::class)->enabled('patient_onboarding'));
    }
}
