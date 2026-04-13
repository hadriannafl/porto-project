<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(
            Project::with('projectImages')
                ->orderBy('order')
                ->orderByDesc('created_at')
                ->get()
        );
    }

    public function store(Request $request)
    {
        if (! session('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $data = $request->validate([
                'title'      => 'required|string|max:255',
                'desc'       => 'required|string',
                'images'     => 'nullable',
                'tags'       => 'required|string',
                'year'       => 'required|string|size:4',
                'category'   => 'required|in:Frontend,Backend,Full Stack,Mobile,Other',
                'demo_url'   => 'nullable|url',
                'github_url' => 'nullable|url',
            ]);

            $bgs = [
                'bg-gradient-to-br from-violet-900 to-purple-900',
                'bg-gradient-to-br from-cyan-900 to-blue-900',
                'bg-gradient-to-br from-pink-900 to-rose-900',
                'bg-gradient-to-br from-amber-900 to-orange-900',
                'bg-gradient-to-br from-emerald-900 to-teal-900',
                'bg-gradient-to-br from-indigo-900 to-violet-900',
            ];

            $project = Project::create([
                'title'      => $data['title'],
                'desc'       => $data['desc'],
                'tags'       => array_map('trim', explode(',', $data['tags'])),
                'year'       => $data['year'],
                'category'   => $data['category'],
                'bg'         => $bgs[Project::count() % count($bgs)],
                'demo_url'   => $data['demo_url'] ?? null,
                'github_url' => $data['github_url'] ?? null,
                'order'      => 0,
            ]);

            $files = $request->file('images') ?? [];
            foreach (array_slice((array) $files, 0, 5) as $i => $file) {
                if (!$file || !$file->isValid()) continue;
                $path = $file->store('projects', 'public');
                if ($path) {
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'path'       => $path,
                        'sort_order' => $i,
                    ]);
                }
            }

            return response()->json($project->fresh(['projectImages']), 201);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Project $project)
    {
        if (! session('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $data = $request->validate([
                'title'          => 'required|string|max:255',
                'desc'           => 'required|string',
                'images'         => 'nullable',
                'removed_images' => 'nullable|string',
                'tags'           => 'required|string',
                'year'           => 'required|string|size:4',
                'category'       => 'required|in:Frontend,Backend,Full Stack,Mobile,Other',
                'demo_url'       => 'nullable|url',
                'github_url'     => 'nullable|url',
            ]);

            if (! empty($data['removed_images'])) {
                $removed = json_decode($data['removed_images'], true) ?? [];
                foreach ($removed as $path) {
                    Storage::disk('public')->delete($path);
                    $project->projectImages()->where('path', $path)->delete();
                }
            }

            $currentCount = $project->projectImages()->count();
            $remaining    = 5 - $currentCount;
            $files = $request->file('images') ?? [];
            foreach (array_slice((array) $files, 0, $remaining) as $i => $file) {
                if (!$file || !$file->isValid()) continue;
                $path = $file->store('projects', 'public');
                if ($path) {
                    ProjectImage::create([
                        'project_id' => $project->id,
                        'path'       => $path,
                        'sort_order' => $currentCount + $i,
                    ]);
                }
            }

            $project->update([
                'title'      => $data['title'],
                'desc'       => $data['desc'],
                'tags'       => array_map('trim', explode(',', $data['tags'])),
                'year'       => $data['year'],
                'category'   => $data['category'],
                'demo_url'   => $data['demo_url'] ?? null,
                'github_url' => $data['github_url'] ?? null,
            ]);

            return response()->json($project->fresh(['projectImages']));
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Project $project)
    {
        if (! session('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            foreach ($project->projectImages as $img) {
                Storage::disk('public')->delete($img->path);
            }

            $project->delete();

            return response()->json(['message' => 'Deleted']);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
