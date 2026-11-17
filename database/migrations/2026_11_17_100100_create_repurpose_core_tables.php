<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category')->nullable();
            $table->boolean('enabled')->default(true);
            $table->boolean('is_core')->default(false);
            $table->unsignedInteger('hours_saved_weekly')->default(0);
            $table->timestamps();
        });

        Schema::create('brand_voices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tone')->nullable();
            $table->string('audience')->nullable();
            $table->string('cta_style')->nullable();
            $table->json('banned_phrases')->nullable();
            $table->json('preferred_phrases')->nullable();
            $table->text('sample_paragraph')->nullable();
            $table->string('locale', 12)->default('en');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('content_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('brand_voice_id')->nullable()->constrained('brand_voices')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('source_type')->default('blog');
            $table->string('status')->default('ingested');
            $table->string('source_url')->nullable();
            $table->longText('original_body')->nullable();
            $table->longText('cleaned_transcript')->nullable();
            $table->text('summary')->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->unsignedInteger('word_count')->default(0);
            $table->string('language', 12)->default('en');
            $table->json('tags')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('ingested_at')->nullable();
            $table->timestamps();
        });

        Schema::create('channel_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_source_id')->constrained('content_sources')->cascadeOnDelete();
            $table->foreignId('brand_voice_id')->nullable()->constrained('brand_voices')->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('channel');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body')->nullable();
            $table->text('hook')->nullable();
            $table->string('cta')->nullable();
            $table->json('hashtags')->nullable();
            $table->string('status')->default('draft');
            $table->decimal('ai_score', 5, 2)->nullable();
            $table->unsignedInteger('word_count')->default(0);
            $table->timestamp('scheduled_for')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('calendar_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_source_id')->nullable()->constrained('content_sources')->nullOnDelete();
            $table->foreignId('channel_draft_id')->nullable()->constrained('channel_drafts')->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('channel');
            $table->string('status')->default('scheduled');
            $table->timestamp('scheduled_at');
            $table->string('timezone')->default('UTC');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('seo_packs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_source_id')->nullable()->constrained('content_sources')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('primary_keyword');
            $table->json('secondary_keywords')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->json('outline')->nullable();
            $table->json('internal_links')->nullable();
            $table->string('search_intent')->nullable();
            $table->unsignedTinyInteger('difficulty_score')->default(50);
            $table->string('status')->default('ready');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_packs');
        Schema::dropIfExists('calendar_items');
        Schema::dropIfExists('channel_drafts');
        Schema::dropIfExists('content_sources');
        Schema::dropIfExists('brand_voices');
        Schema::dropIfExists('module_settings');
    }
};