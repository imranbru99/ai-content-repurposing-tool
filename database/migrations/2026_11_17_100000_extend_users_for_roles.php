<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('staff')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('job_title')->nullable()->after('phone');
            $table->string('organization_name')->nullable()->after('job_title');
            $table->boolean('is_demo')->default(false)->after('organization_name');
            $table->boolean('is_active')->default(true)->after('is_demo');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'job_title', 'organization_name', 'is_demo', 'is_active']);
        });
    }
};
