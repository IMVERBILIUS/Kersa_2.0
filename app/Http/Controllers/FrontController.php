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
        $populer_articles = Article::orderBy('views', 'desc')->take(3)->get();
        $articles = Article::orderBy('created_at', 'desc')->paginate(12); // Changed from get() to paginate(20)
        return view('front.articles', compact('articles', 'populer_articles'));
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
