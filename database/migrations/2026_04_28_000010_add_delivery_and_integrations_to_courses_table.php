<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'delivery_mode')) {
                $table->string('delivery_mode', 40)->default('custom')->after('duration');
            }

            if (! Schema::hasColumn('courses', 'next_session_at')) {
                $table->timestamp('next_session_at')->nullable()->after('delivery_mode');
            }

            if (! Schema::hasColumn('courses', 'session_timezone')) {
                $table->string('session_timezone', 80)->nullable()->after('next_session_at');
            }

            if (! Schema::hasColumn('courses', 'session_length_minutes')) {
                $table->unsignedSmallInteger('session_length_minutes')->nullable()->after('session_timezone');
            }

            if (! Schema::hasColumn('courses', 'meeting_provider')) {
                $table->string('meeting_provider', 40)->nullable()->after('session_length_minutes');
            }

            if (! Schema::hasColumn('courses', 'registration_url')) {
                $table->string('registration_url')->nullable()->after('meeting_provider');
            }

            if (! Schema::hasColumn('courses', 'integrations')) {
                $table->json('integrations')->nullable()->after('registration_url');
            }
        });
    }

    public function down(): void
    {
        $columns = collect([
            'delivery_mode',
            'next_session_at',
            'session_timezone',
            'session_length_minutes',
            'meeting_provider',
            'registration_url',
            'integrations',
        ])->filter(fn (string $column) => Schema::hasColumn('courses', $column))->values()->all();

        if ($columns !== []) {
            Schema::table('courses', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};