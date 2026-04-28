<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('services', 'translations')) {
            Schema::table('services', function (Blueprint $table): void {
                $table->json('translations')->nullable()->after('sort_order');
            });
        }

        if (! Schema::hasColumn('courses', 'translations')) {
            Schema::table('courses', function (Blueprint $table): void {
                $table->json('translations')->nullable()->after('sort_order');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('services', 'translations')) {
            Schema::table('services', function (Blueprint $table): void {
                $table->dropColumn('translations');
            });
        }

        if (Schema::hasColumn('courses', 'translations')) {
            Schema::table('courses', function (Blueprint $table): void {
                $table->dropColumn('translations');
            });
        }
    }
};