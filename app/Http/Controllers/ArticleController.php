<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use App\Models\Subheading;
use App\Models\Paragraph;

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

    // Simpan artikel baru
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
        ]);

        // Handle thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Simpan artikel
        $article = new \App\Models\Article();
        $article->title = $request->title;
        $article->description = $request->description;
        $article->thumbnail = $thumbnailPath;
        $article->status = $request->status;
        $article->user_id = auth()->id(); // pastikan kolom ini ada
        $article->save();

        // Simpan subheadings dan paragraphs
        foreach ($request->subheadings as $subIndex => $subheading) {
            $savedSub = new \App\Models\Subheading();
            $savedSub->article_id = $article->id;
            $savedSub->title = $subheading['title'];
            $savedSub->order_number = $subIndex + 1;
            $savedSub->save();

            // Simpan paragraf untuk setiap subheading
            foreach ($subheading['paragraphs'] as $paraIndex => $paragraph) {
                $newParagraph = new \App\Models\Paragraph();
                $newParagraph->subheading_id = $savedSub->id; // gunakan PK yg benar
                $newParagraph->content = $paragraph['content'];
                $newParagraph->order_number = $paraIndex + 1;
                $newParagraph->save();
            }
        }

        return redirect()->route('admin.articles.manage')->with('success', 'Article created with subheadings and paragraphs.');
    }




    // Tampilkan form edit artikel
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }

    // Update artikel
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'      => 'required|in:Draft,Published',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $article->thumbnail = $thumbnailPath;
        }

        $article->title       = $request->title;
        $article->description = $request->description;
        $article->status      = $request->status;
        $article->save();

        return redirect()->route('admin.articles.manage')->with('success', 'Article updated successfully.');
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





}
