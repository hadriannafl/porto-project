<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['ERP System', 'UM Admin Dashboard'] as $title) {
            $project = DB::table('projects')->where('title', $title)->first();
            if (! $project) continue;

            $tags = array_values(array_filter(
                json_decode($project->tags, true),
                fn($t) => $t !== 'jQuery'
            ));

            DB::table('projects')->where('title', $title)->update([
                'tags' => json_encode($tags),
            ]);
        }
    }

    public function down(): void {}
};
