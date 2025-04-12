<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    // Homepage
    public function index()
    {
        $latest_articles = Article::orderBy('created_at', 'desc')->take(6)->get();  // Ambil 6 artikel
        $populer_articles = Article::orderBy('views', 'desc')->take(6)->get();  // Ambil 6 artikel populer
        return view('front.index', compact('latest_articles', 'populer_articles'));
    }


    // Daftar semua artikel
    public function articles()
    {
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('front.articles', compact('articles'));
    }

    // Halaman kontak
    public function contact()
    {
        return view('front.contact');
    }

    // Menampilkan detail artikel berdasarkan ID
    public function show($id)
    {
        $article = Article::findOrFail($id);

        // Tambahkan jumlah view setiap kali dibuka (opsional)
        $article->increment('views');

        return view('front.article_show', compact('article'));
    }
}
