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
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('articles.manage', compact('articles'));
    }

    // Tampilkan form tambah artikel
    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:Draft,Published',
            'subheadings' => 'required|array',
            'subheadings.*.title' => 'required|string|max:255',
            'subheadings.*.paragraphs' => 'required|array',
            'subheadings.*.paragraphs.*.content' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

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

        $article = new Article();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->thumbnail = $thumbnailPath;
        $article->status = $request->status;
        $article->user_id = auth()->id();
        $article->author = $request->author;
        $article->save();

        foreach ($request->subheadings as $subIndex => $subheading) {
            $savedSub = new Subheading();
            $savedSub->article_id = $article->id;
            $savedSub->title = $subheading['title'];
            $savedSub->order_number = $subIndex + 1;
            $savedSub->save();

            foreach ($subheading['paragraphs'] as $paraIndex => $paragraph) {
                $newParagraph = new Paragraph();
                $newParagraph->subheading_id = $savedSub->id;
                $newParagraph->content = $paragraph['content'];
                $newParagraph->order_number = $paraIndex + 1;
                $newParagraph->save();
            }
        }

        return redirect()->route('admin.articles.manage')->with('success', 'Article created with subheadings and paragraphs.');
    }



    public function edit($id)
    {
        // Load article beserta subheadings dan paragraphs
        $article = Article::with('subheadings.paragraphs')->findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
{
    $article = Article::findOrFail($id);

    $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'nullable|string',
        'author'      => 'required|string|max:255',
        'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'status'      => 'required|in:Draft,Published',
    ]);

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
        $article->thumbnail = 'thumbnails/' . $imageName;
    }

    $article->title = $request->title;
    $article->description = $request->description;
    $article->status = $request->status;
    $article->author = $request->author;
    $article->save();

    if ($request->has('subheadings')) {
        foreach ($request->subheadings as $subIndex => $subheadingData) {
            if (isset($subheadingData['id'])) {
                $subheading = Subheading::find($subheadingData['id']);
                $subheading->title = $subheadingData['title'];
                $subheading->save();
            } else {
                $subheading = Subheading::create([
                    'article_id' => $article->id,
                    'title' => $subheadingData['title'],
                ]);
            }

            if (isset($subheadingData['paragraphs'])) {
                foreach ($subheadingData['paragraphs'] as $paraIndex => $paragraphData) {
                    if (isset($paragraphData['id'])) {
                        $paragraph = Paragraph::find($paragraphData['id']);
                        $paragraph->content = $paragraphData['content'];
                        $paragraph->save();
                    } else {
                        Paragraph::create([
                            'subheading_id' => $subheading->id,
                            'content' => $paragraphData['content'],
                        ]);
                    }
                }
            }
        }
    }

    return redirect()->route('admin.articles.manage')->with('success', 'Article updated successfully.');
}

    public function approval()
    {
        $draftArticles = Article::where('status', 'draft')->get();
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
        $article = Article::findOrFail($id);

        // Hapus thumbnail jika ada
        if ($article->thumbnail && \Storage::disk('public')->exists($article->thumbnail)) {
            \Storage::disk('public')->delete($article->thumbnail);
        }

        // Hapus relasi terkait, jika ada (misalnya subheadings dan paragraphs)
        $article->subheadings()->each(function ($sub) {
            $sub->paragraphs()->delete();
            $sub->delete();
        });

        $article->delete();

        return redirect()->route('admin.articles.manage')->with('success', 'Article deleted successfully.');
    }
    public function show($id)
    {
        $article = Article::with('subheadings.paragraphs')->findOrFail($id);
        return view('articles.show', compact('article'));
    }




}
