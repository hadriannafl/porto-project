<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Migrate existing string image values to json arrays
        DB::table('projects')->get()->each(function ($project) {
            $current = $project->image;
            if ($current && !str_starts_with($current, '[')) {
                DB::table('projects')
                    ->where('id', $project->id)
                    ->update(['image' => json_encode([$current])]);
            } elseif (!$current) {
                DB::table('projects')
                    ->where('id', $project->id)
                    ->update(['image' => json_encode([])]);
            }
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->json('image')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });
    }
};
