<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\GallerySubtitle;
use App\Models\GalleryContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort');

        $galleries = Gallery::query();

        if ($sort == 'view') {
            $galleries->orderByDesc('views');
        } elseif ($sort == 'latest') {
            $galleries->orderByDesc('created_at');
        } elseif ($sort == 'oldest') {
            $galleries->orderBy('created_at');
        } else {
            $galleries->latest(); // default
        }

        $galleries = $galleries->paginate(6);

        return view('galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'function' => 'required|string|max:255',
            'land_area' => 'required|integer',
            'building_area' => 'required|integer',
            'status' => 'required|in:Draft,Published',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|max:2048',
            'contents' => 'required|array',
            'contents.*.subtitle' => 'required|string|max:255',
            'contents.*.paragraphs' => 'required|array',
            'contents.*.paragraphs.*.content' => 'required|string',
        ]);

        // Store gallery
        $gallery = Gallery::create([
            'user_id' => auth()->id(),
            'author' => $request->author,
            'title' => $request->title,
            'location' => $request->location,
            'function' => $request->function,
            'land_area' => $request->land_area,
            'building_area' => $request->building_area,
            'thumbnail' => $request->file('thumbnail') ? $request->file('thumbnail')->store('thumbnails', 'public') : null,
            'status' => $request->status,
            'description' => $request->description,
        ]);

        // Store images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image' => $image->store('gallery_images', 'public'),
                ]);
            }
        }

        // Store subtitles and contents
        foreach ($request->contents as $subIndex => $subtitleData) {
            $subtitle = GallerySubtitle::create([
                'gallery_id' => $gallery->id,
                'order_number' => $subIndex + 1,
                'subtitle' => $subtitleData['subtitle'],
            ]);

            foreach ($subtitleData['paragraphs'] as $paraIndex => $paragraph) {
                GalleryContent::create([
                    'gallery_subtitle_id' => $subtitle->id,
                    'order_number' => $paraIndex + 1,
                    'content' => $paragraph['content'],
                ]);
            }
        }

        return redirect()->route('admin.galleries.manage')->with('success', 'Gallery created successfully!');
    }

    public function edit($id)
    {
        $gallery = Gallery::with([
            'images',
            'subtitles.contents' => function ($query) {
                $query->orderBy('order_number');
            }
        ])->findOrFail($id);

        return view('galleries.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'function' => 'nullable|string|max:255',
            'land_area' => 'nullable|integer',
            'building_area' => 'nullable|integer',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:Draft,Published',
            'description' => 'nullable|string',
            'update_images.*' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'contents' => 'nullable|array',
            'contents.*.subtitle' => 'required|string|max:255',
            'contents.*.paragraphs' => 'required|array',
            'contents.*.paragraphs.*.content' => 'required|string',
        ]);

        // Update thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($gallery->thumbnail) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $gallery->update($validated);

        // ✅ 1. Update existing images
        if ($request->hasFile('update_images')) {
            foreach ($request->file('update_images') as $imageId => $file) {
                $imageModel = GalleryImage::find($imageId);
                if ($imageModel && $file->isValid()) {
                    Storage::disk('public')->delete($imageModel->image);
                    $path = $file->store('gallery_images', 'public');
                    $imageModel->update(['image' => $path]);
                }
            }
        }

        // ✅ 2. Tambah gambar baru
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image' => $image->store('gallery_images', 'public'),
                ]);
            }
        }

        // ✅ 3. Tambah subtitle & paragraph baru
        if ($request->has('contents')) {
            foreach ($request->contents as $subIndex => $subtitleData) {
                $subtitle = GallerySubtitle::create([
                    'gallery_id' => $gallery->id,
                    'order_number' => $subIndex + 1,
                    'subtitle' => $subtitleData['subtitle'],
                ]);

                foreach ($subtitleData['paragraphs'] as $paraIndex => $paragraph) {
                    GalleryContent::create([
                        'gallery_subtitle_id' => $subtitle->id,
                        'order_number' => $paraIndex + 1,
                        'content' => $paragraph['content'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.galleries.manage')->with('success', 'Gallery updated successfully!');
    }


    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return redirect()->route('admin.galleries.manage')->with('success', 'Gallery deleted successfully!');
    }

    public function show($id)
    {
        $gallery = Gallery::with('images', 'subtitles.contents')->findOrFail($id);

        return view('galleries.show', compact('gallery'));
    }
}
