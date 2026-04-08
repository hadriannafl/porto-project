<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Migrate existing image data from projects.image JSON column
        DB::table('projects')->get()->each(function ($project) {
            $images = json_decode($project->image, true) ?? [];
            foreach ($images as $i => $path) {
                if ($path) {
                    DB::table('project_images')->insert([
                        'project_id' => $project->id,
                        'path'       => $path,
                        'sort_order' => $i,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('image')->nullable();
        });

        DB::table('project_images')->get()->each(function ($img) {
            $current = json_decode(
                DB::table('projects')->where('id', $img->project_id)->value('image') ?? '[]',
                true
            ) ?? [];
            $current[] = $img->path;
            DB::table('projects')->where('id', $img->project_id)
                ->update(['image' => json_encode($current)]);
        });

        Schema::dropIfExists('project_images');
    }
};
