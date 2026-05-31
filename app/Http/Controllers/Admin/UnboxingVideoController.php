<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UnboxingVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UnboxingVideoController extends Controller
{
    public function index()
    {
        UnboxingVideo::syncLegacyDefaults();

        $videos = UnboxingVideo::latest()->paginate(10);

        return view('admin.unboxing-videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.unboxing-videos.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'video' => 'required|file|mimes:mp4,webm,mov|max:102400',
        ]);

        $data['video_path'] = $this->storeVideo($request);
        unset($data['video']);

        UnboxingVideo::create($data);

        return redirect()->route('admin.unboxing-videos.index')->with('success', 'Відео додано.');
    }

    public function edit(UnboxingVideo $unboxingVideo)
    {
        return view('admin.unboxing-videos.edit', compact('unboxingVideo'));
    }

    public function update(Request $request, UnboxingVideo $unboxingVideo)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'video' => 'nullable|file|mimes:mp4,webm,mov|max:102400',
        ]);

        if ($request->hasFile('video')) {
            $this->deleteVideoFile($unboxingVideo->video_path);
            $data['video_path'] = $this->storeVideo($request);
        }

        unset($data['video']);
        $unboxingVideo->update($data);

        return redirect()->route('admin.unboxing-videos.index')->with('success', 'Відео оновлено.');
    }

    public function destroy(UnboxingVideo $unboxingVideo)
    {
        $this->deleteVideoFile($unboxingVideo->video_path);
        $unboxingVideo->delete();

        return back()->with('success', 'Відео видалено.');
    }

    private function storeVideo(Request $request): string
    {
        $file = $request->file('video');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileName = Str::uuid()->toString() . '.' . $extension;
        $destination = public_path('video');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $file->move($destination, $fileName);

        return 'video/' . $fileName;
    }

    private function deleteVideoFile(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $fullPath = public_path($relativePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
