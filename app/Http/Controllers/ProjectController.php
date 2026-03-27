<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(
            Project::orderBy('order')->orderByDesc('created_at')->get()
        );
    }

    public function store(Request $request)
    {
        if (! session('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'desc'       => 'required|string',
            'image'      => 'nullable|image|max:5120',
            'tags'       => 'required|string',
            'year'       => 'required|string|size:4',
            'category'   => 'required|in:Frontend,Backend,Full Stack',
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

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
        }

        $project = Project::create([
            'title'      => $data['title'],
            'desc'       => $data['desc'],
            'image'      => $imagePath,
            'tags'       => array_map('trim', explode(',', $data['tags'])),
            'year'       => $data['year'],
            'category'   => $data['category'],
            'bg'         => $bgs[Project::count() % count($bgs)],
            'demo_url'   => $data['demo_url'] ?? null,
            'github_url' => $data['github_url'] ?? null,
            'order'      => 0,
        ]);

        return response()->json($project, 201);
    }

    public function update(Request $request, Project $project)
    {
        if (! session('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'desc'       => 'required|string',
            'image'      => 'nullable|image|max:5120',
            'tags'       => 'required|string',
            'year'       => 'required|string|size:4',
            'category'   => 'required|in:Frontend,Backend,Full Stack',
            'demo_url'   => 'nullable|url',
            'github_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            if ($project->image) {
                \Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update([
            'title'      => $data['title'],
            'desc'       => $data['desc'],
            'image'      => $data['image'] ?? $project->image,
            'tags'       => array_map('trim', explode(',', $data['tags'])),
            'year'       => $data['year'],
            'category'   => $data['category'],
            'demo_url'   => $data['demo_url'] ?? null,
            'github_url' => $data['github_url'] ?? null,
        ]);

        return response()->json($project->fresh());
    }

    public function destroy(Project $project)
    {
        if (! session('is_admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($project->image) {
            \Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
