<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use App\Models\Subheading;
use App\Models\Paragraph;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Tampilkan semua artikel
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'date');

        $articles = Article::query();

        switch ($sort) {
            case 'view':
                $articles->orderBy('views', 'desc');
                break;
            case 'status':
                $articles->orderBy('status', 'asc');
                break;
            default: // 'date'
                $articles->orderBy('created_at', 'desc');
                break;
        }

        $articles = $articles->paginate(6)->withQueryString(); // Keep query string during pagination

        return view('articles.manage', compact('articles'));
    }

    // Tampilkan form tambah artikel
    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:Draft,Published',
            'contents' => 'required|array',
            'contents.*.subtitle' => 'required|string|max:255',
            'contents.*.paragraphs' => 'required|array',
            'contents.*.paragraphs.*.content' => 'required|string',
        ]);

        // Handle Thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Resize & compress
            $resizedImage = Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($image->getClientOriginalExtension(), 75);

            \Storage::disk('public')->put('thumbnails/' . $imageName, $resizedImage);
            $thumbnailPath = 'thumbnails/' . $imageName;
        }

        // Save Gallery
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->thumbnail = $thumbnailPath;
        $gallery->status = $request->status;
        $gallery->user_id = auth()->id();  // Assuming you're saving the user's ID
        $gallery->save();

        // Save Gallery Contents and Subtitles
        foreach ($request->contents as $contentIndex => $content) {
            // Save Gallery Subtitle
            $savedSubtitle = new GallerySubtitle();
            $savedSubtitle->gallery_id = $gallery->id;
            $savedSubtitle->subtitle = $content['subtitle'];
            $savedSubtitle->save();

            // Save Paragraphs for this Subtitle
            foreach ($content['paragraphs'] as $paragraphIndex => $paragraph) {
                $newParagraph = new GalleryContent();
                $newParagraph->gallery_id = $gallery->id;
                $newParagraph->content = $paragraph['content'];  // Assuming "content" is required
                $newParagraph->created_at = now();
                $newParagraph->updated_at = now();
                $newParagraph->save();
            }
        }

        // Save Gallery Images (as per original code logic)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('gallery_images', $imageName, 'public');

                $galleryImage = new GalleryImage();
                $galleryImage->gallery_id = $gallery->id;
                $galleryImage->image = 'gallery_images/' . $imageName;
                $galleryImage->save();
            }
        }

        return redirect()->route('admin.galleries.manage')->with('success', 'Gallery created successfully.');
    }



    public function edit($id)
    {
        // Load article beserta subheadings dan paragraphs
        $article = Article::with('subheadings.paragraphs')->findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::with('subheadings.paragraphs')->findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'author'      => 'required|string|max:255',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:Draft,Published',
        ]);

        // Upload thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            $image = $request->file('thumbnail');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $resizedImage = Image::make($image)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->encode($image->getClientOriginalExtension(), 75);

            \Storage::disk('public')->put('thumbnails/' . $imageName, $resizedImage);
            $article->thumbnail = 'thumbnails/' . $imageName;
        }

        // Update artikel utama
        $article->title = $request->title;
        $article->description = $request->description;
        $article->status = $request->status;
        $article->author = $request->author;
        $article->save();

        // Simpan ID subheading dan paragraph yang masih ada
        $existingSubheadingIds = [];
        $existingParagraphIds = [];

        if ($request->has('subheadings')) {
            foreach ($request->subheadings as $subIndex => $subheadingData) {
                if (isset($subheadingData['id'])) {
                    $subheading = Subheading::find($subheadingData['id']);
                    if ($subheading) {
                        $subheading->title = $subheadingData['title'];
                        $subheading->order_number = $subIndex + 1;
                        $subheading->save();
                        $existingSubheadingIds[] = $subheading->id;
                    }
                } else {
                    $subheading = Subheading::create([
                        'article_id' => $article->id,
                        'title' => $subheadingData['title'],
                        'order_number' => $subIndex + 1,
                    ]);
                    $existingSubheadingIds[] = $subheading->id;
                }

                // Paragraphs
                if (isset($subheadingData['paragraphs'])) {
                    foreach ($subheadingData['paragraphs'] as $paraIndex => $paragraphData) {
                        if (isset($paragraphData['id'])) {
                            $paragraph = Paragraph::find($paragraphData['id']);
                            if ($paragraph) {
                                $paragraph->content = $paragraphData['content'];
                                $paragraph->order_number = $paraIndex + 1;
                                $paragraph->save();
                                $existingParagraphIds[] = $paragraph->id;
                            }
                        } else {
                            $newPara = Paragraph::create([
                                'subheading_id' => $subheading->id,
                                'content' => $paragraphData['content'],
                                'order_number' => $paraIndex + 1,
                            ]);
                            $existingParagraphIds[] = $newPara->id;
                        }
                    }
                }
            }
        }

        // Hapus subheadings yang tidak ada di request
        $article->subheadings()->whereNotIn('id', $existingSubheadingIds)->each(function ($sub) {
            $sub->paragraphs()->delete();
            $sub->delete();
        });

        // Hapus paragraphs yang tidak ada di request
        Paragraph::whereIn('subheading_id', $existingSubheadingIds)
            ->whereNotIn('id', $existingParagraphIds)
            ->delete();

        return redirect()->route('admin.articles.manage')->with('success', 'Article updated successfully.');
    }


    public function approval(Request $request)
    {
        // Get the sorting option from the query string, default to 'latest'
        $sort = $request->query('sort', 'latest');

        // Get draft articles
        $draftArticles = Article::where('status', 'draft');

        // Apply sorting
        if ($sort == 'newest') {
            $draftArticles->orderBy('created_at', 'desc');
        } else {
            $draftArticles->orderBy('created_at', 'asc');
        }

        // Paginate the results (6 articles per page)
        $draftArticles = $draftArticles->paginate(6);

        return view('articles.approval', compact('draftArticles'));
    }


    public function updateStatus(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->status = 'published';
        $article->save();

        return redirect()->route('articles.approval')->with('success', 'Status updated to published.');
    }


    // Hapus artikel
    public function destroy($id)
    {
        $article = Article::with('subheadings.paragraphs')->findOrFail($id);

        // Hapus thumbnail jika ada dan valid path
        if ($article->thumbnail) {
            $thumbnailPath = storage_path('app/public/' . $article->thumbnail);
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath); // alternatif dari \Storage, langsung delete
            }
        }

        // Hapus relasi: paragraphs -> subheadings
        $article->subheadings->each(function ($sub) {
            $sub->paragraphs()->delete();
            $sub->delete();
        });

        $article->delete();

        return redirect()->route('admin.articles.manage')->with('success', 'Article and associated image deleted successfully.');
    }

    public function show($id)
    {
        $article = Article::with('subheadings.paragraphs')->findOrFail($id);
        return view('articles.show', compact('article'));
    }




}
